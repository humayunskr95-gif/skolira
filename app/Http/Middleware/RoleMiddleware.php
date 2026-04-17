<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = auth()->user();

        // 🔥 FIXED: no route()
        if (!$user) {
            return redirect('/login');
        }

        // case-insensitive match
        if (!in_array(strtolower($user->role), array_map('strtolower', $roles))) {
            abort(403, 'Unauthorized access');
        }

        return $next($request);
    }
}