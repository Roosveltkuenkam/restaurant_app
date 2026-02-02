<?php

namespace App\Http\Middleware\Web;

use Closure;
use Illuminate\Http\Request;

class EnsureWebAuthenticated
{
    public function handle(Request $request, Closure $next)
    {
        if (!session()->has('api_token') || !session()->has('user')) {
            return redirect()->route('login');
        }
        return $next($request);
    }
}
