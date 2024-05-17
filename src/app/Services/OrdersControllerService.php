<?php

namespace App\Services;

use App\Http\Requests\OrderCommentRequest;
use App\Http\Requests\OrderFilesRequest;
use App\Http\Requests\SearchRequest;
use App\Http\Resources\Orders\OrderResource;
use App\Models\User;
use DateTime;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Arrear;
use App\Models\BankOperation;
use App\Models\ClientContactPersonDetail;
use App\Models\ClientBase;
use App\Models\Finance;
use App\Models\Lead;
use App\Models\Order;
use App\Models\ChangesHistory;
use App\Models\DocumentsPath;
use App\Models\OrderDatesMover;
use App\Models\Mover;
use App\Http\Requests\OrderFormRequest;
use App\Http\Requests\OrderDetailFormRequest;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;


/**
 * @property Builder[]|Collection $clients
 * @property Builder[]|Collection $clientContacts
 * @property Builder[]|Collection $users
 * @property Builder[]|Collection $movers
 * @property $brigadiers
 * @property $managers
 * @property Builder[]|Collection $moversAdds
 * @property $busyMovers
 * @property $orders
 */
class OrdersControllerService extends Controller
{
    protected RolesRoutingService $rolesRoutingService;
    private Order $orderModel;
    private ClientContactPersonDetail $clientContactPersonDetailModel;
    private ChangesHistory $changesHistoryModel;
    private DocumentsPath $documentsPathModel;
    private BankOperation $bankOperationModel;
    private Finance $financeModel;
    private FilesActivityService $filesActivityModel;

    public function __construct(
        RolesRoutingService       $rolesRoutingService,
        ChangesHistory            $changesHistoryModel,
        DocumentsPath             $documentsPathModel,
        Order                     $orderModel,
        BankOperation             $bankOperationModel,
        Finance                   $financeModel,
        ClientContactPersonDetail $clientContactPersonDetailModel,
        FilesActivityService      $filesActivityModel,

    )
    {
        $this->rolesRoutingService = $rolesRoutingService;
        $this->changesHistoryModel = $changesHistoryModel;
        $this->documentsPathModel = $documentsPathModel;
        $this->orderModel = $orderModel;
        $this->clientContactPersonDetailModel = $clientContactPersonDetailModel;
        $this->bankOperationModel = $bankOperationModel;
        $this->financeModel = $financeModel;
        $this->filesActivityModel = $filesActivityModel;

    }

    public function orderDateFilters(Request $request): Builder
    {
        $orderQuery = Order::query();
        $order = new Order();

        $order->applyCreatedAtFilters($orderQuery, $request->input('start_date'), $request->input('end_date'));
        $order->applyExecutionDateFilters($orderQuery, $request->input('start_execution_date'), $request->input('end_execution_date'));
        $order->applyMoverFilter($orderQuery, 'brigadier', $request->input('brigadier'));
        $order->applyMoverFilter($orderQuery, 'movers', $request->input('movers'));
        $order->applyManagerFilter($orderQuery, $request->input('manager'));
        $order->applyStatusFilter($orderQuery, $request->input('status'));
        $order->applyAmountFilters($orderQuery, $request->input('amount_from'), $request->input('amount_to'));
        $this->applySortAndOrder($orderQuery, $request->input('sort'), $request->input('order'));

        return $orderQuery;
    }


    private function applySortAndOrder(Builder $query, $sort, $order): void
    {
        if ($sort && $order) {
            if ($sort === 'company') {
                $query->join('client_bases', 'orders.client_id', '=', 'client_bases.id')
                    ->orderBy('client_bases.company', $order);
            } else if ($sort === 'brigadier') {
                $query->join('order_dates_movers', 'orders.id', '=', 'order_dates_movers.order_id')
                    ->orderBy('order_dates_movers.is_brigadier', $order);
            } else {
                $query->orderBy($sort, $order);
            }
        }
    }

    public function ordersActualDeletedFilters($orderQuery, $request, $user)
    {
        $status = $request->input('status');

        if ($status == 'Видалено') {
            $orders = $this->getDeletedOrders($orderQuery, $user, $request->query());
        } else {
            $orders = $this->getActualOrders($orderQuery, $user, $request->query());
        }
        return $orders;
    }

