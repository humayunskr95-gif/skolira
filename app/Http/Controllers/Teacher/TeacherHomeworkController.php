<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Homework;
use App\Models\Subject;
use App\Models\SchoolClass;
use App\Models\Section;
use Illuminate\Http\Request;

class TeacherHomeworkController extends Controller
{
    /**
     * 📊 Homework List
     */
    public function index()
    {
        $homeworks = Homework::with('subject')
            ->where('teacher_id', auth()->id())
            ->latest()
            ->get();

        return view('teacher.homework.index', compact('homeworks'));
    }

    /**
     * ➕ Create Page
     */
    public function create()
    {
        $teacher = auth()->user();

        // ✅ Only assigned subjects
        $subjects = $teacher->subjects;

        // ✅ Only classes from subjects
        $classIds = $subjects->pluck('class_id')->unique();

        $classes = SchoolClass::whereIn('id', $classIds)->get();

        return view('teacher.homework.create', compact('subjects','classes'));
    }

    /**
     * 🔄 AJAX: Get Sections
     */
    public function getSections($class_id)
{
    return response()->json(
        Section::where('school_class_id', $class_id)
            ->select('id','name')
            ->get()
    );
}

    /**
     * 🔄 AJAX: Get Subjects
     */
    public function getSubjects($class_id)
{
    $teacher = auth()->user();

    return $teacher->subjects()
        ->where('class_id', $class_id)
        ->orWhereNull('class_id')
        ->get();
}

    /**
     * 💾 Store Homework
     */
    public function store(Request $request)
    {
        $teacher = auth()->user();

        $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'class_id'   => 'required|exists:school_classes,id',
            'section_id' => 'required|exists:sections,id',
            'title'      => 'required',
            'description'=> 'required',
            'due_date'   => 'required|date',
        ]);

        // 🔒 SECURITY: subject belongs to teacher
        if (!$teacher->subjects->pluck('id')->contains($request->subject_id)) {
            abort(403, 'Unauthorized subject');
        }

        Homework::create([
            'teacher_id' => $teacher->id,
            'subject_id' => $request->subject_id,
            'class_id'   => $request->class_id,
            'section_id' => $request->section_id,
            'title'      => $request->title,
            'description'=> $request->description,
            'due_date'   => $request->due_date,
        ]);

        return redirect()->route('teacher.homework')
            ->with('success','Homework Added Successfully ✅');
    }
}