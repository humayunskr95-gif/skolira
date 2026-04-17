<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\School;
use Illuminate\Support\Facades\URL;

class TenantMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $host = $request->getHost();

        // 🔥 MAIN DOMAIN (NO SCHOOL BIND)
        $mainDomains = ['127.0.0.1', 'localhost'];

        if (in_array($host, $mainDomains)) {

            // ✅ VERY IMPORTANT: clear defaults
            URL::defaults([]);

            // ❌ No school bind
            app()->forgetInstance('currentSchool');

            return $next($request);
        }

        // 🔥 SUBDOMAIN LOGIC
        $parts = explode('.', $host);

        if (count($parts) < 2) {
            abort(404, 'Invalid domain');
        }

        $subdomain = $parts[0];

        // 🔍 Find school
        $school = School::where('slug', $subdomain)->first();

        if (!$school) {
            abort(404, 'School not found');
        }

        if (!$school->is_active) {
            abort(403, 'School is suspended');
        }

        // ✅ Bind globally
        app()->instance('currentSchool', $school);

        // ✅ Inject school param automatically
        URL::defaults([
            'school' => $school->slug
        ]);

        return $next($request);
    }
}