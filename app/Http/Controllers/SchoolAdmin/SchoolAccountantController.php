<?php

namespace App\Http\Controllers\SchoolAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AccountantExport;

class SchoolAccountantController extends Controller
{
    /**
     * 📊 List
     */
    public function index(Request $request)
{
    $query = User::where('role','accountant');

    // 🔍 Search
    if ($request->search) {
        $query->where(function($q) use ($request) {
            $q->where('name','like','%'.$request->search.'%')
              ->orWhere('email','like','%'.$request->search.'%')
              ->orWhere('mobile','like','%'.$request->search.'%')
              ->orWhere('account_code','like','%'.$request->search.'%');
        });
    }

    $accountants = $query->latest()->paginate(10);

    return view('school_admin.accountants.index', compact('accountants'));
}

    /**
     * ➕ Create Page
     */
    public function create()
    {
        return view('school_admin.accountants.create');
    }

    /**
     * 💾 Store
     */
    public function store(Request $request)
{
    $request->validate([
        'name'   => 'required',
        'email'  => 'required|email|unique:users',
        'mobile' => 'required',
    ]);

    // ✅ Account Code
    $account_code = 'SKACCOUNT' . rand(10,99);

    while (User::where('account_code', $account_code)->exists()) {
        $account_code = 'SKACCOUNT' . rand(10,99);
    }

    // 📸 Photo Upload
    $photo = null;
    if ($request->hasFile('photo')) {
        $photo = $request->file('photo')->store('accountants','public');
    }

    User::create([
        'name' => $request->name,
        'father_name' => $request->father_name,
        'dob' => $request->dob,
        'gender' => $request->gender,
        'mobile' => $request->mobile,
        'email' => $request->email,
        'address1' => $request->address1,
        'address2' => $request->address2,
        'state' => $request->state,
        'district' => $request->district,
        'block' => $request->block,
        'city' => $request->city,
        'pin' => $request->pin,

        'photo' => $photo,

        'password' => Hash::make('123456'),
        'role' => 'accountant',
        'school_id' => auth()->user()->school_id,

        'account_code' => $account_code,
    ]);

    return redirect()->route('school_admin.accountants.index')
        ->with('success', 'Accountant Created ✅');
}

    /**
     * ✏️ Edit
     */
    public function edit($id)
    {
        $accountant = User::findOrFail($id);

        return view('school_admin.accountants.edit', compact('accountant'));
    }

    /**
     * 🔄 Update
     */
    public function update(Request $request, $id)
{
    $accountant = User::findOrFail($id);

    $request->validate([
        'name'   => 'required',
        'email'  => 'required|email|unique:users,email,'.$id,
        'mobile' => 'required',
    ]);

    $data = [
        'name' => $request->name,
        'father_name' => $request->father_name,
        'dob' => $request->dob,
        'gender' => $request->gender,
        'mobile' => $request->mobile,
        'email' => $request->email,
        'address1' => $request->address1,
        'address2' => $request->address2,
        'state' => $request->state,
        'district' => $request->district,
        'block' => $request->block,
        'city' => $request->city,
        'pin' => $request->pin,
    ];

    // 🔐 Password optional
    if ($request->password) {
        $data['password'] = Hash::make($request->password);
    }

    // 📸 Photo update
    if ($request->hasFile('photo')) {
        $data['photo'] = $request->file('photo')->store('accountants','public');
    }

    $accountant->update($data);

    return redirect()->route('school_admin.accountants.index')
        ->with('success', 'Updated Successfully 🔄');
}
    /**
     * ❌ Delete
     */
    public function destroy($id)
    {
        User::findOrFail($id)->delete();

        return back()->with('success', 'Deleted 🗑');
    }

    /**
     * 📤 Export Excel
     */
    public function export()
    {
        return Excel::download(new AccountantExport, 'accountants.xlsx');
    }
    public function show($id)
{
    $accountant = User::findOrFail($id);

    return view('school_admin.accountants.show', compact('accountant'));
}
  public function toggleStatus($id)
{
    $user = User::findOrFail($id);

    $user->status = !$user->status; // toggle
    $user->save();

    return back()->with('success', 'Status Updated 🔄');
}
}