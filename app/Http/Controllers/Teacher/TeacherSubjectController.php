<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Subject;

class TeacherSubjectController extends Controller
{
    /**
     * 📚 MY SUBJECTS LIST
     */
    public function index()
{
    $teacher = auth()->user();

    $subjects = $teacher->subjects()->with('class')->get();

    return view('teacher.subjects.index', compact('subjects'));
}

    /**
     * 👁 VIEW SINGLE SUBJECT
     */
    public function show($id)
    {
        $teacherCode = auth()->user()->teacher_code;

        $subject = Subject::join('subject_teacher', 'subjects.id', '=', 'subject_teacher.subject_id')
            ->where('subject_teacher.teacher_id', $teacherCode)
            ->where('subjects.id', $id)
            ->select('subjects.*')
            ->firstOrFail();

        return view('teacher.subjects.show', compact('subject'));
    }
}