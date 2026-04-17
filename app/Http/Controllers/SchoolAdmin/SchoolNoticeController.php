<?php
namespace App\Http\Controllers\SchoolAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notice;

class SchoolNoticeController extends Controller
{
    public function index()
    {
        $school = auth()->user()->school_id;

        $notices = Notice::where('school_id', $school)->latest()->paginate(10);

        return view('school_admin.notices.index', compact('notices'));
    }

    public function create()
    {
        return view('school_admin.notices.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
        ]);

        Notice::create([
            'school_id' => auth()->user()->school_id,
            'title' => $request->title,
            'description' => $request->description,
            'date' => $request->date,
        ]);

        return redirect()->route('school_admin.notices.index')
            ->with('success', 'Notice Added');
    }

    public function delete($id)
    {
        Notice::findOrFail($id)->delete();

        return back()->with('success', 'Deleted');
    }
}