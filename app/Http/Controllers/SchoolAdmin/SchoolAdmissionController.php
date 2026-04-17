<?php
namespace App\Http\Controllers\SchoolAdmin;

use App\Http\Controllers\Controller;
use App\Models\Admission;

class SchoolAdmissionController extends Controller
{
    public function index()
    {
        $admissions = Admission::where('school_id', auth()->user()->school_id)
            ->latest()->paginate(10);

        return view('school_admin.admission.index', compact('admissions'));
    }

    public function approve($id)
    {
        Admission::findOrFail($id)->update(['status' => 'approved']);
        return back();
    }

    public function reject($id)
    {
        Admission::findOrFail($id)->update(['status' => 'rejected']);
        return back();
    }
}