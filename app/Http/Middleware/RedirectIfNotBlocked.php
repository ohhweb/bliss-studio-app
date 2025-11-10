<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfNotBlocked
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // First, make sure a user is actually logged in.
        if (auth()->check()) {
            
            // Check if the user's status is 'active' (meaning they are NOT blocked).
            if (auth()->user()->status === 'active') {
                // If they are active, redirect them to the homepage.
                return redirect()->route('home');
            }
        }

        // If the user IS blocked or a guest, allow them to see the page.
        return $next($request);
    }
}