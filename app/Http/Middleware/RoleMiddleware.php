<?php
// app/Http/Middleware/RoleMiddleware.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle($request, Closure $next, $role)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $roles = explode('|', $role);

        if (!in_array(Auth::user()->role, $roles)) {
            return redirect()->route('unauthorized');
        }

        return $next($request);
    }
}