    private function filterOrders($orderQuery, $user, $trashed = false)
    {
        $query = $trashed ? $orderQuery->onlyTrashed() : $orderQuery;

        if ($user->is_manager) {
            return $query->where(function ($query) use ($user) {
                $query->where('user_manager_id', $user->id)
                    ->orWhere('status', 'Попереднє замовлення');
            });
        } elseif ($user->is_logist) {
            return $query->where('user_logist_id', '=', $user->id);
        }
        return $query;
    }

    private function getDeletedOrders($orderQuery, $user, $params)
    {
        return $this->filterOrders($orderQuery, $user, true)->paginate(10)->appends($params);
    }

    private function getActualOrders($orderQuery, $user, $params)
    {
        return $this->filterOrders($orderQuery, $user)->latest()->paginate(10)->appends($params);
    }

    public function orderIndexView($orders, $user): View|Application|Factory|JsonResponse|\Illuminate\Contracts\Foundation\Application
    {
        $data = $this->fetchData();

        if (request()->expectsJson()) {
            $clients = ClientBase::all();
            $clientContacts = ClientContactPersonDetail::all();
            return response()->json(compact('orders', 'clients', 'clientContacts'));

        }
        if ($user->is_logist) {
            return $this->prepareIndexView('index_logist', $orders, $data);
        } else if ($user->is_accountant) {
            return $this->prepareIndexView('index_accountant', $orders, $data);
        }
        return $this->prepareIndexView('index', $orders, $data);
    }

    public function orderCreateView(): View|Application|Factory|JsonResponse|\Illuminate\Contracts\Foundation\Application
    {
        $data = $this->createFetchData();
        $user = Auth::user();
        $roleData = $this->rolesRoutingService->getRoleData($user);

        return view('erp.parts.orders.create', array_merge(compact('roleData'), $data));

    }

    private function fetchData(): array
    {
        return [
            'users' => User::all(),
            'clients' => ClientBase::all(),
            'clientContacts' => ClientContactPersonDetail::all(),
            'managers' => Order::whereNotNull('user_manager_id')->with('user')->get()->pluck('user.id', 'user.name'),
            'movers' => OrderDatesMover::all(),
            'brigadiers' => OrderDatesMover::where('is_brigadier', true)->get(),
            'moversAdds' => Mover::all(),
            'busyMovers' => OrderDatesMover::whereHas('order', function ($query) {
                $query->whereDate('execution_date', '>', now());
            })->get(),
        ];
    }

    private function createFetchData(): array
    {
        return [
            'clients' => ClientBase::all(),
            'logists' => User::where('is_logist', true)->get(),
        ];
    }


    public function prepareIndexView($routePath, $orders, $data): View
    {
        $user = Auth::user();
        $roleData = $this->rolesRoutingService->getRoleData($user);

        return view('erp.parts.orders.' . $routePath, ['orders' => $orders, 'roleData' => $roleData] + $data);
    }

    public function orderSearchResults(SearchRequest $request)
    {
        $search = $request->input('search');

        return $this->orderModel->searchOrder($search);
    }

    public function orderSearchView($ordersQuery, $user): View|Application|Factory|JsonResponse|\Illuminate\Contracts\Foundation\Application
    {
        $data = $this->orderSearchData();
        $orders = $ordersQuery->latest()->paginate(10)->appends(request()->query());

        if (request()->expectsJson()) {
            $clientContacts = ClientContactPersonDetail::query()->get();
            $clients = ClientBase::all();
            return response()->json(compact('orders', 'clientContacts', 'clients'));

        }

        if ($user->is_logist) {
            return $this->prepareIndexView('index_logist', $orders, $data);
        } else if ($user->is_accountant) {
            return $this->prepareIndexView('index_accountant', $orders, $data);
        }
        return $this->prepareIndexView('index', $orders, $data);

    }

    private function orderSearchData(): array
    {
        return [
            'managers' => Order::whereNotNull('user_manager_id')->with('user')->get()->pluck('user.id', 'user.name'),
            'clients' => ClientBase::all(),
            'clientContacts' => ClientContactPersonDetail::query()->get(),
            'users' => User::all(),
            'brigadiers' => OrderDatesMover::where('is_brigadier', true)->get(),
            'moversAdds' => Mover::all(),
        ];
    }

