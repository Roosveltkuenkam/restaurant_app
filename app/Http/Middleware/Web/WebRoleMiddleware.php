<?php

namespace App\Http\Middleware\Web;

use Closure;
use Illuminate\Http\Request;

class WebRoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = session('user');
        if (!$user || !isset($user['roles'])) {
            return redirect()->route('login');
        }

        $userRoles = collect($user['roles'])->pluck('name')->all();
        $ok = count(array_intersect($roles, $userRoles)) > 0;

        if (!$ok) {
            abort(403, 'Forbidden (role)');
        }

        return $next($request);
    }
}
