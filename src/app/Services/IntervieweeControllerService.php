<?php

namespace App\Services;

use App\Http\Requests\SearchRequest;
use App\Http\Requests\IntervieweeFormRequest;
use App\Models\CandidatesFile;
use App\Models\Interviewee;
use App\Models\User;
use App\Models\UsersFile;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class IntervieweeControllerService extends Controller
{
    protected RolesRoutingService $rolesRoutingService;
    private Interviewee $intervieweeModel;
    private User $userModel;
    private CandidatesFile $candidatesFileModel;

    private         UsersFile $usersFileModel;

    private FilesActivityService $filesActivityModel;



    public function __construct(
        RolesRoutingService $rolesRoutingService,
        Interviewee         $intervieweeModel,
        User                $userModel,
        CandidatesFile      $candidatesFileModel,
        UsersFile $usersFileModel,
         FilesActivityService $filesActivityModel,
)
    {
        $this->rolesRoutingService = $rolesRoutingService;
        $this->intervieweeModel = $intervieweeModel;
        $this->userModel = $userModel;
        $this->candidatesFileModel = $candidatesFileModel;
        $this->usersFileModel = $usersFileModel;
        $this->filesActivityModel = $filesActivityModel;
    }

    public function intervieweeDateFilters(Request $request): Builder
    {
        $intervieweesQuery = Interviewee::query();

        $this->intervieweeModel->applyIntervieweeStartCallDateFilters($intervieweesQuery, $request->input('start_call_date'));
        $this->intervieweeModel->applyIntervieweeEndCallDateFilters($intervieweesQuery, $request->input('end_call_date'));
        $this->intervieweeModel->applyIntervieweeStartInterviewDateFilters($intervieweesQuery, $request->input('start_interview_date'));
        $this->intervieweeModel->applyIntervieweeEndInterviewDateFilters($intervieweesQuery, $request->input('end_interview_date'));
        $this->intervieweeModel->applyIntervieweeFullnameFilters($intervieweesQuery, $request->input('fullname'));
        $this->intervieweeModel->applyIntervieweePositionFilters($intervieweesQuery, $request->input('position'));
        $this->intervieweeModel->applyIntervieweeStartAgeFilters($intervieweesQuery, $request->input('start_age'));
        $this->intervieweeModel->applyIntervieweeEndAgeFilters($intervieweesQuery, $request->input('end_age'));
        $this->applySortAndOrder($intervieweesQuery, $request->input('sort'), $request->input('order'));

        return $intervieweesQuery;
    }

    public function applySortAndOrder(Builder $intervieweesQuery, $sort, $order): void
    {
        if ($sort && $order) {
            $intervieweesQuery->orderBy($sort, $order);
        }
    }

    public function intervieweesSearch(SearchRequest $request)
    {
        return $this->intervieweeModel->search($request);
    }

    public function intervieweeEdit($interviewee): View|Application|Factory|JsonResponse|\Illuminate\Contracts\Foundation\Application
    {
        $user = Auth::user();
        $roleData = $this->rolesRoutingService->getRoleData($user);
        $fullnameParts = explode(' ', $interviewee->fullname);
        $fullnameSurname = $fullnameParts[0] ?? '';
        $fullnameName = $fullnameParts[1] ?? '';
        $fullnamePatronymic = $fullnameParts[2] ?? '';
        $positions = ['HR', 'Бригадир', 'Вантажник', 'Бухгалтер', 'Керівник', 'Логіст', 'Менеджер'];
        $intervieweesFiles = CandidatesFile::where('interviewee_id', $interviewee->id)->get();

        return view('erp.parts.interviewees.edit', compact('interviewee', 'fullnameSurname', 'fullnameName', 'fullnamePatronymic', 'positions', 'intervieweesFiles', 'roleData'));

    }


    public function intervieweeUpdate(IntervieweeFormRequest $request, Interviewee $interviewee): void
    {
        $updatedInterviewee = $this->intervieweeModel->intervieweesUpdate($request, $interviewee);

        if($request->hasFile('interviewee_photo')){
            $this->intervieweeFileStore($request, $updatedInterviewee, 'photos', "interviewee_photo");
        }if($request->hasFile('interviewee_file')){
            $this->intervieweeFileStore($request, $updatedInterviewee, 'files', "interviewee_file");
        }

    }

    private function intervieweeFileStore($request, $interviewee, $fileType, $requestType): void
    {
        $path = $this->filesActivityModel->addFile($request, $requestType, "uploads/$fileType/interviewees/$interviewee->id/");
        $this->candidatesFileModel->createCandidatesFile($path, $interviewee, $fileType,'interviewee_id');
    }

    public function intervieweeRemoveToEmployees($id): RedirectResponse
    {
        $interviewee = Interviewee::findOrFail($id);

        $positions = ['HR', 'Бригадир', 'Вантажник', 'Бухгалтер', 'Керівник', 'Логіст', 'Менеджер'];
        $userRoles = array_fill_keys($positions, false);

        if (in_array($interviewee->position, $positions)) {
            $userRoles[$interviewee->position] = true;
        }
//            'fullname' => 'Авдєєв Леонід Олександрович',

        $intervieweeFullname = explode(' ', $interviewee->fullname);
        $intervieweeLastname = $intervieweeFullname[0] ?? '';
        $intervieweeName = $intervieweeFullname[1] ?? '';
        $intervieweeMiddleName = $intervieweeFullname[2] ?? '';
//        $intervieweeMiddleName = $intervieweeFullname[2] ?? '';

        $employee = $this->userModel->createUserFromInterviewee($interviewee, $userRoles, $intervieweeName, $intervieweeLastname,$intervieweeMiddleName);

        foreach($interviewee->candidatesFiles as $file){
            $filePath = $this->filesActivityModel->filesTransfer($employee, $file, 'users');
            $this->usersFileModel->createUserFile($filePath, $employee, $file->description);

        }
        $interviewee->delete();
        return $this->intervieweeIndexRedirect();
    }

    public function intervieweeIndexView($intervieweesQuery): View|Application|Factory|JsonResponse|\Illuminate\Contracts\Foundation\Application
    {
        $user = Auth::user();
        $roleData = $this->rolesRoutingService->getRoleData($user);
        $interviewees = $intervieweesQuery->paginate(10)->appends(request()->query());
        $intervieweesNames = $intervieweesQuery->pluck('fullname');
        $intervieweesPositions = $intervieweesQuery->pluck('position')->unique();

        if(request()->expectsJson()){
            return response()->json(compact('interviewees'));
        }

        return view('erp.parts.interviewees.index', compact('interviewees', 'intervieweesNames', 'intervieweesPositions', 'roleData'));
    }

    public function intervieweeDelete($id): RedirectResponse
    {
        $interviewee = Interviewee::findOrFail($id);
        foreach($interviewee->candidatesFiles as $files){
            $this->intervieweeFileDelete($files->id);
        }
        $this->intervieweeModel->deleteInterviewee($interviewee);
        return $this->intervieweeIndexRedirect();
    }


    public function intervieweeFileDelete($id): void
    {
        $file = CandidatesFile::findOrFail($id);
        if($file){
            $path = $file->path;
            $this->intervieweeDeleteFile($path);
            $file->delete();
        }
    }

    private function intervieweeDeleteFile($path): void
    {
        $filePath = public_path($path);
        if(is_file($filePath)){
            unlink($filePath);
        }

        $directory = dirname($filePath);
        if (is_dir($directory) && count(scandir($directory)) == 2){
            rmdir($directory);
        }
    }

    public function intervieweeIndexRedirect(): RedirectResponse
    {
        $user = Auth::user();
        $roleData = $this->rolesRoutingService->getRoleData($user);
        return redirect()->route($roleData['roleData']['interviewees_index']);
    }
}


