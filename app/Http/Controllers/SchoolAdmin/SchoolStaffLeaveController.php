<?php

namespace App\Http\Controllers\SchoolAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StaffLeave;

class SchoolStaffLeaveController extends Controller
{
    /**
     * 📊 LIST + SEARCH + FILTER
     */
    public function index(Request $request)
    {
        $query = StaffLeave::with('staff')
                    ->where('school_id', auth()->user()->school_id);

        // 🔍 Search by staff name
        if ($request->filled('search')) {
            $query->whereHas('staff', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }

        // 📌 Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $leaves = $query->latest()->paginate(10)->withQueryString();

        return view('school_admin.staff_leave.index', compact('leaves'));
    }

    /**
     * 🔍 VIEW SINGLE (optional)
     */
    public function show($id)
    {
        $leave = StaffLeave::with('staff')
            ->where('school_id', auth()->user()->school_id)
            ->findOrFail($id);

        return view('school_admin.staff_leave.show', compact('leave'));
    }

    /**
     * ✅ APPROVE
     */
    public function approve($id)
    {
        $leave = StaffLeave::where('school_id', auth()->user()->school_id)
            ->findOrFail($id);

        // 🔥 already approved check
        if ($leave->status === 'approved') {
            return back()->with('info', 'Already Approved');
        }

        $leave->update(['status' => 'approved']);

        return back()->with('success', 'Leave Approved ✅');
    }

    /**
     * ❌ REJECT
     */
    public function reject($id)
    {
        $leave = StaffLeave::where('school_id', auth()->user()->school_id)
            ->findOrFail($id);

        // 🔥 already rejected check
        if ($leave->status === 'rejected') {
            return back()->with('info', 'Already Rejected');
        }

        $leave->update(['status' => 'rejected']);

        return back()->with('success', 'Leave Rejected ❌');
    }

    /**
     * 🗑 DELETE (optional)
     */
    public function destroy($id)
    {
        $leave = StaffLeave::where('school_id', auth()->user()->school_id)
            ->findOrFail($id);

        $leave->delete();

        return back()->with('success', 'Leave Deleted 🗑');
    }
}