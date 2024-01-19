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
        if ($request->expectsJson()) {
            if ($request->routeIs('admin.*')) {
                Session()->flash('fail', 'You are not logged in');
                return route('admin.login');
            }
            if ($request->routeIs('client.*')) {
                Session()->flash('fail', 'You are not logged in');
                return route('client.login');
            }
            if ($request->routeIs('seller.*')) {
                Session()->flash('fail', 'You are not logged in');
                return route('client.login');
            }
            } else {
                // Redirect to the regular login route when not expecting JSON
                return route('/');
            }
    }
}
