<?php

namespace App\Http\Controllers\SchoolAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\SchoolClass;

class SchoolResultController extends Controller
{
    // ================= LIST =================
    public function index(Request $request)
    {
        $classes = SchoolClass::with('sections')->get();
        $students = collect();

        if ($request->filled('class_id') && $request->filled('section_id')) {

            $students = User::where('role','student')
                ->where('class_id', $request->class_id)
                ->where('section_id', $request->section_id)
                ->orderBy('roll') // 🔥 roll wise sorting
                ->get();
        }

        return view('school_admin.results.index', compact('classes','students'));
    }

    // ================= STUDENT RESULT =================
    public function show($id)
{
    $student = \App\Models\User::with([
        'results.subject',     // 🔥 subject eager load
        'studentClass',
        'studentSection'
    ])->findOrFail($id);

    $total = $student->results->sum('marks');
    $avg   = $student->results->avg('marks') ?? 0;

    // 🎯 Grade logic
    if ($avg >= 80) $grade = 'A+';
    elseif ($avg >= 60) $grade = 'A';
    elseif ($avg >= 50) $grade = 'B';
    elseif ($avg >= 40) $grade = 'C';
    else $grade = 'F';

    return view('school_admin.results.show', compact(
        'student','total','avg','grade'
    ));
}
}