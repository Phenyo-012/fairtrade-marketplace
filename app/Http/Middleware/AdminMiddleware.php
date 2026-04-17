<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->user()->hasRole('admin') && !auth()->user()->is_super_admin) {
            abort(403);
        }

        return $next($request);
    }
}