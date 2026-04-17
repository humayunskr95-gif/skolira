<?php
namespace App\Http\Controllers\SchoolAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SchoolClass;

class SchoolClassController extends Controller
{
    public function index()
    {
        $classes = SchoolClass::latest()->get();
        return view('school_admin.classes.index', compact('classes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:school_classes,name'
        ]);

        SchoolClass::create([
            'name' => $request->name
        ]);

        return back()->with('success','Class added');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:school_classes,name,'.$id
        ]);

        SchoolClass::findOrFail($id)->update([
            'name' => $request->name
        ]);

        return back()->with('success','Class updated');
    }

    public function destroy($id)
    {
        SchoolClass::findOrFail($id)->delete();
        return back()->with('success','Class deleted');
    }
}