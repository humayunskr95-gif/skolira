<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\School;
use App\Models\User;
use App\Models\Plan;
use App\Models\Subscription;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SuperAdminController extends Controller
{
    /**
     * 📊 Dashboard
     */
    public function index()
    {
        return view('dashboard.super_admin', [
            'totalSchools'   => School::count(),
            'totalAdmins'    => User::where('role','school_admin')->count(),
            'totalUsers'     => User::count(),
            'totalRevenue'   => Subscription::where('status','active')->sum('amount'),
            'activeSchools'  => School::where('is_active', true)->count(),
            'expiredSchools' => Subscription::where('end_date','<', now())->count(),
            'newUsers'       => User::whereDate('created_at', today())->count(),
            'schoolsList'    => School::latest()->take(5)->get(),
        ]);
    }

    /**
     * 🏫 Schools List
     */
    public function schools()
    {
        $schools = School::latest()->paginate(20);
        return view('super_admin.schools.index', compact('schools'));
    }

    /**
     * ➕ Create
     */
    public function createSchool()
    {
        return view('super_admin.schools.create');
    }

    /**
     * 💾 Store School (AUTO SUBDOMAIN)
     */
    public function storeSchool(Request $request)
    {
        $request->validate([
            'school_name'  => 'required|string|max:255',
            'admin_name'   => 'required|string|max:255',
            'admin_email'  => 'required|email|unique:users,email',
            'password'     => 'required|min:6',
        ]);

        DB::beginTransaction();

        try {

            // 🔐 Unique School Code
            do {
                $schoolCode = 'SK' . strtoupper(Str::random(6));
            } while (School::where('code',$schoolCode)->exists());

            // 🌐 AUTO SUBDOMAIN SLUG
            $baseSlug = Str::slug($request->school_name);

            $slug = $baseSlug;
            $count = 1;

            while (School::where('slug', $slug)->exists()) {
                $slug = $baseSlug . $count;
                $count++;
            }

            // 📸 Logo
            $logoPath = null;
            if ($request->hasFile('logo')) {
                $logoPath = $request->file('logo')->store('schools', 'public');
            }

            // 🏫 Create School
            $school = School::create([
                'name'        => $request->school_name,
                'code'        => $schoolCode,
                'slug'        => $slug,
                'owner_name'  => $request->owner_name,
                'address1'    => $request->address1,
                'address2'    => $request->address2,
                'city'        => $request->city,
                'district'    => $request->district,
                'state'       => $request->state,
                'pin'         => $request->pin,
                'logo'        => $logoPath,
                'is_active'   => true,
            ]);

            // 👤 Create School Admin
            User::create([
                'name'       => $request->admin_name,
                'email'      => $request->admin_email,
                'password'   => Hash::make($request->password),
                'role'       => 'school_admin',
                'school_id'  => $school->id,
                'is_active'  => 1
            ]);

            DB::commit();

            return redirect()->route('super_admin.schools')
                ->with('success', "School Created ✅ URL: http://{$slug}.localhost:8000");

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * ✏️ Edit
     */
    public function editSchool($id)
    {
        $school = School::findOrFail($id);
        return view('super_admin.schools.edit', compact('school'));
    }

    /**
     * 🔄 Update
     */
    public function updateSchool(Request $request, $id)
    {
        $school = School::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $data = $request->only([
            'name','owner_name','address1','address2',
            'city','district','state','pin'
        ]);

        if ($request->hasFile('logo')) {

            if ($school->logo && Storage::disk('public')->exists($school->logo)) {
                Storage::disk('public')->delete($school->logo);
            }

            $data['logo'] = $request->file('logo')->store('schools', 'public');
        }

        $school->update($data);

        return back()->with('success', 'Updated successfully');
    }

    /**
     * ❌ Delete
     */
    public function deleteSchool($id)
    {
        $school = School::findOrFail($id);

        DB::beginTransaction();

        try {

            if ($school->logo && Storage::disk('public')->exists($school->logo)) {
                Storage::disk('public')->delete($school->logo);
            }

            User::where('school_id', $school->id)->delete();
            Subscription::where('school_id', $school->id)->delete();

            $school->delete();

            DB::commit();

            return back()->with('success', 'Deleted successfully');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * 👁 View
     */
    public function viewSchool($id)
    {
        $school = School::findOrFail($id);
        return view('super_admin.schools.view', compact('school'));
    }

    /**
     * 🔥 Activate / Suspend
     */
    public function toggleSchool($id)
    {
        $school = School::findOrFail($id);

        $school->is_active = !$school->is_active;
        $school->save();

        User::where('school_id', $school->id)
            ->update(['is_active' => $school->is_active]);

        return back()->with('success',
            $school->is_active ? 'School Activated' : 'School Suspended'
        );
    }

    /**
     * 💳 Subscribe
     */
    public function showSubscribe($id)
    {
        $school = School::findOrFail($id);
        $plans = Plan::latest()->get();

        return view('super_admin.schools.subscribe', compact('school','plans'));
    }

    /**
     * 🚀 Assign Subscription
     */
    public function assignSubscription(Request $request, $id)
{
    $request->validate([
        'plan_id' => 'required|exists:plans,id'
    ]);

    DB::beginTransaction();

    try {

        $plan = Plan::findOrFail($request->plan_id);
        $school = School::findOrFail($id);

        // ❌ expire old subscription
        Subscription::where('school_id', $id)
            ->update(['status' => 'expired']);

        // ✅ create new subscription
        Subscription::create([
            'school_id'  => $school->id,
            'plan_id'    => $plan->id,
            'start_date' => now(),
            'end_date'   => now()->addDays($plan->duration),
            'status'     => 'active',
            'amount'     => $plan->price ?? 0
        ]);

        // 🎯 update limits
        $school->update([
            'student_limit' => $plan->student_limit,
            'teacher_limit' => $plan->teacher_limit,
        ]);

        DB::commit();

        return back()->with('success', 'Subscription assigned successfully 🚀');

    } catch (\Exception $e) {
        DB::rollback();
        return back()->with('error', $e->getMessage());
    }
}

    /**
     * 👥 Users Monitoring
     */
    public function users()
    {
        $users = User::with('school')->latest()->paginate(20);

        return view('super_admin.users.index', [
            'users' => $users,
            'totalUsers' => User::count(),
            'students' => User::where('role','student')->count(),
            'teachers' => User::where('role','teacher')->count(),
            'admins'   => User::where('role','school_admin')->count(),
        ]);
    }

    /**
     * 📊 Login Logs
     */
    public function logs($id)
    {
        $user = User::findOrFail($id);
        $logs = $user->logs()->latest()->paginate(20);

        return view('super_admin.users.logs', compact('user','logs'));
    }
}