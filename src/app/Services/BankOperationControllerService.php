<?php

namespace App\Services;

use App\Http\Requests\SearchRequest;
use App\Models\BankOperation;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class BankOperationControllerService extends Controller

{
    protected RolesRoutingService $rolesRoutingService;
    private BankOperation $bankOperationModel;

    public function __construct(
        RolesRoutingService $rolesRoutingService,
        BankOperation       $bankOperationModel,
    )
    {
        $this->rolesRoutingService = $rolesRoutingService;
        $this->bankOperationModel = $bankOperationModel;
    }

    public function bankOperationDateFilters(Request $request): Builder
    {
        $bankOperationQuery = BankOperation::query();

        $this->bankOperationModel->applyBankOperationStartDateFilters($bankOperationQuery, $request->input('start_date'), $request->input('end_date'));
        $this->bankOperationModel->applyBankOperationEndDateFilters($bankOperationQuery, $request->input('start_date'), $request->input('end_date'));
        $this->bankOperationModel->applyBankOperationDateFilters($bankOperationQuery, $request->input('start_date'), $request->input('end_date'));
        $this->bankOperationModel->applyBankOperationPayerFilters($bankOperationQuery, $request->input('payer'));
        $this->bankOperationModel->applyBankOperationBeneficiaryFilters($bankOperationQuery, $request->input('beneficiary'));
        $this->bankOperationModel->applyBankOperationAmountFromFilters($bankOperationQuery, $request->input('amount_from'), $request->input('amount_to'));
        $this->bankOperationModel->applyBankOperationAmountToFilters($bankOperationQuery, $request->input('amount_from'), $request->input('amount_to'));
        $this->bankOperationModel->applyBankOperationAmountToAndFromFilters($bankOperationQuery, $request->input('amount_from'), $request->input('amount_to'));
        $this->applySortAndOrder($bankOperationQuery, $request->input('sort'), $request->input('order'));

        return $bankOperationQuery;
    }

    public function applySortAndOrder(Builder $bankOperationQuery, $sort, $order): void
    {
        if ($sort && $order) {
            $bankOperationQuery->orderBy($sort, $order);
        }
    }

    public function bankOperationSearch(SearchRequest $request)
    {
        return $this->bankOperationModel->search($request);
    }

    public function bankOperationIndexView($bankOperationQuery): View|Application|Factory|JsonResponse|\Illuminate\Contracts\Foundation\Application
    {
        $user = Auth::user();
        $roleData = $this->rolesRoutingService->getRoleData($user);
        $payers = BankOperation::distinct()->pluck('payer');
        $beneficiarys = BankOperation::distinct()->pluck('beneficiary');
        $bankOperations = $bankOperationQuery->paginate(10)->appends(request()->query());

        if (request()->expectsJson()){
            return response()->json(compact('bankOperations'));
        }

        return view('erp.parts.finances.index', compact('bankOperations', 'payers', 'beneficiarys', 'roleData'));
    }
}


