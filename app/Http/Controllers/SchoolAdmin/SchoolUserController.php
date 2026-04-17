<?php
namespace App\Http\Controllers\SchoolAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SchoolUserController extends Controller
{
    public function index(Request $request)
{
    $school = app('currentSchool');

    $query = User::where('school_id', $school->id)
                 ->where('role', '!=', 'school_admin');

    // 🔍 SEARCH
    if ($request->search) {
        $query->where(function ($q) use ($request) {
            $q->where('name', 'like', '%' . $request->search . '%')
              ->orWhere('email', 'like', '%' . $request->search . '%');
        });
    }

    $users = $query->latest()->paginate(10);

    return view('school_admin.users.index', compact('users'));
}

    // 🔑 RESET PASSWORD (AJAX)
public function resetPassword(Request $request, $id)
{
    $user = User::findOrFail($id);

    $user->password = \Hash::make($request->password);
    $user->save();

    return response()->json([
        'message' => 'Password updated successfully 🔐'
    ]);
}

// 🔥 TOGGLE USER
public function toggle($id)
{
    $user = User::findOrFail($id);

    $user->is_active = !$user->is_active;
    $user->save();

    return response()->json([
        'status' => $user->is_active
    ]);
}
}