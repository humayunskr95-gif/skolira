<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Attendance;

class StudentAttendanceController extends Controller
{
    public function index()
    {
        $attendances = Attendance::where('student_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('student.attendance.index', compact('attendances'));
    }
}