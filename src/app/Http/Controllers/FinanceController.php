<?php

namespace App\Http\Controllers;

use App\Services\FinanceControllerService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class FinanceController extends Controller
{
    private FinanceControllerService $financeControllerService;

    public function __construct(FinanceControllerService $financeControllerService)
    {
        $this->financeControllerService = $financeControllerService;
    }

    public function index(Request $request): View|Factory|\Illuminate\Foundation\Application|Application
    {
        $financeQuery = $this->financeControllerService->financeDateFilters($request);
        return $this->financeControllerService->financeIndexView($financeQuery);

    }
}
