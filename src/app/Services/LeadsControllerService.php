<?php

namespace App\Services;

use App\Http\Requests\LeadFileRequest;
use App\Http\Requests\LeadFormRequest;
use App\Http\Requests\SearchRequest;
use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ClientContactPersonDetail;
use App\Models\ClientBase;
use App\Models\Lead;
use App\Models\Order;
use App\Models\DocumentsPath;
use Illuminate\Support\Facades\Auth;

class LeadsControllerService extends Controller
{
    protected RolesRoutingService $rolesRoutingService;
    private Lead $leadModel;
    private ClientContactPersonDetail $clientContactPersonDetailModel;
    private Order $orderModel;
    private ClientBase $clientBaseModel;
    private DocumentsPath $documentsPathModel;
    private FilesActivityService $filesActivityModel;




    public function __construct(
        RolesRoutingService       $rolesRoutingService,
        Lead                      $leadModel,
        DocumentsPath             $documentsPathModel,
        ClientContactPersonDetail $clientContactPersonDetailModel,
        Order                     $orderModel,
        ClientBase                $clientBaseModel,
        FilesActivityService $filesActivityModel,

    )
    {
        $this->rolesRoutingService = $rolesRoutingService;
        $this->leadModel = $leadModel;
        $this->documentsPathModel = $documentsPathModel;
        $this->clientContactPersonDetailModel = $clientContactPersonDetailModel;
        $this->orderModel = $orderModel;
        $this->clientBaseModel = $clientBaseModel;
        $this->filesActivityModel = $filesActivityModel;

    }

    public function leadDateFilters(Request $request): Builder
    {
        $leadQuery = Lead::query();
        $lead = new Lead();

        $lead->applyCreatedAtFilters($leadQuery, $request->input('start_date'), $request->input('end_date'));
        $lead->applyStatusFilter($leadQuery, $request->input('status'));
        $this->applySortAndOrder($leadQuery, $request->input('sort'), $request->input('order'));

        return $leadQuery;
    }

    private function applySortAndOrder(Builder $query, $sort, $order): void
    {
        if ($sort && $order) {
            $query->orderBy($sort, $order);
        }
    }

    public function leadsToOrdersRemove($id): void
    {

        $clients = ClientBase::pluck('company')->toArray();
        $lead = Lead::find($id);
        $order = $this->orderModel->orderCreationFromLead($lead);

        if (!in_array($lead->company, $clients)) {
            $newClient = $this->clientBaseModel->createClientFromLead($lead);
            $this->clientContactPersonDetailModel->createClientContactPersonDetail($lead->fullname, $lead->phone, $lead->position ?? null, $lead->email, $newClient);
            $this->orderModel->updateOrder($order, $newClient);
        } else {
            $client = ClientBase::where('company', $lead->company)->first();
            $this->updateClientInformation($lead, $client);
            $this->orderModel->updateOrder($order, $client);
        }
        $this->documentsPathModel->updateDocumentsPath($lead, $order);
        $lead->delete();
    }

    public function storeLead(LeadFormRequest $request)
    {

        $newLead = $this->leadModel->createLead($request);

        if ($request['lead_file']) {

//            $path = $this->storeLeadFile($request);
            $path = $this->filesActivityModel->addFile($request, 'lead_file', "uploads/leads/$newLead->id/");
            $newLead->documentsPaths()->create([
                'path' => $path,
                'description' => 'Документ вiд замовника',
                'status' => 'Завантажено',
            ]);
        }
        return $newLead;
    }

    public function updateLead(LeadFormRequest $request, $lead): void
    {

        $updateLead = $this->leadModel->leadUpdate($request, $lead);
        if ($request['lead_file']) {

//            $path = $this->storeLeadFile($request);
            $path = $this->filesActivityModel->addFile($request, 'lead_file', "uploads/leads/$updateLead->id/");
            $updateLead->documentsPaths()->create([
                'path' => $path,
                'description' => 'Документ вiд замовника',
                'status' => 'Завантажено',
            ]);
        }
    }

    private function updateClientInformation($lead, $client): void
    {
        $clientContacts = $client->clientContactPersonDetails;
        $clientPhones = [];
        foreach ($clientContacts as $clientContact) {
            $clientPhones = array_merge($clientPhones, $clientContact->pluck('client_phone')->toArray());
        }
        if (!in_array($lead->phone, $clientPhones)) {
            $this->clientContactPersonDetailModel->createClientContactPersonDetail($lead->fullname, $lead->phone, $lead->position ?? null, $lead->email, $client);
        }
    }

    public function leadIndexView($leadQuery): View|Application|Factory|JsonResponse|\Illuminate\Contracts\Foundation\Application
    {
        $user = Auth::user();
        $leads = $leadQuery->latest()->paginate(10)->appends(request()->query());
        $documentsPaths = DocumentsPath::get();
        $roleData = $this->rolesRoutingService->getRoleData($user);

        if (request()->expectsJson()) {
            return response()->json(compact('leads', 'documentsPaths'));
        }
        return view('erp.parts.leads.index', compact('leads', 'documentsPaths', 'roleData'));
    }

    public function leadSearch(SearchRequest $request)
    {
        $search = $request->search;

        return $this->leadModel->leadSearch($search);
    }

    public function deleteLead(Lead $lead): void
    {
//        $user = Auth::user();
        if ($lead->documentsPaths()->exists()) {
            $lead->documentsPaths()->each(function ($file) use ($lead) {
                $file->delete();
            });
        }
        $this->leadModel->deleteLead($lead);
//        return $this->leadIndexReturn($user);
    }


    public function deleteLeadFile($id): void
    {
        $leadDocument = DocumentsPath::findOrFail($id);
        $deletedDocumentPath = $leadDocument->path;
        $this->leadDeleteDocument($deletedDocumentPath);
        $leadDocument->delete();
    }

    private function leadDeleteDocument($deletedDocumentPath): void
    {
        $documentPath = public_path($deletedDocumentPath);
        if (is_file($documentPath)) {
            unlink($documentPath);
        }
    }



    public function leadIndexReturn($user): RedirectResponse
    {
        $roleData = $this->rolesRoutingService->getRoleData($user);
        return redirect()->route($roleData['roleData']['leads_index']);
    }

}

