<?php

namespace App\Http\Controllers\SchoolAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

use App\Models\User;
use App\Models\SchoolClass;
use App\Models\TransportRoute;
use App\Models\DriverAssignment;

use Maatwebsite\Excel\Facades\Excel;
use App\Imports\StudentsImport;

class SchoolStudentController extends Controller
{
    /**
     * 📊 LIST
     */
    public function index(Request $request)
    {
        $query = User::query();

        $query->where('role','student')
              ->where('school_id', auth()->user()->school_id)

              // ✅ FINAL RELATION FIX
              ->with([
                  'studentClass:id,name',
                  'studentSection:id,name'
              ]);

        // 🔍 Search
        if ($request->search) {
            $query->where(function($q) use ($request){
                $q->where('name','like','%'.$request->search.'%')
                  ->orWhere('mobile','like','%'.$request->search.'%');
            });
        }

        // 🎯 Filters
        if ($request->status !== null) {
            $query->where('is_active', $request->status);
        }

        if ($request->class_id) {
            $query->where('class_id', $request->class_id);
        }

        if ($request->section_id) {
            $query->where('section_id', $request->section_id);
        }

        $students = $query->latest()->paginate(10);

        return view('school_admin.students.index', compact('students'));
    }

    /**
     * ➕ CREATE
     */
    public function create()
    {
        $classes = SchoolClass::with('sections')->get();

        $routes = TransportRoute::where('school_id', auth()->user()->school_id)->get();

        return view('school_admin.students.create', compact('classes','routes'));
    }

    /**
     * 💾 STORE
     */
    public function store(Request $request)
    {
        $school = auth()->user()->school;

        // Limit check
        $totalStudents = User::where('role','student')
            ->where('school_id', $school->id)
            ->count();

        if ($school->student_limit && $totalStudents >= $school->student_limit) {
            return back()->with('error', '🚫 Student limit reached!');
        }

        // Validation
        $request->validate([
            'name'         => 'required',
            'father_name'  => 'required',
            'mother_name'  => 'required',
            'mobile'       => 'required|unique:users,mobile',
            'dob'          => 'required',
            'gender'       => 'required',

            'class_id'     => 'required',
            'section_id'   => 'required',
            'roll'         => 'required',

            'route_id' => [
                'required',
                Rule::exists('transport_routes','id')
                    ->where('school_id', $school->id)
            ],

            'address1'     => 'required',
            'state'        => 'required',
            'district'     => 'required',
            'city'         => 'required',
            'pin'          => 'required',
        ]);

        DB::beginTransaction();

        try {

            $regNo = 'REG'.time().rand(100,999);

            $photoPath = $request->hasFile('photo')
                ? $request->file('photo')->store('students','public')
                : null;

            // Student
            $student = User::create([
                'name'        => $request->name,
                'email'       => $request->mobile.'@student.com',
                'password'    => Hash::make($request->mobile),
                'role'        => 'student',
                'school_id'   => $school->id,

                'student_id'  => $regNo,
                'mobile'      => $request->mobile,

                'father_name' => $request->father_name,
                'mother_name' => $request->mother_name,

                'gender'      => $request->gender,
                'dob'         => $request->dob,

                'class_id'    => $request->class_id,
                'section_id'  => $request->section_id,
                'roll'        => $request->roll,

                'route_id'    => $request->route_id,
                'photo'       => $photoPath,

                'address1'    => $request->address1,
                'address2'    => $request->address2,

                'state'       => $request->state,
                'district'    => $request->district,
                'block'       => $request->block,
                'city'        => $request->city,
                'pin'         => $request->pin,

                'is_active'   => 1,
            ]);

            // Driver auto assign
            $assignment = DriverAssignment::where('route_id', $request->route_id)->first();
            if ($assignment) {
                $student->update(['driver_id' => $assignment->driver_id]);
            }

            // Parent
            $parent = User::where('mobile', $request->mobile)
                ->where('role','parent')
                ->first();

            if (!$parent) {
                $parent = User::create([
                    'name'      => $request->father_name,
                    'email'     => $request->mobile.'@parent.com',
                    'password'  => Hash::make($request->mobile),
                    'role'      => 'parent',
                    'school_id' => $school->id,
                    'mobile'    => $request->mobile,
                    'is_active' => 1
                ]);
            }

            // Link parent
            $student->update(['parent_id' => $parent->id]);

            DB::commit();

            return redirect()->route('school_admin.students.index')
                ->with('success', '✅ Student + Parent Created');

        } catch (\Exception $e) {

            DB::rollBack();

            return back()->with('error', '❌ '.$e->getMessage());
        }
    }

