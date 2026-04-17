<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\School;

class IdentifySchool
{
    public function handle(Request $request, Closure $next)
    {
        $host = $request->getHost();

        // example: scholar-academy.localhost
        $parts = explode('.', $host);

        // subdomain detect
        if (count($parts) > 2) {

            $subdomain = $parts[0];

            $school = School::where('slug', $subdomain)->first();

            if ($school) {

                // 🔥 IMPORTANT: bind into container
                app()->instance('currentSchool', $school);

            } else {
                abort(404, 'School not found');
            }
        }

        return $next($request);
    }
}