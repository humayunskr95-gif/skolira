<?php

namespace App\Http\Controllers\SchoolAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;

class RoleController extends Controller
{
    // 📋 List
    public function index()
    {
        $roles = Role::latest()->get();
        return view('school_admin.roles.index', compact('roles'));
    }

    // ➕ Store
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name'
        ]);

        Role::create([
            'name' => strtolower($request->name)
        ]);

        return back()->with('success', '✅ Role added');
    }

    // ✏️ Edit (optional if using modal)
    public function edit($id)
    {
        $role = Role::findOrFail($id);
        return view('school_admin.roles.edit', compact('role'));
    }

    // 🔄 Update
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:roles,name,' . $id
        ]);

        $role = Role::findOrFail($id);

        $role->update([
            'name' => strtolower($request->name)
        ]);

        return redirect()->route('school_admin.roles.index')
            ->with('success', '✏️ Role updated');
    }

    // ❌ Delete
    public function destroy($id)
    {
        $role = Role::findOrFail($id);

        // ⚠️ Safety: prevent delete if users exist
        if ($role->users()->count() > 0) {
            return back()->with('error', '❌ Cannot delete. Role already assigned to users.');
        }

        $role->delete();

        return back()->with('success', '🗑 Role deleted');
    }
}