    /**
     * ✏️ EDIT
     */
    public function edit($id)
    {
        $student = User::where('role','student')->findOrFail($id);
        $classes = SchoolClass::with('sections')->get();
        $routes = TransportRoute::where('school_id', auth()->user()->school_id)->get();

        return view('school_admin.students.edit', compact('student','classes','routes'));
    }

    /**
     * 🔄 UPDATE
     */
    public function update(Request $request, $id)
    {
        $student = User::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'mobile' => [
                'required',
                Rule::unique('users')
                    ->where(fn($q) => $q->where('role','student'))
                    ->ignore($id),
            ],
            'route_id' => 'required|exists:transport_routes,id',
        ]);

        $photoPath = $request->hasFile('photo')
            ? $request->file('photo')->store('students','public')
            : $student->photo;

        $student->update([
            'name'        => $request->name,
            'mobile'      => $request->mobile,
            'father_name' => $request->father_name,
            'mother_name' => $request->mother_name,

            'gender'      => $request->gender,
            'dob'         => $request->dob,

            'class_id'    => $request->class_id,
            'section_id'  => $request->section_id,

            'route_id'    => $request->route_id,

            'address1'    => $request->address1,
            'address2'    => $request->address2,

            'state'       => $request->state,
            'district'    => $request->district,
            'block'       => $request->block,
            'city'        => $request->city,
            'pin'         => $request->pin,

            'photo'       => $photoPath,
        ]);

        if ($request->password) {
            $student->update([
                'password' => Hash::make($request->password)
            ]);
        }

        return redirect()->route('school_admin.students.index')
            ->with('success','✅ Student Updated');
    }

    /**
     * ❌ DELETE
     */
    public function destroy($id)
    {
        $student = User::findOrFail($id);

        User::where('role','parent')
            ->where('mobile',$student->mobile)
            ->delete();

        $student->delete();

        return back()->with('success','🗑 Student Deleted');
    }

    /**
     * 🔄 STATUS
     */
    public function toggleStatus($id)
    {
        $student = User::findOrFail($id);

        $student->is_active = !$student->is_active;
        $student->save();

        return back()->with('success','🔄 Status updated');
    }

    /**
     * 👁 VIEW
     */
    public function show($id)
    {
        $student = User::where('role','student')->findOrFail($id);

        $parent = User::where('role','parent')
            ->where('mobile',$student->mobile)
            ->first();

        return view('school_admin.students.view', compact('student','parent'));
    }

    /**
     * 📤 EXPORT
     */
    public function export()
    {
        $students = User::where('role','student')
            ->where('school_id', auth()->user()->school_id)
            ->with(['studentClass','studentSection'])
            ->get();

        return response()->streamDownload(function() use ($students) {

            $output = fopen('php://output', 'w');

            fputcsv($output, [
                'Name','Father','Reg No','Class','Section','Mobile'
            ]);

            foreach ($students as $s) {
                fputcsv($output, [
                    $s->name,
                    $s->father_name,
                    $s->student_id,
                    $s->studentClass->name ?? '-',
                    $s->studentSection->name ?? '-',
                    $s->mobile
                ]);
            }

            fclose($output);

        }, "students.csv");
    }

    /**
     * 📥 IMPORT
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv'
        ]);

        Excel::import(new StudentsImport, $request->file('file'));

        return back()->with('success', '✅ Students imported!');
    }

    /**
     * 📄 TEMPLATE
     */
    public function template()
    {
        return response()->streamDownload(function () {

            $output = fopen('php://output', 'w');

            fputcsv($output, [
                'name','mobile','father_name','mother_name','gender','dob',
                'class_id','section_id','roll',
                'address1','address2','state','district','block','city','pin'
            ]);

            fclose($output);

        }, "students_template.csv");
    }
}