    public function orderEditView($order): View|JsonResponse
    {
        $data = $this->orderEditData($order);

        if (request()->expectsJson()) {
            return $this->handleOrderEditJsonRequest($order, $data);
        }

        return $this->prepareOrderEditDefaultView($order, $data);
    }

    private function orderEditData($order): array
    {
        $clientContacts = ClientContactPersonDetail::all();
        $clients = ClientBase::all();
        $logists = User::where('is_logist', true)->get();

        return [
            'clients' => $clients,
            'clientContacts' => $clientContacts,
            'leads' => Lead::pluck('fullname', 'fullname')->all(),
            'logistsIds' => Order::pluck('user_logist_id')->all(),
            'logists' => $logists,
            'orderId' => $order->id,
            'orderDocuments' => $order->documentsPaths,
            'changesHistorys' => ChangesHistory::whereIn('order_id', [$order->id])->get(),
            'changesClientHistorys' => ChangesHistory::whereIn('client_contact_id', [$order->client_id])->get(),
            'users' => User::all(),
            'clientContact' => $order->client->clientContactPersonDetails->first(),
            'clientCompany' => $order->client,
            'executionDate' => $order->execution_date,
            'logistsJson' => json_encode($logists),
            'moversAdds' => Mover::all(),
        ];
    }

    private function handleOrderEditJsonRequest($order, $data): JsonResponse
    {
        return response()->json(compact('order'), $data);
    }

    private function prepareOrderEditDefaultView($order, $data): View
    {
        $user = Auth::user();
        $roleData = $this->rolesRoutingService->getRoleData($user);
        return view('erp.parts.orders.edit', ['order' => $order, 'roleData' => $roleData] + $data);

    }

    public function orderUpdate(OrderDetailFormRequest $request, Order $order): void
    {
        $orderOldValues = $order->getAttributes();
        $clientData = $this->updateOrderDetails($request, $order);
        $this->updateOrderExecutionDate($request, $order);
        $this->updateOrderClientDetails($request, $order, $clientData);
        $orderNewValues = $order->getAttributes();

        $user = Auth::user();
        foreach ($orderOldValues as $key => $OldValue) {
            $NewValue = $orderNewValues[$key] ?? null;
            if ($OldValue != $NewValue) {
                $this->changesHistoryModel->changeHistory($order->id, null, $OldValue, $NewValue, $key, $user);
            }
        }

//        return $order;
    }

    private function updateOrderDetails(OrderDetailFormRequest $request, Order $order)
    {
        $clientData = ClientContactPersonDetail::where('client_phone', $request->input('phone'))
            ->where('email', $request->input('email'))->first();
        if (isset($order->client_id)) {
            $clientData = ClientContactPersonDetail::where('client_base_id', $order->client_id)->first();
        }
        $order->update($request->all());

        return $clientData;
    }

    private function updateOrderExecutionDate(OrderDetailFormRequest $request, Order $order): void
    {
        $executionDateDate = $request->execution_date_date;
        $executionDateTime = $request->execution_date_time;

        if (!empty($executionDateDate) && !empty($executionDateTime)) {
            $executionDate = $executionDateDate . ' ' . $executionDateTime;
            $order->update([
                'execution_date' => $executionDate,
            ]);
        }
    }

    private function updateOrderClientDetails(OrderDetailFormRequest $request, Order $order, $clientData): void
    {
        $clientIdAdd = $request->client;
        if ($clientIdAdd) {
            $order->client_id = $clientIdAdd;
            $order->save();
            $clientOldValues = $clientData ? $clientData->getAttributes() : [];

            $clientData = $this->clientContactPersonDetailModel->updateClientContactPersonDetail($clientData, $request->fullname, $clientData->position, $request->phone, $request->email);

            $clientNewValues = $clientData->getAttributes();

            $user = Auth::user();
            foreach ($clientOldValues as $key => $OldValue) {
                $NewValue = $clientNewValues[$key] ?? null;
                if ($OldValue != $NewValue) {
                    $this->changesHistoryModel->changeHistory($order->id, null, $OldValue, $NewValue, 'complete_name', $user);
                }
            }
        }
        $order->update($request->all());
    }


    public function orderStore(OrderFormRequest $request)
    {
        $order = $this->storeOrderDetails($request);
        $this->storeOrderDetailsClientId($request, $order);

        return $order;
    }

