<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        // We are telling Laravel not to run CSRF checks on our heartbeat route,
        // because we are already protecting it with the 'auth' middleware.
        '/activity/heartbeat', // <-- ADD THIS LINE
    ];
}