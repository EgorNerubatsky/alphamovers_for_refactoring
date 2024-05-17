<?php

namespace App\Http\Controllers;

use App\Http\Requests\IntervieweeFilesRequest;
use App\Http\Requests\IntervieweePhotoRequest;
use App\Http\Requests\SearchRequest;
use App\Services\IntervieweeControllerService;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Interviewee;
use App\Http\Requests\IntervieweeFormRequest;
use Illuminate\Support\Facades\Auth;


class IntervieweeController extends Controller
{
    private IntervieweeControllerService $intervieweeControllerService;


    public function __construct(IntervieweeControllerService $intervieweeControllerService)
    {
        $this->intervieweeControllerService = $intervieweeControllerService;
    }

    public function index(Request $request): View|Factory|\Illuminate\Foundation\Application|JsonResponse|Application
    {
        $intervieweesQuery = $this->intervieweeControllerService->intervieweeDateFilters($request);

        return $this->intervieweeControllerService->intervieweeIndexView($intervieweesQuery);
    }

    public function search(SearchRequest $request): View|Factory|\Illuminate\Foundation\Application|JsonResponse|Application
    {
        $intervieweesQuery = $this->intervieweeControllerService->intervieweesSearch($request);

        return $this->intervieweeControllerService->intervieweeIndexView($intervieweesQuery);
    }

    public function edit(Interviewee $interviewee): View|Factory|\Illuminate\Foundation\Application|JsonResponse|Application
    {
        return $this->intervieweeControllerService->intervieweeEdit($interviewee);
    }

    public function update(IntervieweeFormRequest $request, Interviewee $interviewee): RedirectResponse
    {
        try {
            $this->intervieweeControllerService->intervieweeUpdate($request, $interviewee);
            return $this->intervieweeControllerService->intervieweeIndexRedirect();

        } catch (Exception $e) {
            return back()->withErrors(['error' => "Произошла ошибка: " . $e->getMessage()]);
        }
    }

//    public function addDocuments(IntervieweeFilesRequest $request, $id): RedirectResponse
//    {
//        return $this->intervieweeControllerService->intervieweeAddDocument($request, $id);
//    }
//
//    public function addPhoto(IntervieweePhotoRequest $request, $id): RedirectResponse
//    {
//        return $this->intervieweeControllerService->intervieweeAddPhoto($request, $id);
//
//    }

    public function removeToEmployees($id): RedirectResponse
    {
        return $this->intervieweeControllerService->intervieweeRemoveToEmployees($id);
    }

    public function deleteFile($id): RedirectResponse
    {
        $this->intervieweeControllerService->intervieweeFileDelete($id);
        return redirect()->back()->with('reload', true);
    }
    public function delete($id): RedirectResponse
    {
        return $this->intervieweeControllerService->intervieweeDelete($id);
    }
}
