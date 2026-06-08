<?php

namespace App\Http\Middleware;

use Closure;
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
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            $user = Auth::guard($guard)->user();
            if (in_array($user->user_type ?? '', ['admin', 'staff'])) {
                return redirect()->route('admin.dashboard');
            }
            if (($user->user_type ?? '') === 'seller') {
                return redirect()->route('seller.dashboard');
            }
            if (($user->user_type ?? '') === 'delivery_boy') {
                return redirect()->route('dashboard');
            }
            return redirect()->route('home');
        }

        return $next($request);
    }
}
