<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Если пользователь уже аутентифицирован и у него нет роли, перенаправляем на страницу входа
        if (Auth::check() && !$user->is_admin && !$user->is_manager && !$user->is_hr && !$user->is_logist && !$user->is_accountant && !$user->is_executive) {
            return redirect()->route('login');
        }

        // Проверяем, есть ли у пользователя роль
        if ($user->is_admin || $user->is_manager || $user->is_hr || $user->is_logist || $user->is_accountant || $user->is_executive) {
            // Если есть роль, перенаправляем в соответствии с ролью
            $userRole = $user->is_admin ? RouteServiceProvider::HOME_ADMIN :
                ($user->is_manager ? RouteServiceProvider::HOME_MANAGER :
                    ($user->is_hr ? RouteServiceProvider::HOME_HR :
                        ($user->is_logist ? RouteServiceProvider::HOME_LOGIST :
                            ($user->is_accountant ? RouteServiceProvider::HOME_ACCOUNTANT :
                                ($user->is_executive ? RouteServiceProvider::HOME_EXECUTIVE :
                                    redirect()->route('login') // Если у пользователя нет роли, перенаправляем на страницу входа
                                )
                            )
                        )
                    )
                );

            Auth::login($user);

            return redirect($userRole);
        } else {
            // Если нет роли, перенаправляем на страницу входа
            return redirect()->route('login');
        }
    }


}
