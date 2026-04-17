<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Attendance;
use Illuminate\Http\Request;

class TeacherStudentAttendanceController extends Controller
{
    /**
     * 📝 Attendance Page
     */
    public function index()
    {
        $students = User::where('role','student')
            ->where('school_id', auth()->user()->school_id)
            ->get();

        return view('teacher.student_attendance.index', compact('students'));
    }

    /**
     * 💾 Store Attendance
     */
    public function store(Request $request)
{
    // ✅ validation
    $request->validate([
        'students'   => 'required|array',
        'date'       => 'required|date',
        'class_id'   => 'required',
        'section_id' => 'required',
    ]);

    foreach ($request->students as $studentId => $status) {

        Attendance::updateOrCreate(
            [
                'student_id' => $studentId,
                'date'       => $request->date,
            ],
            [
                'school_id'  => auth()->user()->school_id,
                'class_id'   => $request->class_id,
                'section_id' => $request->section_id,
                'status'     => $status,
            ]
        );
    }

    return back()->with('success','Attendance Saved');
}
}