    private function storeOrderDetails(OrderFormRequest $request)
    {
        $minOrdHrh = $request->min_order_hrs;
        $priceToCustomer = $request->price_to_customer;

        $order = Order::create($request->all());
        $order->execution_date = $request->execution_date_date . ' ' . $request->execution_date_time;
        $order->total_price = ($minOrdHrh * $priceToCustomer);
        $order->save();

        return $order;
    }

    private function storeOrderDetailsClientId(OrderFormRequest $request, $order): void
    {
        $clientIdAdd = $request->client;
        if ($clientIdAdd) {
            $order->client_id = $clientIdAdd;
            $order->save();
        }
    }


    public function orderDelete(Order $order): void
    {
        $order->status = 'Видалено';
        $order->save();
        $order->delete();
    }

    public function orderStatusCancellation(Order $order): void
    {
        $order->status = 'Скасовано';
        $order->user_manager_id = null;
        $order->save();
    }

    public function orderStatusReturn(Order $order): void
    {
        $order->status = 'Попереднє замовлення';
        $order->save();
    }

    public function orderAddFiles(OrderFilesRequest $request, $id, $user): DocumentsPath|array
    {
        $documentPath = [];
        $order = Order::findOrFail($id);
        if ($request->hasFile('deed_file')) {
            $path = $this->filesActivityModel->addFile($request, 'deed_file', "uploads/deeds/$id/");
            $fileName = basename($path);
            $this->changesHistoryModel->changeHistory($id, null, null, "Завантаження Договору: $fileName", 'deed', $user);
            $documentPath = $this->documentsPathModel->createDocumentsPath($id, $order->client_id, $path, 'Договiр', 'Завантажено');
        }

        if ($request->hasFile('invoice_file')) {
            $path = $this->filesActivityModel->addFile($request, 'invoice_file', "uploads/invoices/$id/");
            $fileName = basename($path);
            $this->changesHistoryModel->changeHistory($id, null, null, "Завантаження Рахунку: $fileName", 'invoice', $user);
            $documentPath = $this->documentsPathModel->createDocumentsPath($id, $order->client_id, $path, 'Рахунок', 'Завантажено');
        }

        if ($request->hasFile('act_file')) {
            $path = $this->filesActivityModel->addFile($request, 'act_file', "uploads/acts/$id/");
            $fileName = basename($path);
            $this->changesHistoryModel->changeHistory($id, null, null, "Завантаження Акту: $fileName", 'act', $user);
            $documentPath = $this->documentsPathModel->createDocumentsPath($id, $order->client_id, $path, 'Акт', 'Завантажено');
        }
        return $documentPath;
    }

    public function orderDeleteFiles($id, $user): void
    {
        $orderDocument = DocumentsPath::findOrFail($id);
        $order = Order::findOrFail($orderDocument->order_id);
        $deletedDocument = $orderDocument->path;
        $deletedDocumentName = $orderDocument->description;
        $documentPath = $this->orderDeleteDocument($id);

        $this->orderRemoveFolderPath($documentPath);
        $this->changesHistoryModel->changeHistory($order->id, null, null, $deletedDocument, 'deleted' . ' ' . $deletedDocumentName, $user);

    }

    private function orderDeleteDocument($id): string
    {
        $orderDocument = DocumentsPath::findOrFail($id);
        $documentPath = public_path($orderDocument->path);
        if (is_file($documentPath)) {
            unlink($documentPath);
        }
        $orderDocument->delete();

        return $documentPath;
    }

    private function orderRemoveFolderPath($documentPath): void
    {
        $folderPath = dirname($documentPath);

        if (is_dir($folderPath) && count(glob($folderPath . '/*')) === 0) {
            rmdir($folderPath);
        }
    }

    public function orderAddComment(OrderCommentRequest $request, $id, $user): void
    {
        $newComment = $request->comment;
        $newHistory = [];
        if ($request->hasFile('screenshot')) {
            $this->filesActivityModel->addFile($request, 'screenshot', "uploads/img/screenshots/");
            $this->changesHistoryModel->changeHistory($id, null, null, $newComment, 'newCommentWithScr', $user);
        } else {
            $this->changesHistoryModel->changeHistory($id, null, null, $newComment, 'newcomment', $user);
        }
    }

