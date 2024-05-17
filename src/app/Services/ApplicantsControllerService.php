<?php

namespace App\Services;

use App\Http\Requests\SearchRequest;
use App\Http\Requests\ApplicantFormRequest;
use App\Models\Applicant;
use App\Models\CandidatesFile;
use App\Models\Interviewee;
use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;


class ApplicantsControllerService extends Controller
{
    protected RolesRoutingService $rolesRoutingService;
    private Applicant $applicantModel;
    private User $userModel;
    private CandidatesFile $candidateFileModel;

    private Interviewee $intervieweeModel;

    private FilesActivityService $filesActivityModel;

    use HasFactory, SoftDeletes;

    public function __construct(
        RolesRoutingService  $rolesRoutingService,
        Applicant            $applicantModel,
        User                 $userModel,
        CandidatesFile       $candidateFileModel,
        Interviewee          $intervieweeModel,
        FilesActivityService $filesActivityModel,
    )
    {

        $this->rolesRoutingService = $rolesRoutingService;
        $this->applicantModel = $applicantModel;
        $this->userModel = $userModel;
        $this->candidateFileModel = $candidateFileModel;
        $this->intervieweeModel = $intervieweeModel;
        $this->filesActivityModel = $filesActivityModel;
    }

    public function applicantDateFilters(Request $request): Builder
    {
        $applicantsQuery = Applicant::query();
        $this->applicantModel->applyApplicantStartDateFilters($applicantsQuery, $request->input('start_date'));
        $this->applicantModel->applyApplicantEndDateFilters($applicantsQuery, $request->input('end_date'));
        $this->applicantModel->applyApplicantPhoneFilters($applicantsQuery, $request->input('phone'));
        $this->applicantModel->applyApplicantFullnameFilters($applicantsQuery, $request->input('fullname'));
        $this->applicantModel->applyApplicantDesiredPositionFilters($applicantsQuery, $request->input('desired_position'));
        $this->applySortAndOrder($applicantsQuery, $request->input('sort'), $request->input('order'));

        return $applicantsQuery;
    }

    public function applySortAndOrder(Builder $query, $sort, $order): void
    {
        if ($sort && $order) {
            $query->orderBy($sort, $order);
        }
    }


    public function applicantsSearch(SearchRequest $request)
    {
        return $this->applicantModel->search($request);
    }

    public function applicantStore(ApplicantFormRequest $request): void
    {
        $applicant = $this->applicantModel->createApplicant($request);
        if ($request->hasFile('applicant_photo')) {
            $this->applicantFileStore($request, $applicant, 'photos', "applicant_photo");
        }
        if ($request->hasFile('applicant_file')) {
            $this->applicantFileStore($request, $applicant, 'files', "applicant_file");
        }

    }

    public function applicantUpdate(ApplicantFormRequest $request, Applicant $applicant): void
    {
        $applicant = $this->applicantModel->updateApplicant($request, $applicant);

        if ($request->hasFile('applicant_photo')) {
            $this->applicantFileStore($request, $applicant, 'photos', "applicant_photo");
        }
        if ($request->hasFile('applicant_file')) {
            $this->applicantFileStore($request, $applicant, 'files', "applicant_file");
        }

    }

    private function applicantFileStore($request, $applicant, $fileType, $requestType): void
    {
        $path = $this->filesActivityModel->addFile($request, $requestType, "uploads/$fileType/applicants/$applicant->id/");
        $this->candidateFileModel->createCandidatesFile($path, $applicant, $fileType, 'applicant_id');
    }

    public function applicantFileDelete($id): void
    {
        $file = CandidatesFile::findOrFail($id);
        if ($file) {
            $path = $file->path;
            $this->filesActivityModel->deleteFile($path);
            $file->delete();
        }
    }

    public function toInterviewee($id): void
    {
        $applicant = Applicant::findOrFail($id);
        $interviewee = $this->intervieweeModel->intervieweeCreate($applicant);

        foreach ($applicant->candidatesFiles as $file) {
            $path = $this->filesActivityModel->filesTransfer($interviewee, $file, 'interviewees');
            $this->candidateFileModel->createCandidatesFile($path, $interviewee, $file->description, 'interviewee_id');
        }
        $applicant->delete();
    }

    public function deleteApplicant($applicant): void
    {
        foreach ($applicant->candidatesFiles as $file) {
            $this->filesActivityModel->deleteFile($file->path);
            $file->delete();
        }
        $applicant->delete();
    }

    public function applicantEditView($applicant): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $user = Auth::user();
        $fullnameParts = explode(' ', $applicant->fullname);
        $fullnameSurname = $fullnameParts[0] ?? '';
        $fullnameName = $fullnameParts[1] ?? '';
        $fullnamePatronymic = $fullnameParts[2] ?? '';
        $applicantFiles = CandidatesFile::where('applicant_id', $applicant->id)->get();
        $roleData = $this->rolesRoutingService->getRoleData($user);

        return view('erp.parts.applicants.edit', compact('applicant', 'fullnameSurname', 'fullnameName', 'fullnamePatronymic', 'applicantFiles', 'roleData'));
    }

    public function applicantIndexRedirect($user, $route): RedirectResponse
    {
        $roleData = $this->rolesRoutingService->getRoleData($user);
        return redirect()->route($roleData['roleData'][$route]);
    }


    public function applicantsIndexView($applicantsQuery): View|Application|Factory|JsonResponse|\Illuminate\Contracts\Foundation\Application
    {
        $user = Auth::user();
        $roleData = $this->rolesRoutingService->getRoleData($user);
        $applicants = $applicantsQuery->paginate(10)->appends(request()->query());

        if (request()->expectsJson()) {
            return response()->json(compact('applicants'));
        }

        $applicantsNames = $applicantsQuery->pluck('fullname');
        $applicantsPositions = $applicantsQuery->pluck('desired_position')->unique();

        return view('erp.parts.applicants.index', compact('applicants', 'applicantsNames', 'roleData', 'applicantsPositions'));
    }

}


