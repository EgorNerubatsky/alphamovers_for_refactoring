<?php

namespace App\Services;


use App\Models\Finance;
use Carbon\Carbon;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class FinanceControllerService extends Controller

{
    protected RolesRoutingService $rolesRoutingService;
    private Finance $financeModel;

    public function __construct(
        RolesRoutingService $rolesRoutingService,
        Finance             $financeModel
    )
    {
        $this->rolesRoutingService = $rolesRoutingService;
        $this->financeModel = $financeModel;
    }

    public function financeDateFilters(Request $request): Builder
    {

        $financeQuery = Finance::query();

        $this->financeModel->applyFinanceStartDateFilters($financeQuery, $request->input('start_date'), $request->input('end_date'));
        $this->financeModel->applyFinanceEndDateFilters($financeQuery, $request->input('start_date'), $request->input('end_date'));
        $this->financeModel->applyFinanceDateFilters($financeQuery, $request->input('start_date'), $request->input('end_date'));

        return $financeQuery;
    }

    public function financeGroupedData($financeQuery)
    {
        return $financeQuery->get()->groupBy(function ($query) {
            return Carbon::parse($query->transaction_date)->format('d.m.Y');
        });
    }

    public function financeData($groupedData)
    {
        return $groupedData->map(function ($transactions) {
            return $transactions->sum('amount');
        })->values();
    }

    public function financeBalance($groupedData)
    {
        return $groupedData->map(function ($companyBalance) {
            return $companyBalance->max('company_balance');
        })->values();
    }

    public function financeIndexView($financeQuery): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $groupedData = $this->financeGroupedData($financeQuery);
        $labels = $groupedData->keys();
        $data = $this->financeData($groupedData);
        $balance = $this->financeBalance($groupedData);
        $user = Auth::user();
        $roleData = $this->rolesRoutingService->getRoleData($user);
        return view('erp.parts.finances.report', compact('labels', 'data', 'balance', 'groupedData', 'roleData'));
    }
}


