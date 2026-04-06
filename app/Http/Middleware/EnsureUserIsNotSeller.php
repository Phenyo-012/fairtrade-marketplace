<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureUserIsNotSeller
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->user()->sellerProfile) {
            return redirect()->route('seller.store.edit')
                ->with('error', 'You already have a store.');
        }

        return $next($request);
    }
}
