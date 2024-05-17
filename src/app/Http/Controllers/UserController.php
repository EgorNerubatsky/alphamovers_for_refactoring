<?php

namespace App\Http\Controllers;

use App\Services\RolesRoutingService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\User;
use App\Http\Requests\EditUserRequest;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private User $userModel;
    private RolesRoutingService $rolesRoutingService;

    public function __construct(User $userModel, RolesRoutingService $rolesRoutingService)
    {
        $this->userModel = $userModel;
        $this->rolesRoutingService = $rolesRoutingService;
    }

    public function index(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        $users = User::paginate(10);
        $user = Auth::user();
        $roleData = $this->rolesRoutingService->getRoleData($user);
        return view('erp.parts.admin.index', compact('users', 'roleData'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user): View|\Illuminate\Foundation\Application|Factory|Application
    {
        $user = Auth::user();
        $roleData = $this->rolesRoutingService->getRoleData($user);
        return view('erp.parts.admin.edit', compact('user', 'roleData'));
    }

    /**
     * Update the specified resource in storage.
     * @throws AuthorizationException
     */
    public function update(EditUserRequest $request, User $user): RedirectResponse
    {
        $this->authorize('update', $user);

        $this->userModel->userAdminUpdate($request, $user);
//        $user->update([
//            'name' => $request->name,
//            'lastname' => $request->lastname,
//            'phone' => $request->phone,
//            'address' => $request->address,
//            'password'=>password_hash($request->password, PASSWORD_BCRYPT),
//            'is_admin' => $request->has('is_admin') ? $request->is_admin : false,
//            'is_manager' => $request->has('is_manager') ? $request->is_manager : false,
//            'is_executive' => $request->has('is_executive') ? $request->is_executive : false,
//            'is_hr' => $request->has('is_hr') ? $request->is_hr : false,
//            'is_accountant' => $request->has('is_accountant') ? $request->is_accountant : false,
//            'is_logist' => $request->has('is_logist') ? $request->is_logist : false,
//            'is_mover' => $request->has('is_mover') ? $request->is_mover : false,
//
//
//        ]);

        return redirect()->route('erp.admin.users.index');
    }

    /**
     * @throws AuthorizationException
     */
    public function delete(User $user): RedirectResponse
    {
        $this->authorize('delete', $user);
        $user->forceDelete();
        return redirect()->route('erp.admin.users.index');
    }
}
