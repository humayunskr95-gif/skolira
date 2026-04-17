<?php
namespace App\Http\Controllers\SchoolSite;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admission;

class SiteAdmissionController extends Controller
{
    public function form()
    {
        return view('school_site.admission');
    }

    public function submit(Request $request)
    {
        $request->validate([
            'name'   => 'required',
            'mobile' => 'required',
            'class'  => 'required',
            'photo'  => 'nullable|image|max:2048'
        ]);

        $school = app('currentSchool');

        $photo = null;

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo')->store('admissions', 'public');
        }

        Admission::create([
            'school_id' => $school->id,
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'class' => $request->class,
            'address' => $request->address,
            'photo' => $photo
        ]);

        return back()->with('success', 'Application Submitted ✅');
    }
}