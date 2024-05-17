<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchRequest;
use App\Services\MoversControllerService;
use App\Services\RolesRoutingService;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Mover;
use App\Http\Requests\MoverFormRequest;
use Illuminate\Support\Facades\Auth;


class MoverController extends Controller
{
    private MoversControllerService $moversControllerService;
    private Mover $moverModel;
    private Order $orderModel;

    protected RolesRoutingService $rolesRoutingService;


    public function __construct(
        MoversControllerService $moversControllerService, Mover $moverModel, Order $orderModel, RolesRoutingService $rolesRoutingService)
    {
        $this->moversControllerService = $moversControllerService;
        $this->moverModel = $moverModel;
        $this->orderModel = $orderModel;
        $this->rolesRoutingService = $rolesRoutingService;
    }

    public function index(Request $request): View|Factory|Application|JsonResponse|\Illuminate\Contracts\Foundation\Application
    {
        $moversQuery = $this->moversControllerService->moverDateFilters($request);
        return $this->moversControllerService->moversIndexView($moversQuery);
    }

    public function search(SearchRequest $request): View|Factory|Application|JsonResponse|\Illuminate\Contracts\Foundation\Application
    {
        $moversQuery = $this->moversControllerService->moversSearch($request);
        return $this->moversControllerService->moversIndexView($moversQuery);
    }

    public function edit($id): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $mover = Mover::findOrFail($id);
        $user = Auth::user();
        $roleData = $this->rolesRoutingService->getRoleData($user);

        return view('erp.parts.movers.edit', compact('mover', 'roleData'));
    }

    public function update(MoverFormRequest $request, $id): RedirectResponse
    {
        try {
            $user = Auth::user();
            $mover = Mover::findOrFail($id);
            $this->moversControllerService->moverUpdate($request, $mover);
            return $this->moversControllerService->moverIndexRedirect($user, 'movers_index');
        } catch (Exception $e) {
            return back()->withErrors(['error' => "Произошла ошибка: " . $e->getMessage()]);
        }
    }

    public function create(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $user = Auth::user();
        $roleData = $this->rolesRoutingService->getRoleData($user);
        return view('erp.parts.movers.create', compact('roleData'));
    }

    public function store(MoverFormRequest $request): RedirectResponse
    {
        try {
            $user = Auth::user();
            $this->moversControllerService->moverStore($request);
            return $this->moversControllerService->moverIndexRedirect($user, 'movers_index');
        } catch (Exception $e) {
            return back()->withErrors(['error' => "Произошла ошибка: " . $e->getMessage()]);
        }
    }


    public function planning(Request $request): View|Factory|Application|JsonResponse|\Illuminate\Contracts\Foundation\Application
    {
        $user = Auth::user();
        $orderQuery = Order::query();
        $this->orderModel->applyExecutionDateFilters($orderQuery, $request->input('start_date'), $request->input('end_date'));
        return $this->moversControllerService->moversPlanningView($orderQuery, $user);
    }

    public function planningSearch(SearchRequest $request): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $user = Auth::user();
        $roleData = $this->rolesRoutingService->getRoleData($user);
        $orders = $this->moversControllerService->moversPlanningSearch($request)->paginate(10);

        return view('erp.parts.movers.planning', compact('orders', 'roleData'));
    }


    public function delete($id): RedirectResponse
    {
        $this->moverModel->deleteMover($id);
        $user = Auth::user();
        return $this->moversControllerService->moverIndexRedirect($user, 'movers_index');


    }

    public function addBonus(Request $request, $id): RedirectResponse
    {
        $this->moverModel->addMoverBonus($request, $id);
        $user = Auth::user();
        return $this->moversControllerService->moverIndexRedirect($user, 'movers_planning');
    }

    public function payToMover($id): RedirectResponse
    {
        $this->moverModel->addMoverPaid($id);
        $user = Auth::user();
        return $this->moversControllerService->moverIndexRedirect($user, 'movers_planning');

    }


}
