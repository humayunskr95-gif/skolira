<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Result;

class StudentResultController extends Controller
{
    public function index()
    {
        $results = Result::where('student_id', auth()->id())
            ->latest()
            ->get();

        return view('student.results.index', compact('results'));
    }
}