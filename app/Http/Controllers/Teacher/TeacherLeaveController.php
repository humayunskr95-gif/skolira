<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StaffLeave;

class TeacherLeaveController extends Controller
{
    /**
     * 📄 Leave Page
     */
    public function index()
    {
        $leaves = StaffLeave::where('staff_id', auth()->id())
            ->latest()
            ->get();

        return view('teacher.leave.index', compact('leaves'));
    }

    /**
     * 💾 Apply Leave
     */
    public function store(Request $request)
    {
        $request->validate([
            'reason' => 'required',
            'from_date' => 'required|date',
            'to_date' => 'required|date'
        ]);

        StaffLeave::create([
            'staff_id' => auth()->id(),
            'school_id' => auth()->user()->school_id,
            'reason' => $request->reason,
            'from_date' => $request->from_date,
            'to_date' => $request->to_date,
            'status' => 'pending'
        ]);

        return back()->with('success','Leave Applied Successfully');
    }
}