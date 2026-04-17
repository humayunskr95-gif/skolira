<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\School;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\LoginLog;

class SuperUserController extends Controller
{
    /**
     * 👥 Users List + Filter + Stats
     */
    public function index(Request $request)
    {
        $query = User::with('school');

        // 🔍 Role Filter
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // 🏫 School Filter
        if ($request->filled('school_id')) {
            $query->where('school_id', $request->school_id);
        }

        // 🔍 Search (safe query)
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // 📄 Pagination (IMPORTANT)
        $users = $query->latest()->paginate(15)->withQueryString();

        // 📊 Stats
        $totalUsers = User::count();
        $students   = User::where('role','student')->count();
        $teachers   = User::where('role','teacher')->count();
        $admins     = User::where('role','school_admin')->count();

        // 🏫 Schools list
        $schools = School::select('id','name')->get();

        return view('super_admin.users.index', compact(
            'users',
            'schools',
            'totalUsers',
            'students',
            'teachers',
            'admins'
        ));
    }

    /**
     * 🔐 Block / Unblock User
     */
    public function toggleStatus($id)
{
    $user = User::findOrFail($id);

    // allow unblock if blocked
    if ($user->role === 'super_admin' && $user->is_active) {
        return back()->with('error','Super Admin cannot be blocked');
    }

    $user->is_active = !$user->is_active;
    $user->save();

    return back()->with('success','Status updated');
}

    /**
     * 🔑 Reset Password (Admin Control)
     */
    public function resetPassword($id)
{
    $user = User::findOrFail($id);

    $newPassword = '12345678';

    $user->password = Hash::make($newPassword);
    $user->save();

    return back()->with('success','Password reset: '.$newPassword);
}

    /**
     * 📊 Login Activity
     */
    public function logs(Request $request)
{
    $query = LoginLog::query();

    if ($request->search) {
        $query->where('ip','like','%'.$request->search.'%')
              ->orWhere('device','like','%'.$request->search.'%');
    }

    $logs = $query->latest()->paginate(10);

    return view('super_admin.users.logs', compact('logs'));
}
}