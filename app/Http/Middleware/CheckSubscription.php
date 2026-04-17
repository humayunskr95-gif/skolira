<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Subscription;

class CheckSubscription
{
    /**
     * Handle an incoming request
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        // 🔒 যদি login না থাকে
        if (!$user) {
            return redirect()->route('login');
        }

        // 🔒 Super Admin bypass (very important)
        if ($user->role === 'super_admin') {
            return $next($request);
        }

        // 🔒 School Admin must have school_id
        if (!$user->school_id) {
            abort(403, 'No school assigned');
        }

        // 🔍 Active subscription check
        $subscription = Subscription::where('school_id', $user->school_id)
            ->where('status', 'active')
            ->whereDate('end_date', '>=', now())
            ->latest()
            ->first();

        // ❌ No active subscription
        if (!$subscription) {
            return redirect()->route('subscription.expired');
        }

        // ✅ Optional: auto expire update
        if ($subscription->end_date < now()) {
            $subscription->update(['status' => 'expired']);
        }

        // 👉 allow request
        return $next($request);
    }
}