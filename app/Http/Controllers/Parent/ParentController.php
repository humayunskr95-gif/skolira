<?php
namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Attendance;
use App\Models\Result;

class ParentController extends Controller
{
    public function children()
    {
        $parent = auth()->user();
        $children = $parent->children;

        return view('parent.children', compact('children'));
    }

    public function attendance($id)
    {
        $student = User::findOrFail($id);

        $attendance = Attendance::where('student_id', $id)->latest()->get();

        return view('parent.attendance', compact('student','attendance'));
    }

    public function results($id)
    {
        $student = User::findOrFail($id);

        $results = \App\Models\Result::where('student_id', $id)
            ->with('subject')
            ->get();

        return view('parent.results', compact('student','results'));
    }
    public function homework($student_id)
{
    $student = \App\Models\User::findOrFail($student_id);

    $homeworks = \App\Models\Homework::where('class_id', $student->class_id)
        ->where('section_id', $student->section_id)
        ->latest()
        ->get();

    return view('parent.homework', compact('student','homeworks'));
}
}