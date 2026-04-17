<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\StaffAttendance;
use App\Models\User;
use App\Models\Subject;
use App\Models\StaffLeave;

class TeacherDashboardController extends Controller
{
    public function index()
{
    $teacherId   = auth()->id();
    $teacherCode = auth()->user()->teacher_code;
    $schoolId    = auth()->user()->school_id;

    $data = [
        'today_attendance' => StaffAttendance::where('staff_id', $teacherId)
            ->whereDate('date', now())
            ->first(),

        'total_students' => User::where('role', 'student')
            ->where('school_id', $schoolId)
            ->count(),

        // ✅ FIXED (VERY IMPORTANT)
        'total_subjects' => \DB::table('subject_teacher')
            ->where('teacher_id', $teacherCode)
            ->count(),

        'total_leaves' => StaffLeave::where('staff_id', $teacherId)->count(),
    ];

    return view('teacher.dashboard', compact('data'));
}
}