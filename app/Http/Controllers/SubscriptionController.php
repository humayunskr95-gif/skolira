<?php
namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Subscription;

class SubscriptionController extends Controller
{
    public function buy($id)
    {
        $school = auth()->user()->school;

        $plan = Plan::findOrFail($id);

        // old expire
        Subscription::where('school_id', $school->id)
            ->update(['status' => 'expired']);

        // new subscription
        Subscription::create([
            'school_id'  => $school->id,
            'plan_id'    => $plan->id,
            'start_date' => now(),
            'end_date'   => now()->addDays($plan->duration),
            'status'     => 'active',
            'amount'     => $plan->price
        ]);

        // update limits
        $school->update([
            'student_limit' => $plan->student_limit,
            'teacher_limit' => $plan->teacher_limit,
        ]);

        return redirect()->route('school_admin.dashboard')
            ->with('success','✅ Plan upgraded successfully');
    }
}