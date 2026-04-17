<?php
namespace App\Http\Controllers\SchoolAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Section;
use App\Models\SchoolClass;

class SectionController extends Controller
{
    public function index()
    {
        $sections = Section::with('class')->latest()->get();
        $classes = SchoolClass::all();

        return view('school_admin.sections.index', compact('sections','classes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'school_class_id' => 'required'
        ]);

        Section::create($request->all());

        return back()->with('success','Section added');
    }

    public function update(Request $request, $id)
    {
        Section::findOrFail($id)->update($request->all());

        return back()->with('success','Section updated');
    }

    public function destroy($id)
    {
        Section::findOrFail($id)->delete();

        return back()->with('success','Section deleted');
    }
    public function getByClass($id)
{
    return response()->json(
        \App\Models\Section::where('school_class_id', $id)->get()
    );
}
}