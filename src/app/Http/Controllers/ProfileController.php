<?php

namespace App\Http\Controllers;

use App\Http\Requests\PasswordUpdateRequest;
use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Requests\UserUpdateFormRequest;
use App\Models\User;
use App\Services\EmployeeControllerService;
use App\Services\RolesRoutingService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    protected RolesRoutingService $rolesRoutingService;

    private User $userModel;
    private EmployeeControllerservice $employeeModel;


    public function __construct(
        RolesRoutingService       $rolesRoutingService,
        User                      $userModel,
        EmployeeControllerservice $employeeModel,
    )
    {
        $this->rolesRoutingService = $rolesRoutingService;
        $this->userModel = $userModel;
        $this->employeeModel = $employeeModel;
    }

    public function edit(Request $request): View
    {
        $user = Auth::user();
        $employee = $request->user();

        $roleData = $this->rolesRoutingService->getRoleData($user);
        return view('profile.edit', compact('employee', 'roleData'));
    }

    /**
     * Update the user's profile information.
     */
//    public function update(ProfileUpdateRequest $request): RedirectResponse
//    {
//        $request->user()->fill($request->validated());
//
//
//        if ($request->user()->isDirty('email')) {
//            $request->user()->email_verified_at = null;
//        }
//
//        $request->user()->save();
//
//        return Redirect::route('profile.edit')->with('status', 'profile-updated');
//    }

    public function update(UserUpdateFormRequest $request, $id): RedirectResponse
    {
        try {
            $this->employeeModel->employeeUpdate($request, $id);
            return redirect()->back()->with('reload', true);
        } catch (Exception $e) {
            return back()->withErrors(['error' => "Произошла ошибка: " . $e->getMessage()]);
        }
    }

    public function passwordUpdate(PasswordUpdateRequest $request, $id): RedirectResponse
    {
        return $this->userModel->passwordUpdate($request, $id);
//         redirect()->back()->with('reload', true);
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
