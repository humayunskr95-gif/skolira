<?php

namespace App\Http\Controllers\SchoolAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\HostelSuperExport;

class SchoolHostelSuperController extends Controller
{
    /**
     * 📊 List + Search + Pagination
     */
    public function index(Request $request)
    {
        $query = User::where('role','hostel_super')
            ->where('school_id', auth()->user()->school_id);

        if ($request->search) {
            $query->where(function($q) use ($request){
                $q->where('name','like','%'.$request->search.'%')
                  ->orWhere('email','like','%'.$request->search.'%')
                  ->orWhere('mobile','like','%'.$request->search.'%')
                  ->orWhere('hostel_super_code','like','%'.$request->search.'%');
            });
        }

        $users = $query->latest()->paginate(10);

        return view('school_admin.hostel_super.index', compact('users'));
    }

    /**
     * ➕ Create
     */
    public function create()
    {
        return view('school_admin.hostel_super.create');
    }

    /**
     * 💾 Store (FULL DATA)
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'father_name'=>'required',
            'dob'=>'required',
            'gender'=>'required',
            'mobile'=>'required',
            'email'=>'required|email|unique:users',
            'address1'=>'required',
            'address2'=>'required',
            'state'=>'required',
            'district'=>'required',
            'block'=>'required',
            'city'=>'required',
            'pin'=>'required',
            'photo'=>'required|image'
        ]);

        // 🔥 Code generate
        $code = 'HS' . rand(100,999);

        while (User::where('hostel_super_code',$code)->exists()) {
            $code = 'HS' . rand(100,999);
        }

        // 📸 Photo upload
        $photo = $request->file('photo')->store('hostel','public');

        User::create([
            'name'=>$request->name,
            'father_name'=>$request->father_name,
            'dob'=>$request->dob,
            'gender'=>$request->gender,
            'mobile'=>$request->mobile,
            'email'=>$request->email,
            'address1'=>$request->address1,
            'address2'=>$request->address2,
            'state'=>$request->state,
            'district'=>$request->district,
            'block'=>$request->block,
            'city'=>$request->city,
            'pin'=>$request->pin,
            'photo'=>$photo,

            'password'=>Hash::make('123456'),
            'role'=>'hostel_super',
            'school_id'=>auth()->user()->school_id,

            'hostel_super_code'=>$code,
        ]);

        return redirect()->route('school_admin.hostel_super.index')
            ->with('success','Hostel Super Created ✅');
    }

    /**
     * ✏️ Edit
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('school_admin.hostel_super.edit', compact('user'));
    }

    /**
     * 🔄 Update (FULL DATA)
     */
    public function update(Request $request,$id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name'=>'required',
            'father_name'=>'required',
            'dob'=>'required',
            'gender'=>'required',
            'mobile'=>'required',
            'email'=>'required|email|unique:users,email,'.$id,
            'address1'=>'required',
            'address2'=>'required',
            'state'=>'required',
            'district'=>'required',
            'block'=>'required',
            'city'=>'required',
            'pin'=>'required',
        ]);

        $data = $request->except('photo','password');

        // 🔐 Password update
        if($request->password){
            $data['password'] = Hash::make($request->password);
        }

        // 📸 Photo update
        if($request->hasFile('photo')){
            $data['photo'] = $request->file('photo')->store('hostel','public');
        }

        $user->update($data);

        return redirect()->route('school_admin.hostel_super.index')
            ->with('success','Updated Successfully 🔄');
    }

    /**
     * ❌ Delete
     */
    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return back()->with('success','Deleted 🗑');
    }

    /**
     * 🔄 Status Toggle
     */
    public function toggle($id)
    {
        $user = User::findOrFail($id);
        $user->status = !$user->status;
        $user->save();

        return back()->with('success','Status Updated 🔄');
    }

    /**
     * 📤 Export Excel
     */
    public function export()
    {
        return Excel::download(new HostelSuperExport, 'hostel_super.xlsx');
    }

    /**
     * 👁 View
     */
    public function view($id)
    {
        $user = User::findOrFail($id);
        return view('school_admin.hostel_super.view', compact('user'));
    }
}