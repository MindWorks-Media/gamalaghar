<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        // If the request expects JSON, do nothing.
        if ($request->expectsJson()) {
            return null;
        }

        // Include the current URL as the 'redirect_to' parameter in the login route.
        return route('login', ['redirect_to' => $request->fullUrl()]);
    }
}

