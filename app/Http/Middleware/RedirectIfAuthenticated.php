<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;
// dd($guards);
        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check() && $guard !== null) {
                // dd($guard);
                // Check the guard type and redirect accordingly
            return $guard === 'admin' ? redirect(RouteServiceProvider::AdminDashboard) : redirect(RouteServiceProvider::UserDashboard);
            }
        }

        return $next($request);
    }
}
