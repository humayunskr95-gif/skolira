<?php

namespace App\Http\Controllers\SchoolAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subject;
use App\Models\User;
use App\Models\SchoolClass;

class SchoolSubjectController extends Controller
{
    public function index()
    {
        // 🔥 teachers + class load
        $subjects = Subject::with(['class','teachers'])->latest()->get();

        return view('school_admin.subjects.index', compact('subjects'));
    }

    public function create()
    {
        $classes = SchoolClass::all();
        return view('school_admin.subjects.create', compact('classes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'class_id' => 'required',
            'name' => 'required'
        ]);

        Subject::create([
            'class_id' => $request->class_id,
            'name' => $request->name
        ]);

        return redirect()->route('school_admin.subjects.index')
            ->with('success', '✅ Subject added successfully!');
    }

    public function edit($id)
    {
        $subject = Subject::findOrFail($id);
        $classes = SchoolClass::all();

        return view('school_admin.subjects.edit', compact('subject','classes'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'class_id' => 'required',
            'name' => 'required'
        ]);

        $subject = Subject::findOrFail($id);

        $subject->update([
            'class_id' => $request->class_id,
            'name' => $request->name
        ]);

        return redirect()->route('school_admin.subjects.index')
            ->with('success', '✏️ Subject updated successfully!');
    }

    public function destroy($id)
    {
        Subject::findOrFail($id)->delete();

        return back()->with('success', '🗑 Subject deleted successfully!');
    }

    // ✅ Assign page
    public function assign($id)
    {
        // 🔥 teachers eager load
        $subject = Subject::with('teachers')->findOrFail($id);

        $teachers = User::where('role','teacher')->get();

        return view('school_admin.subjects.assign', compact('subject','teachers'));
    }

    // ✅ Save assign
    public function assignStore(Request $request, $id)
    {
        $subject = Subject::findOrFail($id);

        // 🔥 null safe
        $teacherIds = $request->teacher_ids ?? [];

        $subject->teachers()->sync($teacherIds);

        return redirect()->route('school_admin.subjects.index')
            ->with('success','✅ Teacher Assigned');
    }
}