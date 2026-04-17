<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Plan;
use App\Models\Subscription;

class SuperPlanController extends Controller
{
    public function index()
    {
        $plans = Plan::latest()->get();
        return view('super_admin.plans.index', compact('plans'));
    }

    public function create()
    {
        return view('super_admin.plans.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'price'    => 'required|numeric|min:0',
            'duration' => 'required|integer|min:1',

            'student_limit' => 'nullable|integer|min:1',
            'teacher_limit' => 'nullable|integer|min:1',
            'parent_limit'  => 'nullable|integer|min:1',
        ]);

        Plan::create($this->planData($request));

        return redirect()->route('super_admin.plans')
            ->with('success', 'Plan created successfully 🚀');
    }

    public function edit($id)
    {
        $plan = Plan::findOrFail($id);
        return view('super_admin.plans.edit', compact('plan'));
    }

    public function update(Request $request, $id)
{
    $plan = Plan::findOrFail($id);

    $request->validate([
        'name'     => 'required|string|max:255',
        'price'    => 'required|numeric|min:0',
        'duration' => 'required|integer|min:1',
    ]);

    $plan->update($this->planData($request));

    return redirect()->route('super_admin.plans')
        ->with('success', 'Plan updated successfully 🔄');
}

    public function destroy($id)
    {
        $plan = Plan::findOrFail($id);

        $used = Subscription::where('plan_id', $id)->exists();

        if ($used) {
            return back()->with('error', '❌ Plan is in use. Cannot delete.');
        }

        $plan->delete();

        return back()->with('success', 'Plan deleted successfully 🗑');
    }

    /**
     * ✅ COMMON DATA HANDLER (STORE + UPDATE SAME)
     */
    private function planData(Request $request)
{
    return [

        // 🔹 BASIC
        'name'     => $request->name,
        'price'    => $request->price,
        'duration' => $request->duration,

        // 🔹 LIMITS
        'student_limit' => $request->student_limit ?? 0,
        'teacher_limit' => $request->teacher_limit ?? 0,
        'parent_limit'  => $request->parent_limit ?? 0,

        // 🔹 ACADEMIC
        'subjects' => $request->boolean('subjects'),
        'classes'  => $request->boolean('classes'),
        'sections' => $request->boolean('sections'),

        // 🔹 STUDY SYSTEM
        'attendance' => $request->boolean('attendance'),
        'results'    => $request->boolean('results'),

        // 🔹 FINANCE
        'fees'       => $request->boolean('fees'),
        'accountant' => $request->boolean('accountant'),

        // 🔹 HOSTEL
        'hostel' => $request->boolean('hostel'),

        // 🔥 DRIVER SYSTEM (FIXED)
        'driver'        => $request->boolean('driver'),
        'driver_assign' => $request->boolean('driver_assign'),
        'vehicles'      => $request->boolean('vehicles'),
        'routes'        => $request->boolean('routes'),

        // 🔹 STAFF
        'staff_attendance' => $request->boolean('staff_attendance'),
        'leave'            => $request->boolean('leave'),

        // 🔹 REPORT
        'reports' => $request->boolean('reports'),
    ];
}
}