<?php

namespace App\Http\Controllers\SchoolAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StaffAttendance;
use App\Models\User;

class SchoolStaffAttendanceController extends Controller
{
    /**
     * 📊 LIST + FILTER + SEARCH
     */
    public function index(Request $request)
    {
        $query = StaffAttendance::with('staff')->school();

        // 📅 Filter by date
        if ($request->filled('date')) {
            $query->whereDate('date', $request->date);
        }

        // 🔍 Filter by staff
        if ($request->filled('staff_id')) {
            $query->where('staff_id', $request->staff_id);
        }

        // 📌 Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // 🔍 Search by name
        if ($request->filled('search')) {
            $query->whereHas('staff', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }

        $attendances = $query->latest()->paginate(20)->withQueryString();

        // 👨‍🏫 Staff list
        $staffs = User::where('role', 'teacher')
                    ->where('school_id', auth()->user()->school_id)
                    ->get();

        // 📊 SUMMARY (dashboard use)
        $summary = [
    'present' => StaffAttendance::query()
                    ->where('school_id', auth()->user()->school_id)
                    ->where('status', 'present')
                    ->count(),

    'absent'  => StaffAttendance::query()
                    ->where('school_id', auth()->user()->school_id)
                    ->where('status', 'absent')
                    ->count(),

    'late'    => StaffAttendance::query()
                    ->where('school_id', auth()->user()->school_id)
                    ->where('status', 'late')
                    ->count(),
];

        return view('school_admin.staff_attendance.index', compact(
            'attendances',
            'staffs',
            'summary'
        ));
    }

    /**
     * 👁 VIEW SINGLE (optional)
     */
    public function show($id)
    {
        $attendance = StaffAttendance::with('staff')
            ->school()
            ->findOrFail($id);

        return view('school_admin.staff_attendance.show', compact('attendance'));
    }

    /**
     * 🗑 DELETE (optional)
     */
    public function destroy($id)
    {
        $attendance = StaffAttendance::school()->findOrFail($id);

        $attendance->delete();

        return back()->with('success', 'Attendance Deleted 🗑');
    }

    /**
     * 📤 EXPORT (simple CSV)
     */
    public function export()
    {
        $data = StaffAttendance::with('staff')
            ->school()
            ->get();

        $filename = "staff_attendance.csv";

        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
        ];

        $callback = function () use ($data) {
            $file = fopen('php://output', 'w');

            fputcsv($file, ['Staff', 'Date', 'Status', 'Check In', 'Check Out']);

            foreach ($data as $row) {
                fputcsv($file, [
                    $row->staff->name ?? '-',
                    $row->date,
                    $row->status,
                    $row->check_in,
                    $row->check_out,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}