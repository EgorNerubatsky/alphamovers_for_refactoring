<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchRequest;
use App\Services\EmployeeControllerService;
use App\Services\RolesRoutingService;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserUpdateFormRequest;
use App\Http\Requests\AdminUserUpdateFormRequest;
use App\Http\Requests\UserStoreFormRequest;
use Illuminate\Support\Facades\Auth;


class EmployeeController extends Controller
{
    private EmployeeControllerService $employeeControllerService;
    private User $userModel;
    protected RolesRoutingService $rolesRoutingService;


    public function __construct(EmployeeControllerService $employeeControllerService, User $userModel,RolesRoutingService $rolesRoutingService)
    {
        $this->employeeControllerService = $employeeControllerService;
        $this->userModel = $userModel;
        $this->rolesRoutingService = $rolesRoutingService;


    }

    public function index(Request $request): View|Factory|\Illuminate\Foundation\Application|JsonResponse|Application
    {
        $employeeQuery = $this->employeeControllerService->employeeDateFilters($request);
        return $this->employeeControllerService->employeeIndexView($employeeQuery);
    }

    public function search(SearchRequest $request): \Illuminate\Foundation\Application|Factory|View|JsonResponse|Application|RedirectResponse
    {
        try {
            $employeeQuery = $this->employeeControllerService->employeeSearch($request);
            return $this->employeeControllerService->employeeIndexView($employeeQuery);
        } catch (Exception $e) {
            return back()->withErrors(['error' => "Произошла ошибка: " . $e->getMessage()]);
        }
    }

    public function edit($id): View|\Illuminate\Foundation\Application|Factory|Application
    {
        $user = Auth::user();
        $employee = $this->userModel->findUser($id);
        $roleData = $this->rolesRoutingService->getRoleData($user);

        return view('erp.parts.employees.edit', compact('employee','roleData'));
    }

    public function update(UserUpdateFormRequest $request, $id): RedirectResponse
    {
        try {
            $this->employeeControllerService->employeeUpdate($request, $id);
            return redirect()->route('erp.executive.employees.index');
        } catch (Exception $e) {
            return back()->withErrors(['error' => "Произошла ошибка: " . $e->getMessage()]);
        }
    }

    public function create(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        $user = Auth::user();
        $roleData = $this->rolesRoutingService->getRoleData($user);
        return view('erp.parts.employees.create', compact('roleData'));
    }

    public function store(UserStoreFormRequest $request): RedirectResponse
    {
        try {
            $user = Auth::user();
            $this->employeeControllerService->employeeStore($request);
            return $this->employeeControllerService->employeeIndexRedirect($user);
        } catch (Exception $e) {
            return back()->withErrors(['error' => "Произошла ошибка: " . $e->getMessage()]);
        }

    }

    public function delete($id): RedirectResponse
    {
        $this->employeeControllerService->deleteEmployee($id);
        return redirect()->back()->with('reload', true);
    }

    public function deleteEmployeeDocument($id): RedirectResponse
    {
        $this->employeeControllerService->deleteFile($id);
        return redirect()->back()->with('reload', true);
    }

    public function adminUpdate(AdminUserUpdateFormRequest $request, $id): RedirectResponse
    {
        $this->userModel->userUpdate($request, $id);
        return redirect()->route('erp.admin.employees.index');
    }
}
