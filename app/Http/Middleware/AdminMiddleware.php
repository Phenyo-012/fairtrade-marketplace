<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check() || !auth()->user()->hasRole('admin')) {
            abort(403, 'Unauthorized');
        }

        if ($request->header('X-ADMIN-KEY') !== config('app.admin_creation_key')) {
            abort(403, 'Invalid admin key');
        }

        if (!auth()->user()->is_super_admin) {
            abort(403, 'Only super admins can access this route');
        }

        return $next($request);
    }
}