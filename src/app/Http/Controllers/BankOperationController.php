<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchRequest;
use App\Services\BankOperationControllerService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BankOperationController extends Controller
{
    private BankOperationControllerService $bankOperationControllerService;

    public function __construct(BankOperationControllerService $bankOperationControllerService)
    {
        $this->bankOperationControllerService = $bankOperationControllerService;
    }

    public function index(Request $request): View|\Illuminate\Foundation\Application|Factory|JsonResponse|Application
    {
        $bankOperationQuery = $this->bankOperationControllerService->bankOperationDateFilters($request);
        return $this->bankOperationControllerService->bankOperationIndexView($bankOperationQuery);
    }

    public function search(SearchRequest $request): View|Factory|\Illuminate\Foundation\Application|JsonResponse|Application
    {
        $bankOperationQuery = $this->bankOperationControllerService->bankOperationSearch($request);
        return $this->bankOperationControllerService->bankOperationIndexView($bankOperationQuery);
    }
}
