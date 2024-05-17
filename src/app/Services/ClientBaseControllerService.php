<?php

namespace App\Services;

use App\Http\Requests\SearchRequest;
use App\Http\Requests\ClientCommentRequest;
use App\Http\Requests\ClientCreateFormRequest;
use App\Http\Requests\ClientUpdateFormRequest;
use App\Http\Requests\OrderFilesRequest;
use App\Http\Resources\Clients\ClientResource;
use App\Models\ChangesHistory;
use App\Models\ClientBase;
use App\Models\ClientContactPersonDetail;
use App\Models\DocumentsPath;
use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class ClientBaseControllerService extends Controller
{
    protected RolesRoutingService $rolesRoutingService;
    private ClientBase $clientBaseModel;
    private ChangesHistory $changesHistoryModel;
    private DocumentsPath $documentsPathModel;
    private ClientContactPersonDetail $clientContactPersonDetailModel;
    private FilesActivityService $filesActivityModel;


    public function __construct(
        RolesRoutingService       $rolesRoutingService,
        ClientBase                $clientBaseModel,
        ClientContactPersonDetail $clientContactPersonDetailModel,
        ChangesHistory            $changesHistoryModel,
        DocumentsPath             $documentsPathModel,
        FilesActivityService      $filesActivityModel,


    )
    {
        $this->rolesRoutingService = $rolesRoutingService;
        $this->clientBaseModel = $clientBaseModel;
        $this->clientContactPersonDetailModel = $clientContactPersonDetailModel;
        $this->changesHistoryModel = $changesHistoryModel;
        $this->documentsPathModel = $documentsPathModel;
        $this->filesActivityModel = $filesActivityModel;

    }

    public function clientsDateFilters(Request $request)
    {

        $clientQuery = ClientBase::select(
            'id',
            'created_at',
            'company',
            'type',
            'zip_code',
            'postal_address',
            'debt_ceiling',
            'director_name',
            'contact_person_position',
            'date_of_contract'
        );

        $this->clientBaseModel->applyClientStartDateFilters($clientQuery, $request->input('start_date'));
        $this->clientBaseModel->applyClientEndDateFilters($clientQuery, $request->input('end_date'));
        $this->clientBaseModel->applyClientTypeFilters($clientQuery, $request->input('type'));
        $this->clientBaseModel->applyClientCompanyFilters($clientQuery, $request->input('company'));
        $this->clientBaseModel->applyClientContactPersonFilters($clientQuery, $request->input('director_name'));
        $this->clientBaseModel->applyClientDirectorPositionFilters($clientQuery, $request->input('contact_person_position'));
        $this->applySortAndOrder($clientQuery, $request->input('sort'), $request->input('order'));

        return $clientQuery;
    }

    public function applySortAndOrder($clientQuery, $sort, $order): void
    {
        if ($sort && $order) {
            $clientQuery->orderBy($sort, $order);
        }
    }

    public function clientsSearch(SearchRequest $request)
    {
        return $this->clientBaseModel->search($request);
    }

    public function clientEdit($clientBase): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $user = Auth::user();
        $roleData = $this->rolesRoutingService->getRoleData($user);
        $clientId = $clientBase->id;
        $orders = ClientBase::find($clientId)->orders;
        $totalPrice = $orders->sum('total_price');
        $clientContacts = $clientBase->clientContactPersonDetails;
        $chahgesHistorys = ChangesHistory::whereIn('client_id', [$clientBase->id])->latest()->paginate(10)->appends(request()->query());

        $users = User::all();
        $clientDocuments = ClientBase::find($clientId)->documentsPaths;
        $orderServiceTypes = ["Розвантаження-завантаження", "Прибирання будівельного сміття", "Перевезення великогабаритних об'єктів"];

        return view('erp.parts.clients.edit', compact(
            'orders',
            'clientBase',
            'clientContacts',
            'users',
            'chahgesHistorys',
            'totalPrice',
            'clientDocuments',
            'orderServiceTypes',
            'roleData'));
    }

    public function clientUpdate(ClientUpdateFormRequest $request, ClientBase $clientBase): void
    {
        $this->clientChangesUpdate($request, $clientBase);
        $user = Auth::user();

        if ($request->client_contacts) {
            $this->clientContactChangesUpdate($request->client_contacts, $user);
        }

        if ($request->input('add_client_contacts')) {
            $this->newClientContactStore($request->add_client_contacts, $clientBase);
        }
//        return $this->clientIndexRedirect();
    }

    private function clientChangesUpdate($request, $clientBase): void
    {
        $clientOldValues = $clientBase->getAttributes();
        $clientBase = $this->clientBaseModel->clientBaseUpdate($request, $clientBase);
        $clientNewValues = $clientBase->getAttributes();

        $user = Auth::user();
        $this->historyUpdate($clientOldValues, $clientNewValues, $clientBase->id, $user);
    }

    private function clientContactChangesUpdate($clientContactsData, $user): void
    {
        foreach ($clientContactsData as $clientContactData) {
            $clientContactDetail = ClientContactPersonDetail::findOrFail($clientContactData['client_base_id']);

            $clientContactOldValues = $clientContactDetail->getAttributes();
            $clientContactDetail = $this->clientContactPersonDetailModel->updateClientContactPersonDetail
            (
                $clientContactDetail,
                $clientContactData['complete_name'],
                $clientContactData['position'],
                $clientContactData['client_phone'],
                $clientContactData['email']
            );

            $clientContactNewValues = $clientContactDetail->getAttributes();
            $this->historyUpdate($clientContactOldValues, $clientContactNewValues, $clientContactDetail->client_base_id, $user);

        }
    }

    private function newClientContactStore($newClientContactData, $clientBase): void
    {
        foreach ($newClientContactData as $contactPersonDetail) {
            $this->clientContactPersonDetailModel->createClientContactPersonDetail(
                $contactPersonDetail['name'] . ' ' . $contactPersonDetail['last_name'] . ' ' . $contactPersonDetail['full_name'],
                $contactPersonDetail['client_phone'],
                $contactPersonDetail['position'],
                $contactPersonDetail['email'],
                $clientBase,
            );
        }
    }

    private function historyUpdate($clientOldValues, $clientNewValues, $id, $user): void
    {
        foreach ($clientOldValues as $key => $clientOldValue) {
            $clientNewValue = $clientNewValues[$key];
            if ($clientOldValue != $clientNewValue) {
                $this->changesHistoryModel->changeHistory(null, $id, $clientOldValue, $clientNewValue, $key, $user);
            }
        }
    }


    public function clientCreate(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $clientTypes = ["Фізична особа", "Юридична особа"];
        $user = Auth::user();
        $roleData = $this->rolesRoutingService->getRoleData($user);
        return view('erp.parts.clients.create', compact('clientTypes', 'roleData'));
    }

    public function clientStore(ClientCreateFormRequest $request): ClientBase|RedirectResponse
    {
        $clients = ClientBase::pluck('company');
        $client = [];
        if (!$clients->contains($request->input('company'))) {
            $client = $this->clientBaseModel->createClient($request);
            $this->clientContactPersonDetailModel->createClientContactPersonDetail(
                $request->name . ' ' . $request->last_name . ' ' . $request->full_name,
                $request->client_phone,
                $request->position,
                $request->email,
                $client,
            );
//        return $client;

        } else {

            return back()->with('error', 'Компания уже существует');
        }

        return $client;
    }


    public function clientDelete($clientBase): void
    {
        $clientBase->clientContactPersonDetails()->delete();
        $clientBase->delete();
//        return $this->clientIndexRedirect();
    }

    public function contactDelete($id): RedirectResponse
    {
        $user = Auth::user();
        $clientContactPersonDetail = ClientContactPersonDetail::findOrFail($id);
        $clientContactPersonDetail->delete();

        return $this->clientEditRedirect($user, $clientContactPersonDetail->client_base_id);
    }

    public function clientAddComment(ClientCommentRequest $request, $id): ChangesHistory
    {
        $user = Auth::user();

        $newComment = $request->comment;

        if ($request->input('screenshot')) {
            $this->filesActivityModel->addFile($request, 'screenshot', "uploads/img/screenshots/");
            $changesHistory = $this->changesHistoryModel->changeHistory(null, $id, null, $newComment, 'newCommentWithScr', $user);

        } else {

            $changesHistory = $this->changesHistoryModel->changeHistory(null, $id, null, $newComment, 'newcomment', $user);

        }
//        return $this->clientEditRedirect($user, $id);
        return $changesHistory;

    }

    public function clientContactInfo(Request $request): JsonResponse
    {
        $clientId = $request->input('clientId');
        $clientContact = ClientBase::find($clientId)->clientContactPersonDetails->first();

        if ($clientContact) {
            return response()->json([
                'fullname' => $clientContact->complete_name,
                'phone' => $clientContact->client_phone,
                'email' => $clientContact->email,
            ]);
        } else {
            return response()->json([
                'fullname' => '',
                'phone' => '',
                'email' => '',
            ]);
        }
    }

    public function clientAddFiles(OrderFilesRequest $request, $id): RedirectResponse
    {
        $user = Auth::user();

        if ($request->hasFile('deed_file')) {
            $this->fileStore($request, 'deed_file', "uploads/deeds/$id/", $id, 'Завантаження Договору: ', 'deed', $user, 'deed_file_order', 'Договiр');
        }

        if ($request->hasFile('invoice_file')) {
            $this->fileStore($request, 'invoice_file', "uploads/invoices/$id/", $id, 'Завантаження Рахунку: ', 'invoice', $user, 'invoice_file_order', 'Рахунок');
        }

        if ($request->hasFile('act_file')) {
            $this->fileStore($request, 'act_file', "uploads/acts/$id/", $id, 'Завантаження Акту: ', 'act', $user, 'act_file_order', 'Акт');
        }

        return $this->clientEditRedirect($user, $id);
    }

    private function fileStore($request, $fileDescription, $storePath, $id, $loadingType, $reason, $user, $input, $description): void
    {
        $path = $this->filesActivityModel->addFile($request, $fileDescription, $storePath);
        $fileName = basename($path);
        $this->changesHistoryModel->changeHistory($request->$input, $id, null, "$loadingType $fileName", $reason, $user);
        $this->documentsPathModel->createDocumentsPath($request->$input, $id, $path, $description, 'Завантажено');
    }

    public function clientDeleteFile($id): RedirectResponse
    {
        $user = Auth::user();
        $clientDocument = DocumentsPath::findOrFail($id);
        $client = $clientDocument->client;
        $deletedDocument = basename($clientDocument->path);
        $deletedDocumentName = $clientDocument->description;

        $this->documentsPathModel->deleteDocumentsPath($deletedDocument, $clientDocument);
        $orderId = $clientDocument->order_id;
        $this->changesHistoryModel->changeHistory($orderId, $client->id, $deletedDocument, null, 'deleted' . ' ' . $deletedDocumentName, $user);

        return $this->clientEditRedirect($user, $client->id);

    }

    public function roleDataIndexReturn($clients, $clientTypes, $companys, $contactPersons, $clientContacts, $contactPersonPositions): View|Application|Factory|JsonResponse|\Illuminate\Contracts\Foundation\Application
    {
        $user = Auth::user();
        $roleData = $this->rolesRoutingService->getRoleData($user);

        return view('erp.parts.clients.index', compact('clients', 'clientTypes', 'companys', 'contactPersons', 'clientContacts', 'contactPersonPositions', 'roleData'));
    }

    public function clientIndexView($clientQuery): View|Application|Factory|JsonResponse|\Illuminate\Contracts\Foundation\Application
    {
        $clientTypes = $clientQuery->pluck('type')->unique();
        $contactPersons = $clientQuery->pluck('director_name')->unique();
        $contactPersonPositions = $clientQuery->pluck('contact_person_position')->unique();
        $companys = $this->clientBaseModel->companys($clientQuery);

        $clients = $clientQuery->latest()->paginate(10)->appends(request()->query());
        $clientContacts = ClientContactPersonDetail::query()->get();

        if (request()->expectsJson()) {
            return response()->json(compact('clients', 'clientContacts'));
        }

        return $this->roleDataIndexReturn($clients, $clientTypes, $companys, $contactPersons, $clientContacts, $contactPersonPositions);

    }

    public function checkCompany(Request $request): JsonResponse
    {
        $companyName = $request->input('company');
        $exists = ClientBase::where('company', $companyName)->exists();

        return response()->json(['exists' => $exists]);
    }

    public function checkClient(Request $request): JsonResponse
    {
        $phone = $request->input('client_phone');
        $exists = ClientContactPersonDetail::where('client_phone', $phone)->exists();

        return response()->json(['exists' => $exists]);
    }

    public function clientIndexRedirect(): RedirectResponse
    {
        $user = Auth::user();
        $roleData = $this->rolesRoutingService->getRoleData($user);
        return redirect()->route($roleData['roleData']['clients_index']);
    }

    public function clientEditRedirect($user, $id): RedirectResponse
    {
        $roleData = $this->rolesRoutingService->getRoleData($user);
        return redirect()->route($roleData['roleData']['clients_edit'], ['clientBase' => $id]);
    }

    public function clientJson($client): JsonResponse
    {

        if ($client instanceof ClientBase) {
            return response()->json([
                'data' => ClientResource::make($client),
            ]);
        } else {
            return response()->json([
                'data' => 'Компания уже существует',
            ]);
        }
    }

    public function returnClientJson($clientBase): JsonResponse
    {

        return response()->json([
            'data' => ClientResource::make($clientBase),
        ]);
    }
}


