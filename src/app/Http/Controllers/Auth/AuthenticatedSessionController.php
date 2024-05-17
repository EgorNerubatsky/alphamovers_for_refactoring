<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     * @throws ValidationException
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $user = Auth::user();
        $request->session()->regenerate();

        $roleRoutes = [
            'admin' => '/ERP/admin/employees',
            'manager' => '/ERP/manager/leads',
            'hr' => '/ERP/hr/applicants',
            'logist' => '/ERP/logist/orders',
            'accountant' => '/ERP/accountant/orders',
            'executive' => '/ERP/executive/orders',
        ];

        foreach($roleRoutes as $role=>$route){
            if($user["is_$role"]){
                return redirect($route);
            }
        }

            return redirect()->route('login');

        }



    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
