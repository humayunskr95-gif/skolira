<?php

namespace App\Http\Controllers\SchoolAdmin;

use App\Http\Controllers\Controller;
use App\Models\Admission;
use App\Models\Expense;
use App\Models\Fee;
use App\Models\Gallery;
use App\Models\Notice;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class SchoolAdminController extends Controller
{
    public function index()
    {
        $schoolId = Auth::user()->school_id;
        $school = Auth::user()->school;

        $students = User::where('role', 'student')->where('school_id', $schoolId)->count();
        $teachers = User::where('role', 'teacher')->where('school_id', $schoolId)->count();
        $parents = User::where('role', 'parent')->where('school_id', $schoolId)->count();
        $accountants = User::where('role', 'accountant')->where('school_id', $schoolId)->count();

        $monthlyFees = Fee::where('school_id', $schoolId)
            ->whereMonth('date', now()->month)
            ->whereYear('date', now()->year)
            ->sum('amount');

        $monthlyExpenses = Expense::where('school_id', $schoolId)
            ->whereMonth('date', now()->month)
            ->whereYear('date', now()->year)
            ->sum('amount');

        $pendingAdmissions = Admission::where('school_id', $schoolId)
            ->where('status', 'pending')
            ->count();

        $noticeCount = Notice::where('school_id', $schoolId)->count();
        $galleryCount = Gallery::where('school_id', $schoolId)->count();

        $studentLimit = $school?->student_limit ?: 0;
        $teacherLimit = $school?->teacher_limit ?: 0;
        $studentUsage = $studentLimit > 0 ? min(($students / $studentLimit) * 100, 100) : 0;
        $teacherUsage = $teacherLimit > 0 ? min(($teachers / $teacherLimit) * 100, 100) : 0;

        return view('dashboard.school_admin_v2', [
            'school' => $school,
            'students' => $students,
            'teachers' => $teachers,
            'parents' => $parents,
            'accountants' => $accountants,
            'monthlyFees' => $monthlyFees,
            'monthlyExpenses' => $monthlyExpenses,
            'netBalance' => $monthlyFees - $monthlyExpenses,
            'pendingAdmissions' => $pendingAdmissions,
            'noticeCount' => $noticeCount,
            'galleryCount' => $galleryCount,
            'studentUsage' => $studentUsage,
            'teacherUsage' => $teacherUsage,
            'studentLimit' => $studentLimit,
            'teacherLimit' => $teacherLimit,
        ]);
    }
}
