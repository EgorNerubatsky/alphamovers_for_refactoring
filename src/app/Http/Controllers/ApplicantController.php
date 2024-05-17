<?php

namespace App\Http\Controllers;


use App\Http\Requests\SearchRequest;
use App\Services\ApplicantsControllerService;
use App\Services\RolesRoutingService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Applicant;
use App\Http\Requests\ApplicantFormRequest;
use Illuminate\Support\Facades\Auth;
use Exception;


class ApplicantController extends Controller
{
    private ApplicantsControllerService $applicantsControllerService;

    protected RolesRoutingService $rolesRoutingService;


    public function __construct(
        ApplicantsControllerService $applicantsControllerService,
        RolesRoutingService         $rolesRoutingService,

    )
    {
        $this->applicantsControllerService = $applicantsControllerService;
        $this->rolesRoutingService = $rolesRoutingService;

    }

    public function index(Request $request): View|Factory|\Illuminate\Foundation\Application|JsonResponse|Application
    {
        $applicantsQuery = $this->applicantsControllerService->applicantDateFilters($request);
        return $this->applicantsControllerService->applicantsIndexView($applicantsQuery);
    }


    public function search(SearchRequest $request): View|Factory|\Illuminate\Foundation\Application|JsonResponse|Application
    {
        $applicantsQuery = $this->applicantsControllerService->applicantsSearch($request);
        return $this->applicantsControllerService->applicantsIndexView($applicantsQuery);
    }

    public function create(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        $user = Auth::user();
        $roleData = $this->rolesRoutingService->getRoleData($user);
        return view('erp.parts.applicants.create', compact('roleData'));
    }

    public function store(ApplicantFormRequest $request): RedirectResponse
    {
        try {
            $user = Auth::user();
            $this->applicantsControllerService->applicantStore($request);
            return $this->applicantsControllerService->applicantIndexRedirect($user, 'applicants_index');

        } catch (Exception $e) {
            return back()->withErrors(['error' => "Произошла ошибка: " . $e->getMessage()]);
        }
    }

    public function edit(Applicant $applicant): View|Factory|\Illuminate\Foundation\Application|Application
    {
        return $this->applicantsControllerService->applicantEditView($applicant);
    }

    public function update(ApplicantFormRequest $request, Applicant $applicant): RedirectResponse
    {
        try {
            $this->applicantsControllerService->applicantUpdate($request, $applicant);
            $user = Auth::user();
            return $this->applicantsControllerService->applicantIndexRedirect($user, 'applicants_index');

        } catch (Exception $e) {
            return back()->withErrors(['error' => "Произошла ошибка: " . $e->getMessage()]);
        }
    }

    public function removeToInterviewee($id): RedirectResponse
    {
        $this->applicantsControllerService->toInterviewee($id);
        return redirect()->back()->with('reload', true);
    }

    public function deleteApplicantDocument($id): RedirectResponse
    {
        $this->applicantsControllerService->applicantFileDelete($id);
        return redirect()->back()->with('reload', true);
    }


    public function delete(Applicant $applicant): RedirectResponse
    {
        $this->applicantsControllerService->deleteApplicant($applicant);
        return redirect()->back()->with('reload', true);
    }
}
