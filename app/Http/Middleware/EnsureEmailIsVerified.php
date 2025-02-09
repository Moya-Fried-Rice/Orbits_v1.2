<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureEmailIsVerified
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        // If the user is logged in but has NOT verified their email
        if ($user && !$user->hasVerifiedEmail) {
            // Allow them to access only the dashboard
            if ($request->route()->named('dashboard')) {
                return $next($request);
            }

            // Restrict access and redirect to the dashboard with a warning message
            return redirect()->route('dashboard')->with('warning', 'You must verify your email to access this page.');
        }

        return $next($request);
    }
}
