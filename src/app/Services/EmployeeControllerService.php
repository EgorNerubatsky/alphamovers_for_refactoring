<?php

namespace App\Services;

use App\Http\Requests\SearchRequest;
use App\Http\Requests\UserStoreFormRequest;
use App\Http\Requests\UserUpdateFormRequest;
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


class EmployeeControllerService extends Controller
{
    protected RolesRoutingService $rolesRoutingService;
    private User $userModel;
    private UsersFile $usersFileModel;

    private FilesActivityService $filesActivityModel;

    public function __construct(
        RolesRoutingService  $rolesRoutingService,
        User                 $userModel,
        FilesActivityService $filesActivityModel,
        UsersFile            $usersFileModel,
    )
    {
        $this->rolesRoutingService = $rolesRoutingService;
        $this->userModel = $userModel;
        $this->filesActivityModel = $filesActivityModel;
        $this->usersFileModel = $usersFileModel;

    }

    public function employeeDateFilters(Request $request): Builder
    {
        $employeeQuery = User::query();

        $this->userModel->applyCreatedAtFilters($employeeQuery, $request->input('start_date'), $request->input('end_date'));
        $this->userModel->applyPositionFilters($employeeQuery, $request->input('position'));
        $this->userModel->applyPhoneFilters($employeeQuery, $request->input('phone'));
        $this->userModel->applyAgeFilters($employeeQuery, $request->input('age_from'), $request->input('age_to'));
        $this->applySortAndOrder($employeeQuery, $request->input('sort'), $request->input('order'));

        return $employeeQuery;
    }

    public function applySortAndOrder(Builder $query, $sort, $order): void
    {
        if ($sort && $order) {
            $query->orderBy($sort, $order);
        }
    }

    public function employeeSearch(SearchRequest $request)
    {
        $search = $request->input('search');
        return $this->userModel->searchUser($search, false);
    }

    public function employeeStore(UserStoreFormRequest $request): void
    {
        $employee = $this->userModel->createUser($request);

        if ($request->hasFile('employee_photo')) {
            $this->employeeFileStore($request, $employee, 'photos', "employee_photo");
        }
        if ($request->hasFile('employee_file')) {
            $this->employeeFileStore($request, $employee, 'files', "employee_file");
        }
    }

    public function employeeUpdate(UserUpdateFormRequest $request, $id): void
    {
        $employee = $this->userModel->findUser($id);
        $this->userModel->updateUser($request, $employee);
        if ($request->hasFile('employee_photo')) {
            $this->employeeFileStore($request, $employee, 'photos', "employee_photo");
        }
        if ($request->hasFile('employee_file')) {
            $this->employeeFileStore($request, $employee, 'files', "employee_file");
        }
    }

    private function employeeFileStore($request, $interviewee, $fileType, $requestType): void
    {
        $path = $this->filesActivityModel->addFile($request, $requestType, "uploads/$fileType/users/$interviewee->id/");
        $this->usersFileModel->createUserFile($path, $interviewee, $fileType);
    }


    public function deleteFile($id): void
    {
        $file = UsersFile::findOrFail($id);
        if ($file) {
            $path = $file->path;
            $this->filesActivityModel->deleteFile($path);
        }
        $file->delete();

    }

    public function deleteEmployee($id): void
    {
        $employee = User::findOrFail($id);
        foreach ($employee->usersFiles as $file){
            $this->filesActivityModel->deleteFile($file->path);
            $file->delete();
        }
        $employee->delete();
    }

    public function employeeIndexView($employeeQuery): View|Application|Factory|JsonResponse|\Illuminate\Contracts\Foundation\Application
    {
        $user = Auth::user();
        $roleData = $this->rolesRoutingService->getRoleData($user);
        $employeesPositions = ['Менеджер' => 'is_manager', 'HR' => 'is_hr', 'Бухгалтер' => 'is_accountant', 'Логiст' => 'is_logist', 'Директор' => 'is_executive',];
        $employees = $employeeQuery->paginate(10)->appends(request()->query());

        if (request()->expectsJson()) {
            return response()->json(compact('employees'));
        }

        return view('erp.parts.employees.index', compact('employees', 'employeesPositions', 'roleData'));
    }

    public function employeeIndexRedirect($user): RedirectResponse
    {
        $roleData = $this->rolesRoutingService->getRoleData($user);
        return redirect()->route($roleData['roleData']['employee_index']);

    }

}


