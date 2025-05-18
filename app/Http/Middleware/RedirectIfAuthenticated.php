<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            $roles = Auth::user()->roles->pluck('role_name')->map(fn($r) => strtolower($r));
            $redirectTo = '';
            if ($roles->contains('admin')) {
                $redirectTo = redirect()->intended('/admin/dashboard');
            } else {
                $redirectTo = redirect()->intended('/');
            }
            return $redirectTo;
        }

        return $next($request);
    }
}
