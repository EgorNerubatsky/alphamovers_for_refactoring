<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchRequest;
use App\Http\Resources\Leads\LeadResource;
use App\Models\Lead;
use App\Services\LeadsControllerService;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\LeadFormRequest;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;


class LeadController extends Controller
{
    private LeadsControllerService $leadsControllerService;

    public function __construct(LeadsControllerService $leadsControllerService)
    {
        $this->leadsControllerService = $leadsControllerService;
    }

    public function index(Request $request): \Illuminate\Foundation\Application|Factory|View|JsonResponse|AnonymousResourceCollection|Application
    {
        $leadQuery = $this->leadsControllerService->leadDateFilters($request);
        if (request()->expectsJson()) {
//            return response()->json([
//                'data'=>LeadResource::collection($leadQuery),
            $leads = $leadQuery->get();
            return LeadResource::collection($leads);
//            ]);
        }
        return $this->leadsControllerService->leadIndexView($leadQuery);

    }

    public function search(SearchRequest $request): Factory|\Illuminate\Foundation\Application|View|JsonResponse|Application|RedirectResponse
    {
        try {
            $leads = $this->leadsControllerService->leadSearch($request);
            return $this->leadsControllerService->leadIndexView($leads);

        } catch (Exception $e) {
            return back()->withErrors(['error' => "Произошла ошибка: " . $e->getMessage()]);
        }

    }

    public function update(LeadFormRequest $request, Lead $lead): \Illuminate\Foundation\Application|Factory|View|JsonResponse|Application|RedirectResponse
    {
        try {
            $lead->update($request->all());
            $this->leadsControllerService->updateLead($request, $lead);
            if (request()->expectsJson()) {
                return response()->json([
                    'data' => LeadResource::make($lead),
                ]);
            }
            return back()->with('reload', true);
        } catch (Exception $e) {
            return back()->withErrors(['error' => "Произошла ошибка: " . $e->getMessage()]);
        }
    }

    public function store(LeadFormRequest $request): JsonResponse|RedirectResponse
    {
        $lead = $this->leadsControllerService->storeLead($request);
        if (request()->expectsJson()) {
            return response()->json([
                'data' => LeadResource::make($lead),
            ]);

        }
        return redirect()->back()->with('reload', true);
    }

    public function show(Lead $lead): LeadResource
    {
        return LeadResource::make($lead);
    }

    public function toOrder($id): RedirectResponse
    {
        $this->leadsControllerService->leadsToOrdersRemove($id);

        return redirect()->back()->with('reload', true);

    }

    public function deleteFile($id): RedirectResponse
    {
        $this->leadsControllerService->deleteLeadFile($id);
        return redirect()->back()->with('reload', true);

    }

//    public function delete(Lead $lead): JsonResponse|RedirectResponse
//    {
//        if(request()->expectsJson()){
//            return response()->json([
//                'message'=>'done',
//            ]);
//        }
//        return $this->leadsControllerService->deleteLead($lead);
//
//    }

    public function destroy(Lead $lead): JsonResponse|RedirectResponse
    {
        $this->leadsControllerService->deleteLead($lead);

        if(request()->expectsJson()){
            return response()->json([
                'message'=>'done',
            ]);
        }
        return redirect()->back()->with('reload', true);


    }

}
