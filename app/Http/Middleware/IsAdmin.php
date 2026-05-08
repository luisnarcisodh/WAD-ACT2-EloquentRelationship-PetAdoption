<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        // REQUIREMENT: Bawal pumasok ang di admin
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized Access. Admin privileges required.');
        }
        return $next($request);
    }
}
