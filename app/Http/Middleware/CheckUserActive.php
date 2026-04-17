<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckUserActive
{
    public function handle($request, Closure $next)
    {
        if (
    Auth::check() &&
    Auth::user()->role !== 'super_admin' &&
    !Auth::user()->is_active
) {
    Auth::logout();
    return redirect('/login')->with('error','❌ Your account is blocked!');
}

        return $next($request);
    }
}