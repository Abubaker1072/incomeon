<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class IsDeliveryBoy
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->user_type == 'delivery_boy' && !Auth::user()->banned) {
            return $next($request);
        }

        abort(404);
    }
}
