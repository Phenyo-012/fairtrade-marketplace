<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureSellerIsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $user = auth()->user();

        if (!$user->sellerProfile) {
            abort(403);
        }

       if (!$user->sellerProfile) {
            return redirect()->route('seller.setup');
        }

        if ($user->sellerProfile->onboarding_step < 3) {
            return redirect()->route('seller.onboarding');
        }

        // if (!$user->sellerProfile->kyc_submitted) {
        //     return redirect()->route('seller.kyc');
        // }

        if ($user->sellerProfile->verification_status !== 'approved') {
            return redirect()->route('seller.pending');
        }

        return $next($request);
    }
}
