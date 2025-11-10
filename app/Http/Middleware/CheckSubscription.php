<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSubscription
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // For API routes, user() is on the request. For web, auth()->user() is fine.
        $user = $request->user();

        // If no user is authenticated, the 'auth' middleware should have already handled it,
        // but we can check again for safety.
        if (!$user) {
            return redirect()->route('login');
        }

        // Check if the user's 'plan' column is set to a non-empty value.
        if (empty($user->plan)) {
            // If they don't have a plan, redirect them to the plans page.
            return redirect()->route('plans.index');
        }

        // If they are logged in and have a plan, let them proceed.
        return $next($request);
    }
}