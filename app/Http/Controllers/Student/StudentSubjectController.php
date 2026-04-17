<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Subject;

class StudentSubjectController extends Controller
{
    public function index()
    {
        $student = auth()->user();

        $subjects = Subject::with('class')
            ->where('class_id', $student->class_id)
            ->get();

        return view('student.subjects.index', compact('subjects'));
    }
}