<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string $role
     */
    public function handle($request, Closure $next, $role)
    {
        if (!auth()->check()) {
            return redirect('/login');
        }

        // Check if the authenticated user has the required role
        if (!auth()->user()->roles->contains('name', $role)) {
            abort(403, 'Unauthorized access.');
        }

        return $next($request);
    }
}