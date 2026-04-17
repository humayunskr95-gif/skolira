<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ParentDashboardController extends Controller
{
    /**
     * 👨‍👩‍👧 Parent Dashboard
     */
    public function index()
    {
        $parent = Auth::user();

        // 🔥 SAFE CHECK (role validation)
        if ($parent->role !== 'parent') {
            abort(403, 'Unauthorized access');
        }

        // 🔥 Children fetch (users table based)
        $children = User::where('parent_id', $parent->id)
            ->where('role', 'student')
            ->with('class') // optional (if relation exists)
            ->get();

        // 🔥 Total children count
        $totalChildren = $children->count();

        return view('parent.dashboard', compact(
            'children',
            'totalChildren'
        ));
    }
}