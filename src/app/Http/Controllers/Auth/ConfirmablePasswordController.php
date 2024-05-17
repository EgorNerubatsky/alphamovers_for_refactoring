<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class ConfirmablePasswordController extends Controller
{
    /**
     * Show the confirm password view.
     */
    public function show(): View
    {
        return view('auth.confirm-password');
    }

    /**
     * Confirm the user's password.
     */
    public function store(Request $request): RedirectResponse
    {
        if (! Auth::guard('web')->validate([
            'email' => $request->user()->email,
            'password' => $request->password,
        ])) {
            throw ValidationException::withMessages([
                'password' => __('auth.password'),
            ]);
        }

        $request->session()->put('auth.password_confirmed_at', time());

        if (Auth::user()->is_admin) {
            return redirect()->intended(RouteServiceProvider::HOME_ADMIN);
        } elseif (Auth::user()->is_manager) {
            return redirect()->intended(RouteServiceProvider::HOME_MANAGER);
        } elseif (Auth::user()->is_hr) {
            return redirect()->intended(RouteServiceProvider::HOME_HR);
        } elseif (Auth::user()->is_logist) {
            return redirect()->intended(RouteServiceProvider::HOME_LOGIST);
        } elseif (Auth::user()->is_accountant) {
            return redirect()->intended(RouteServiceProvider::HOME_ACCOUNTANT);
        } elseif (Auth::user()->is_executive) {
            return redirect()->intended(RouteServiceProvider::HOME_EXECUTIVE);
        } else {
            return redirect()->route('login');
        }

//        return redirect()->intended(RouteServiceProvider::HOME);
    }
}
