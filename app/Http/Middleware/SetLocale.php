<?php

// SetLocale middleware removed — placeholder to avoid errors.

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        return $next($request);
    }
}
