<?php

use Illuminate\Support\Facades\Route;

if (!function_exists('tenant_route')) {

    function tenant_route($name, $params = [], $absolute = true)
{
    // 🔥 SUBDOMAIN (school site)
    if (app()->bound('currentSchool') && request()->routeIs('school.*')) {

        $routeName = 'school.' . $name;

        if (Route::has($routeName)) {
            return route($routeName, $params, $absolute);
        }
    }

    // 🔥 SCHOOL ADMIN PANEL
    if (Route::has('school_admin.' . $name)) {
        return route('school_admin.' . $name, $params, $absolute);
    }

    // 🔥 SUPER ADMIN
    if (Route::has('admin.' . $name)) {
        return route('admin.' . $name, $params, $absolute);
    }

    return '#';
}
}


// =======================================
// 🔥 NEW HELPER (FEATURE CHECK)
// =======================================

if (!function_exists('hasFeature')) {

    function hasFeature($feature)
    {
        $user = auth()->user();

        // ❌ No login
        if (!$user) return false;

        // 🔥 Super Admin = full access
        if ($user->role === 'super_admin') return true;

        // 🔥 Safe plan access
        $plan = optional(optional($user->school)->subscription)->plan;

        return $plan && isset($plan->$feature) && $plan->$feature == 1;
    }
}


if (!function_exists('hasLimit')) {

    function hasLimit($feature)
    {
        $user = auth()->user();

        if (!$user) return false;

        if ($user->role === 'super_admin') return true;

        $plan = optional(optional($user->school)->subscription)->plan;

        // 🔥 plural map
        $map = [
            'teacher' => 'teachers',
            'student' => 'students',
            'parent'  => 'parents',
        ];

        if (isset($map[$feature])) {
            $feature = $map[$feature];
        }

        // ✅ LIMIT CHECK
        return $plan && isset($plan->$feature) && $plan->$feature > 0;
    }
}