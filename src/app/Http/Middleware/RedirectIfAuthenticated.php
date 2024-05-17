<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    public function handle($request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {

            if (Auth::guard($guard)->check()) {
                $user = Auth::user();
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

                    return $next($request);
                }
            }

        return $next($request);
    }
}
