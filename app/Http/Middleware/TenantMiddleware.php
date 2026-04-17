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
    $slug = $request->route('school');

    // 🔥 custom mapping
    if ($slug === 'skolira') {
        $slug = 'scholar-academy';
    }

    $school = \App\Models\School::where('slug', $slug)->first();

    if (!$school) {
        abort(404);
    }

    app()->instance('school', $school);

    return $next($request);
}
}