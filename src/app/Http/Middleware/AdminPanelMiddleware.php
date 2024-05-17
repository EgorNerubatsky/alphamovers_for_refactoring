<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;

class AdminPanelMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    
    
    {


    if (auth()->check() && !auth()->user()->hasAnyRole(['is_admin', 'is_manager', 'is_hr', 'is_logist', 'is_accountant', 'is_executive'])) {
        abort(404, 'Ви не авторiзованi в системi Alphamovers як працiвнiк.');
    }
    
    return $next($request);
}

    // public function handle(Request $request, Closure $next): Response
    // {
    //     if (auth()->check() && (!auth()->user()->is_admin || !auth()->user()->is_manager)) {
    //         abort(404);
    //     }

    //     return $next($request);
    // }
}