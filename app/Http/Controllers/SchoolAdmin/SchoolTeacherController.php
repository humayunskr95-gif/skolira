<?php

namespace App\Http\Controllers\SchoolAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TeachersExport;
use App\Imports\TeachersImport;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SchoolTeacherController extends Controller
{
    // ================= LIST =================
    public function index(Request $request)
    {
        $query = User::where('role','teacher')
            ->where('school_id', auth()->user()->school_id);

        // 🔍 SEARCH
        if ($request->search) {
            $query->where(function($q) use ($request){
                $q->where('name','like','%'.$request->search.'%')
                  ->orWhere('email','like','%'.$request->search.'%')
                  ->orWhere('mobile','like','%'.$request->search.'%');
            });
        }

        // 🎯 STATUS FILTER
        if ($request->status !== null) {
            $query->where('is_active', $request->status);
        }

        $teachers = $query->latest()->paginate(10);

        return view('school_admin.teachers.index', compact('teachers'));
    }

    // ================= CREATE =================
    public function create()
    {
        return view('school_admin.teachers.create');
    }

    // ================= STORE =================
    public function store(Request $request)
{
    $school = auth()->user()->school;

    // 🚫 LIMIT CHECK
    $total = User::where('role','teacher')
        ->where('school_id', $school->id)
        ->count();

    if ($school->teacher_limit && $total >= $school->teacher_limit) {
        return back()->with('error','🚫 Teacher limit reached!');
    }

    // ✅ VALIDATION
    $request->validate([
        'name'   => 'required',
        'email'  => 'required|email|unique:users',
        'mobile' => 'required|unique:users',
        'photo'  => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    // 📸 PHOTO
    $photoPath = null;
    if ($request->hasFile('photo')) {
        $photoPath = $request->file('photo')->store('teachers','public');
    }

    // 🔐 DEFAULT PASSWORD
    $password = Hash::make('123456');

    // 🎯 UNIQUE TEACHER CODE
    do {
        $teacherCode = 'SKTEA'.rand(10,99);
    } while (User::where('teacher_code', $teacherCode)->exists());

    // 👨‍🏫 CREATE
    User::create([
        'name'        => $request->name,
        'father_name' => $request->father_name,
        'dob'         => $request->dob,
        'gender'      => $request->gender,

        'email'       => $request->email,
        'mobile'      => $request->mobile,
        'password'    => $password,

        'role'        => 'teacher',
        'school_id'   => $school->id,

        'teacher_code'=> $teacherCode, // ✅ CODE

        'address1'    => $request->address1,
        'address2'    => $request->address2,
        'state'       => $request->state,
        'district'    => $request->district,
        'block'       => $request->block,
        'city'        => $request->city,
        'pin'         => $request->pin,

        'photo'       => $photoPath,
        'is_active'   => 1
    ]);

    return redirect()->route('school_admin.teachers.index')
        ->with('success', '✅ Teacher added | Code: '.$teacherCode.' | Password: 123456');
}

    // ================= EDIT =================
    public function edit($id)
    {
        $teacher = User::findOrFail($id);
        return view('school_admin.teachers.edit', compact('teacher'));
    }

    // ================= UPDATE =================
    public function update(Request $request, $id)
    {
        $teacher = User::findOrFail($id);

        // ✅ VALIDATION
        $request->validate([
            'name'   => 'required',
            'email'  => 'required|email|unique:users,email,'.$id,
            'mobile' => 'required|unique:users,mobile,'.$id,
            'photo'  => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // 📸 PHOTO UPDATE
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('teachers','public');
        } else {
            $photoPath = $teacher->photo;
        }

        // 🔄 UPDATE
        $teacher->update([
            'name'        => $request->name,
            'father_name' => $request->father_name,
            'dob'         => $request->dob,
            'gender'      => $request->gender,

            'email'       => $request->email,
            'mobile'      => $request->mobile,

            'address1'    => $request->address1,
            'address2'    => $request->address2,
            'state'       => $request->state,
            'district'    => $request->district,
            'block'       => $request->block,
            'city'        => $request->city,
            'pin'         => $request->pin,

            'photo'       => $photoPath,
        ]);

        // 🔐 PASSWORD OPTIONAL
        if ($request->password) {
            $teacher->update([
                'password' => Hash::make($request->password)
            ]);
        }

        return redirect()->route('school_admin.teachers.index')
            ->with('success','✏️ Teacher updated successfully');
    }

    // ================= DELETE =================
    public function destroy($id)
    {
        User::findOrFail($id)->delete();

        return back()->with('success','🗑 Teacher deleted');
    }

    // ================= STATUS =================
    public function toggleStatus($id)
    {
        $teacher = User::findOrFail($id);

        $teacher->is_active = !$teacher->is_active;
        $teacher->save();

        return back()->with('success','🔄 Status updated');
    }
public function export()
{
    return Excel::download(new TeachersExport, 'teachers.xlsx');
}
public function show($id)
{
    $teacher = User::findOrFail($id);
    return view('school_admin.teachers.view', compact('teacher'));
}
public function import(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:xlsx,csv'
    ]);

    \Maatwebsite\Excel\Facades\Excel::import(
        new \App\Imports\TeachersImport,
        $request->file('file')
    );

    return back()->with('success','✅ Teachers imported successfully');
}
  
public function template(): StreamedResponse
{
    $headers = [
        "Content-type"        => "text/csv",
        "Content-Disposition" => "attachment; filename=teacher_sample.csv",
        "Pragma"              => "no-cache",
        "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
        "Expires"             => "0"
    ];

    $columns = ['name', 'father_name', 'email', 'mobile','dob','address1','address2','state','district','block','city','pin'];

    $callback = function() use ($columns) {
        $file = fopen('php://output', 'w');

        // Header row
        fputcsv($file, $columns);

        // Sample data
        fputcsv($file, ['Rahim Khan', 'Karim Khan', 'rahim@gmail.com', '9876543210']);
        fputcsv($file, ['Sohan Ali', 'Rahman Ali', 'sohan@gmail.com', '9123456780']);
        fputcsv($file, ['Rina Das', 'Bimal Das', 'rina@gmail.com', '9012345678']);

        fclose($file);
    };

    return response()->stream($callback, 200, $headers);
}
}