    public function orderToBankOperations($id)
    {

        $invoiceDocument = DocumentsPath::findOrFail($id);
        $client = ClientBase::findOrFail($invoiceDocument->client_id);
        $order = Order::findOrFail($invoiceDocument->order_id);

        $transactionDate = $this->orderBankOperationCreation($invoiceDocument, $client, $order);

        $this->orderNewFinanceItemCreation($order, $transactionDate);
        $this->orderDocumentsPathStatusUpdate($invoiceDocument);

        return $order;
    }

    private function orderBankOperationCreation($invoiceDocument, $client, $order)
    {
        $bankOperation = $this->bankOperationModel->newBankOperation($invoiceDocument, $client, $order);

        return $bankOperation->transaction_date;
    }

    private function orderNewFinanceItemCreation($order, $transactionDate): void
    {
        $newFinanceItem = $this->financeModel->newFinance($order, $transactionDate);
        $companyBalancePrev = $this->financeModel->companyBalance($newFinanceItem->id);
        $fullCompanyBalance = $this->fullCompanyBalance($companyBalancePrev, $order);

        $this->financeModel->companyBalanceUpdate($newFinanceItem, $fullCompanyBalance);
    }

    private function orderDocumentsPathStatusUpdate($invoiceDocument): void
    {
        $this->documentsPathModel->updateStatus($invoiceDocument);
    }

    private function fullCompanyBalance($companyBalancePrev, $order)
    {
        return $companyBalancePrev + $order->total_price - $order->price_to_workers;
    }

    /**
     * @throws Exception
     */

    public function orderAddMover(Request $request, $id): void
    {
        $order = Order::findOrFail($id);
        $userMoverIds = $request->input('user_mover_id', []);
        $orderDatesMover = new OrderDatesMover();
        foreach ($userMoverIds as $userMoverId) {
            $allMovers = $this->getAllMoversForOrder($userMoverId);
            $existingMover = $orderDatesMover->getExistingMoversForOrder($order->id, $userMoverId);
            if (!$existingMover) {
                $isBrigadier = $request->input('is_brigadier_' . $userMoverId, 0);
                $isBusy = $this->checkMoverAvailability($allMovers, $order->execution_date);
                $orderDatesMover->createOrderDatesMover($id, $userMoverId, $isBrigadier, $isBusy);
            }
        }
    }

    private function getAllMoversForOrder($id)
    {
        return OrderDatesMover::whereIn('user_mover_id', [$id])->get();

    }

    /**
     * @throws Exception
     */
    private function checkMoverAvailability($allMovers, $orderExecDate): bool
    {
        foreach ($allMovers as $mover) {
            if (!empty($mover->order->execution_date)) {
                $existingExecutionDate = new DateTime($mover->order->execution_date);
                $orderExecutionDate = new DateTime($orderExecDate);

                if ($existingExecutionDate->format('Y-m-d') == $orderExecutionDate->format('Y-m-d')) {
                    return true;
                }
            }
        }
        return false;
    }

    public function orderCompletion(Request $request, $id): void
    {
        $order = Order::findOrFail($id);

        if ($request->input('request') == 'Виконано') {
            $this->completeOrder($order);
        } else if ($request->input('request') == 'В роботі') {
            $this->orderModel->updateStatus($order, 'В роботі');

        }
    }

    private function completeOrder(Order $order): void
    {
        $this->orderModel->updateStatus($order, 'Виконано');

        $arrear = new Arrear();

        if (count($order->documentsPaths->where('description', 'Рахунок сплачено')) == 0) {
            $arrear->createArrear($order);
        }
    }

    public function orderTakeAtWork($id, $user): void
    {
        $order = Order::findOrFail($id);
        $order->update([
            'user_manager_id' => $user->id,
            'status' => 'В роботі',
        ]);
    }

    public function returnAllOrdersJson($orders): AnonymousResourceCollection
    {
        return OrderResource::collection($orders);
    }

    public function returnOrderJson($order): JsonResponse
    {
        return response()->json([
            'data' => OrderResource::make($order),
        ]);

    }

    public function orderEditReturn($id, $user): RedirectResponse
    {
        $order = Order::findOrFail($id);
        $roleData = $this->rolesRoutingService->getRoleData($user);
        return redirect()->route($roleData['roleData']['order_edit'], ['order' => $order]);
    }

    public function orderIndexReturn($user): RedirectResponse
    {
        $roleData = $this->rolesRoutingService->getRoleData($user);
        return redirect()->route($roleData['roleData']['order_index']);
    }
}


