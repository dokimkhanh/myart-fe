<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class AuthenticateToken
{
    public function handle(Request $request, Closure $next)
    {
        if (!session()->has('auth_user') || Cookie::get('auth_token') == null) {
            session()->flush();
            session()->save();

            Cookie::queue(Cookie::forget('auth_token'));
            return redirect()->route('login');
        }

        return $next($request);
    }
}
