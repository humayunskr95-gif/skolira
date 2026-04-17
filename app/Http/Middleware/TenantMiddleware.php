<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\School;
use Illuminate\Support\Facades\URL;

class TenantMiddleware
{
    public function handle($request, Closure $next)
{
    $slug = $request->route('school'); // 🔥 important

    $school = \App\Models\School::where('slug', $slug)->first();

    if (!$school) {
        abort(404);
    }

    // optionally store globally
    app()->instance('school', $school);

    return $next($request);
}
}