<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;

class CheckIfBlocked
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->status == 'blocked') {
            return redirect()->route('blocked.notice');
        }
        return $next($request);
    }
}