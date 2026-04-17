<?php
namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Result;
use App\Models\Subject;
use Illuminate\Http\Request;

class TeacherResultController extends Controller
{
    public function index()
    {
        $teacher = auth()->user();

        $subjects = $teacher->subjects;

        return view('teacher.results.index', compact('subjects'));
    }

    public function create($subject_id)
{
    $teacher = auth()->user();

    // subject find
    $subject = \App\Models\Subject::findOrFail($subject_id);

    // 🔥 FIX: class wise students
    $students = User::where('role','student')
        ->where('class_id', $subject->class_id)
        ->get();

    return view('teacher.results.create', compact(
        'students',
        'subject_id'
    ));
}

    public function store(Request $request)
{
    foreach($request->marks as $studentId => $mark){

        \App\Models\Result::updateOrCreate(
            [
                'student_id' => $studentId,
                'subject_id' => $request->subject_id
            ],
            [
                'marks' => $mark
            ]
        );
    }

    return back()->with('success','Marks Saved Successfully ✅');
}
}