<?php

namespace App\Services;

use App\Http\Requests\SearchRequest;
use App\Models\Arrear;
use App\Models\ClientBase;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class ArrearsControllerService extends Controller
{
    protected RolesRoutingService $rolesRoutingService;
    private Arrear $arrearModel;

    public function __construct(
        RolesRoutingService $rolesRoutingService,
        Arrear              $arrearModel
    )
    {
        $this->rolesRoutingService = $rolesRoutingService;
        $this->arrearModel = $arrearModel;
    }

    public function arrearDateFilters(Request $request): Builder
    {
        $arrearQuery = Arrear::query();

        $this->arrearModel->applyArrearStartDateFilters($arrearQuery, $request->input('start_date'), $request->input('end_date'));
        $this->arrearModel->applyArrearEndDateFilters($arrearQuery, $request->input('start_date'), $request->input('end_date'));
        $this->arrearModel->applyArrearStartAndEndDateFilters($arrearQuery, $request->input('start_date'), $request->input('end_date'));
        $this->arrearModel->applyArrearTypeFilters($arrearQuery, $request->input('type'));
        $this->arrearModel->applyArrearCompanyFilters($arrearQuery, $request->input('company'));
        $this->arrearModel->applyArrearAmountFromFilters($arrearQuery, $request->input('amount_from'), $request->input('amount_to'));
        $this->arrearModel->applyArrearAmountToFilters($arrearQuery, $request->input('amount_from'), $request->input('amount_to'));
        $this->arrearModel->applyArrearAmountToAndFromFilters($arrearQuery, $request->input('amount_from'), $request->input('amount_to'));
        $this->applySortAndOrder($arrearQuery, $request->input('sort'), $request->input('order'));

        return $arrearQuery;
    }

    public function applySortAndOrder(Builder $arrearQuery, $sort, $order): void
    {
        if ($sort && $order) {
            if ($sort === 'type') {
                $arrearQuery->join('client_bases', 'arrears.client_id', '=', 'client_bases.id')
                    ->orderBy('client_bases.type', $order);
            } else if ($sort === 'company') {
                $arrearQuery->join('client_bases', 'arrears.client_id', '=', 'client_bases.id')
                    ->orderBy('client_bases.company', $order);
            } else if ($sort === 'contract_date') {
                $arrearQuery->join('orders', 'arrears.order_id', '=', 'orders.id')
                    ->orderBy('orders.created_at', $order);
            } else {
                $arrearQuery->orderBy($sort, $order);
            }
        }
    }

    public function arrearsSearch(SearchRequest $request)
    {
        return $this->arrearModel->search($request);
    }

    public function arrearsIndexView($arrearsQuery): View|Application|Factory|JsonResponse|\Illuminate\Contracts\Foundation\Application
    {
        $user = Auth::user();
        $roleData = $this->rolesRoutingService->getRoleData($user);
        $clientTypes = ClientBase::distinct()->pluck('type');
        $companys = ClientBase::distinct()->pluck('company');
        $arrears = $arrearsQuery->paginate(10)->appends(request()->query());
        if(request()->expectsJson()){
            return response()->json(compact('arrears'));
        }

        return view('erp.parts.clients.arrear', compact('arrears', 'clientTypes', 'companys', 'roleData'));
    }
}


