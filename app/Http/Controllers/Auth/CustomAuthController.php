<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\LoginLog;
use Jenssegers\Agent\Agent;

class CustomAuthController extends Controller
{
    public function login()
    {
        return view('auth.custom-login');
    }

    public function loginStore(Request $request)
{
    $request->validate([
        'email'    => 'required|email',
        'password' => 'required',
    ]);

    $school = app()->bound('currentSchool') ? app('currentSchool') : null;

    // 🔥 SUPER ADMIN LOGIN
    if (!$school) {

        if (!Auth::attempt([
            'email' => $request->email,
            'password' => $request->password
        ])) {
            return back()->with('error', 'Invalid credentials');
        }

        if (Auth::user()->role !== 'super_admin') {
            Auth::logout();
            return back()->with('error', 'Not authorized as Super Admin');
        }

        $request->session()->regenerate();
        $this->saveLoginLog($request);

        return redirect('/super-admin/dashboard');
    }

    // 🔒 SCHOOL USER LOGIN
    if (!Auth::attempt([
        'email'     => $request->email,
        'password'  => $request->password,
        'school_id' => $school->id
    ])) {
        return back()->with('error', 'Invalid credentials');
    }

    $user = Auth::user();

    // ❌ USER BLOCK
    if (!$user->is_active) {
        Auth::logout();
        return back()->with('error', '❌ Account is blocked!');
    }

    // ❌ SCHOOL BLOCK
    if (!$school->is_active) {
        Auth::logout();
        return back()->with('error', 'School is suspended!');
    }

    // ❌ SUBSCRIPTION CHECK
    $subscription = $school->subscription;

    if (!$subscription) {
        Auth::logout();
        return back()->with('error', '🚫 No active subscription!');
    }

    if ($subscription->end_date < now()) {
        Auth::logout();
        return back()->with('error', '🚫 Subscription expired!');
    }

    // ✅ IMPORTANT: NO FEATURE CHECK HERE

    // ✅ SUCCESS LOGIN
    $request->session()->regenerate();
    $this->saveLoginLog($request);

    return $this->redirectByRole($user->role);
}

    public function register()
    {
        return view('auth.custom-register');
    }

    public function registerStore(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email',
            'password' => 'required|min:6',
            'role'     => 'required|in:student,teacher,parent,accountant,hostel,driver',
        ]);

        $school = app()->bound('currentSchool') ? app('currentSchool') : null;

        if (!$school) {
            return back()->with('error', 'Invalid School Domain');
        }

        if (!$school->is_active) {
            return back()->with('error', 'School is inactive');
        }

        $exists = User::where('email', $request->email)
                      ->where('school_id', $school->id)
                      ->exists();

        if ($exists) {
            return back()->with('error', 'Email already exists in this school');
        }

        User::create([
            'name'       => $request->name,
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
            'role'       => strtolower($request->role),
            'school_id'  => $school->id,
            'is_active'  => 1
        ]);

        return back()->with('success', 'Account created successfully');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/'); // ✅ SAFE
    }

    private function saveLoginLog($request)
    {
        $agent = new Agent();

        LoginLog::create([
            'user_id'  => Auth::id(),
            'ip'       => $request->ip(),
            'device'   => $agent->device(),
            'browser'  => $agent->browser(),
            'platform' => $agent->platform(),
        ]);
    }

    private function redirectByRole($role)
    {
        return match ($role) {

            // ✅ FIXED (NO route())
            'school_admin' => redirect('/school-admin/dashboard'),
            'teacher'      => redirect('/teacher/dashboard'),
            'student'      => redirect('/student/dashboard'),
            'parent'       => redirect('/parent/dashboard'),
            'accountant'   => redirect('/accountant/dashboard'),
            'hostel'       => redirect('/hostel/dashboard'),
            'driver'       => redirect('/driver/dashboard'),

            default        => redirect('/'),
        };
    }
}