<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckFeature
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, $feature): Response
    {
        // 🔥 Current logged user
        $user = auth()->user();

        // ❌ If no login
        if (!$user) {
            return redirect()->route('login');
        }

        // 🔥 Super Admin bypass (ALL ACCESS)
        if ($user->role === 'super_admin') {
            return $next($request);
        }

        // 🔥 Get school
        $school = $user->school;

        // ❌ No school
        if (!$school) {
            abort(403, 'No school found');
        }

        // 🔥 Get subscription
        $subscription = $school->subscription;

        // ❌ No subscription
        if (!$subscription) {
            return redirect()->route('subscription.expired');
        }

        // ❌ Expired check
        if ($subscription->end_date < now()) {
            return redirect()->route('subscription.expired');
        }

        // 🔥 Get plan
        $plan = $subscription->plan;

        // ❌ No plan
        if (!$plan) {
            return redirect()->route('subscription.expired');
        }

        // 🎯 FEATURE CHECK (Dynamic column match)
        if (!isset($plan->$feature) || $plan->$feature != 1) {
            abort(403, "🚫 {$feature} feature not available in your plan.");
        }

        return $next($request);
    }
}