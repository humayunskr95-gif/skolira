<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Homework;

class StudentHomeworkController extends Controller
{
    public function index()
{
    $student = auth()->user();

    $homeworks = Homework::with('subject')
        ->where('class_id', $student->class_id)
        ->where(function($q) use ($student){
            $q->where('section_id', $student->section_id)
              ->orWhereNull('section_id');
        })
        ->latest()
        ->get();

    return view('student.homework.index', compact('homeworks'));
}
}