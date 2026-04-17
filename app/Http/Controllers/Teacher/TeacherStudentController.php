<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\User;

class TeacherStudentController extends Controller
{
    /**
     * 📚 Student List
     */
    public function index()
{
    $query = User::where('role', 'student')
        ->where('school_id', auth()->user()->school_id);

    // 🔍 Search
    if(request('search')){
        $query->where('name', 'like', '%'.request('search').'%');
    }

    $students = $query->latest()->paginate(10)->withQueryString();

    return view('teacher.students.index', compact('students'));
}

    /**
     * 👁 Student Details
     */
    public function show($id)
    {
        $student = User::where('id', $id)
            ->where('role', 'student')
            ->firstOrFail();

        return view('teacher.students.show', compact('student'));
    }
}