<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use App\Models\Attendance;
use App\Models\Result;
use App\Models\Fee;

class StudentDashboardController extends Controller
{
    public function index()
    {
        // 🔥 FIX: relation load
        $student = auth()->user()->load(['studentClass','studentSection']);

        // ✅ Subjects
        $subjects = Subject::where('class_id', $student->class_id)
                        ->with('teachers')
                        ->get();

        // ✅ Attendance
        $attendance = Attendance::where('student_id', $student->id);

        $totalAttendance = $attendance->count();
        $present = $attendance->where('status','present')->count();

        // ✅ Results
        $results = Result::where('student_id', $student->id)->get();
        $avg = $results->avg('marks') ?? 0;

        // ✅ Fees (OPTIMIZED 🔥)
        $fees = Fee::where('student_id', $student->id);

        $paid = $fees->sum('paid_amount');
        $total = $fees->sum('amount');
        $due = $total - $paid;

        return view('student.dashboard', compact(
            'student', // 🔥 IMPORTANT
            'subjects',
            'totalAttendance',
            'present',
            'avg',
            'paid',
            'due'
        ));
    }
}