<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\School;

class SchoolMiddleware
{
    public function handle($request, Closure $next)
    {
        $slug = $request->route('school');

        $school = School::where('slug', $slug)->first();

        if (!$school) {
            abort(404, 'School not found');
        }

        // 🔥 Global access
        app()->instance('currentSchool', $school);

        return $next($request);
    }
}