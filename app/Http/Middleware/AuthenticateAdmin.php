<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthenticateAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (session()->has('auth_user') && session()->get('auth_user')['is_admin'] == true) {
            return $next($request);
        }

        return redirect()->route('login')->with('error', 'You do not have access to the admin page.');
    }
}
