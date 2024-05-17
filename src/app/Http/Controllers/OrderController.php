<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderCommentRequest;
use App\Http\Requests\OrderFilesRequest;
use App\Http\Requests\SearchRequest;
use App\Http\Resources\Orders\OrderResource;
use App\Http\Resources\Orders\OrderStoreResource;
use App\Models\DocumentsPath;
use App\Services\OrdersControllerService;
use App\Services\RolesRoutingService;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDatesMover;
use App\Http\Requests\OrderFormRequest;
use App\Http\Requests\OrderDetailFormRequest;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;


class OrderController extends Controller
{
    private OrdersControllerService $orderControllerService;
    protected RolesRoutingService $rolesRoutingService;

    public function __construct(OrdersControllerService $orderControllerService, RolesRoutingService $rolesRoutingService)
    {
        $this->orderControllerService = $orderControllerService;
        $this->rolesRoutingService = $rolesRoutingService;
    }

    public function index(Request $request): \Illuminate\Foundation\Application|Factory|View|JsonResponse|AnonymousResourceCollection|Application
    {
        $user = Auth::user();
        $orderQuery = $this->orderControllerService->orderDateFilters($request);
        $orders = $this->orderControllerService->ordersActualDeletedFilters($orderQuery, $request, $user);

        if (request()->expectsJson()) {
            $this->orderControllerService->returnAllOrdersJson($orders);
//            $allOrders = $orders->all();
//            return OrderResource::collection($allOrders);
        }

        return $this->orderControllerService->orderIndexView($orders, $user);
    }


    public function search(SearchRequest $request): \Illuminate\Foundation\Application|Factory|View|JsonResponse|Application|RedirectResponse
    {
        $user = Auth::user();
        try {
            $orders = $this->orderControllerService->orderSearchResults($request);
            return $this->orderControllerService->orderSearchView($orders, $user);

        } catch (Exception $e) {
            return back()->withErrors(['error' => "Произошла ошибка: " . $e->getMessage()]);
        }
    }

    public function edit(Order $order): View|\Illuminate\Foundation\Application|Factory|JsonResponse|Application
    {
        return $this->orderControllerService->orderEditView($order);
    }


    public function update(OrderDetailFormRequest $request, Order $order): JsonResponse|RedirectResponse
    {
        $user = Auth::user();

        try {
            $this->orderControllerService->orderUpdate($request, $order);
            if (request()->expectsJson()) {
                $this->orderControllerService->returnOrderJson($order);


            }
            return $this->orderControllerService->orderIndexReturn($user);
        } catch (Exception $e) {
            return back()->withErrors(['error' => "Произошла ошибка: " . $e->getMessage()]);
        }
    }

    public function create(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return $this->orderControllerService->orderCreateView();
    }

    public function store(OrderFormRequest $request): JsonResponse|RedirectResponse
    {
        $user = Auth::user();
        try {
            $order = $this->orderControllerService->orderStore($request);
            if (request()->expectsJson()) {
                $this->orderControllerService->returnOrderJson($order);

//                return response()->json([
//                    'data' => OrderResource::make($order),
//                ]);
            }
            return $this->orderControllerService->orderIndexReturn($user);
        } catch (Exception $e) {
            return back()->withErrors(['error' => "Произошла ошибка: " . $e->getMessage()]);
        }
    }

    public function show(Order $order): OrderResource
    {
        return OrderResource::make($order);
    }

    public function destroy(Order $order): JsonResponse|RedirectResponse
    {
        $user = Auth::user();
        $this->orderControllerService->orderDelete($order);
        if(request()->expectsJson()){
            return response()->json([
                'message'=>'done',
            ]);
        }
        return $this->orderControllerService->orderIndexReturn($user);
    }


    public function cancellation(Order $order): ?RedirectResponse
    {
        $user = Auth::user();
        $this->orderControllerService->orderStatusCancellation($order);
        return $this->orderControllerService->orderIndexReturn($user);
    }

    public function return(Order $order): RedirectResponse
    {
        $user = Auth::user();

        $this->orderControllerService->orderStatusReturn($order);
        return $this->orderControllerService->orderIndexReturn($user);
    }

    public function addFiles(OrderFilesRequest $request, $id): OrderStoreResource|RedirectResponse
    {
        $user = Auth::user();

        try {
            $documentPath = $this->orderControllerService->orderAddFiles($request, $id, $user);
            if(request()->expectsJson()){
                return OrderStoreResource::make($documentPath);
            }
            return $this->orderControllerService->orderEditReturn($id, $user);
        } catch (Exception $e) {
            return back()->withErrors(['error' => "Произошла ошибка: " . $e->getMessage()]);
        }

    }

    public function deleteFile(int $id): RedirectResponse
    {
        try {
            $user = Auth::user();
            $orderDocument = DocumentsPath::findOrFail($id);
            $orderId = Order::findOrFail($orderDocument->order_id);
            $this->orderControllerService->orderDeleteFiles($id, $user);
            return $this->orderControllerService->orderEditReturn($orderId, $user);
        } catch (Exception $e) {
            return back()->withErrors(['error' => "Произошла ошибка: " . $e->getMessage()]);
        }
    }

    public function addComment(OrderCommentRequest $request, $id): ?RedirectResponse
    {
        try {
            $user = Auth::user();
            $this->orderControllerService->orderAddComment($request, $id, $user);
            return $this->orderControllerService->orderEditReturn($id, $user);
        } catch (Exception $e) {
            return back()->withErrors(['error' => "Произошла ошибка: " . $e->getMessage()]);
        }

    }

    public function toBankOperations($id): ?RedirectResponse
    {
        try {
            $user = Auth::user();
            $order = $this->orderControllerService->orderToBankOperations($id);
            $orderId = $order->id;
            return $this->orderControllerService->orderEditReturn($orderId, $user);
        } catch (Exception $e) {
            return back()->withErrors(['error' => "Произошла ошибка: " . $e->getMessage()]);
        }

    }

    public function addMover(Request $request, $id): RedirectResponse
    {
        try {
            $this->orderControllerService->orderAddMover($request, $id);
            return redirect()->route('erp.logist.orders.index');

        } catch (Exception $e) {
            return back()->withErrors(['error' => "Произошла ошибка: " . $e->getMessage()]);
        }
    }

    public function completion(OrdersControllerService $orderControllerService, Request $request, $id): RedirectResponse
    {
        try {
            $orderControllerService->orderCompletion($request, $id);
            return redirect()->route('erp.logist.orders.index');
        } catch (Exception $e) {
            return back()->withErrors(['error' => "Произошла ошибка: " . $e->getMessage()]);
        }
    }

    public function takeAtWork(OrdersControllerService $orderControllerService, $id): RedirectResponse
    {
        try {
            $user = Auth::user();
            $orderControllerService->orderTakeAtWork($id, $user);
            return redirect()->route('erp.manager.orders.index');
        } catch (Exception $e) {
            return back()->withErrors(['error' => "Произошла ошибка: " . $e->getMessage()]);
        }
    }

    public function removeMover($id): RedirectResponse
    {
        try {
            $removeMover = OrderDatesMover::findOrFail($id);
            $removeMover->delete();
            return redirect()->route('erp.logist.orders.index');
        } catch (Exception $e) {
            return back()->withErrors(['error' => "Произошла ошибка: " . $e->getMessage()]);
        }
    }
}
