<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchRequest;
use App\Services\ArrearsControllerService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class ArrearController extends Controller
{
    private ArrearsControllerService $arrearsControllerService;

    public function __construct(ArrearsControllerService $arrearsControllerService)
    {
        $this->arrearsControllerService = $arrearsControllerService;
    }

    public function index(Request $request): View|Factory|\Illuminate\Foundation\Application|JsonResponse|Application
    {
        $arrearsQuery = $this->arrearsControllerService->arrearDateFilters($request);

        return $this->arrearsControllerService->arrearsIndexView($arrearsQuery);
    }

    public function search(SearchRequest $request): View|Factory|\Illuminate\Foundation\Application|JsonResponse|Application
    {
        $arrearsQuery = $this->arrearsControllerService->arrearsSearch($request);

        return $this->arrearsControllerService->arrearsIndexView($arrearsQuery);
    }
}
