<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\StaffAttendance;
use Illuminate\Http\Request;

class TeacherAttendanceController extends Controller
{
    /**
     * 📝 My Attendance List
     */
    public function index(Request $request)
    {
        $teacherId = auth()->id();

        $query = StaffAttendance::where('staff_id', $teacherId);

        // 📅 Filter by date
        if ($request->filled('date')) {
            $query->whereDate('date', $request->date);
        }

        // 📊 Data list
        $attendances = $query->latest()
            ->paginate(10)
            ->withQueryString();

        // 📊 Summary
        $summary = [
            'present' => StaffAttendance::where('staff_id', $teacherId)
                ->where('status', 'present')
                ->count(),

            'absent' => StaffAttendance::where('staff_id', $teacherId)
                ->where('status', 'absent')
                ->count(),
        ];

        // 📅 Today status
        $today = StaffAttendance::where('staff_id', $teacherId)
            ->whereDate('date', now())
            ->first();

        return view('teacher.attendance.index', compact(
            'attendances',
            'summary',
            'today'
        ));
    }
    /**
 * 📝 Mark Attendance
 */
public function mark(Request $request)
{
    $request->validate([
        'status' => 'required|in:present,absent'
    ]);

    $teacherId = auth()->id();
    $today = now()->toDateString();

    StaffAttendance::updateOrCreate(
        [
            'staff_id' => $teacherId,
            'date' => $today,
        ],
        [
            'school_id' => auth()->user()->school_id,
            'status' => $request->status,
            'check_in' => now(),
        ]
    );

    return back()->with('success', 'Attendance Marked ✅');
}
  public function checkout()
{
    $attendance = StaffAttendance::where('staff_id', auth()->id())
        ->whereDate('date', now())
        ->first();

    if (!$attendance) {
        return back()->with('error', 'First check-in required!');
    }

    if ($attendance->check_out) {
        return back()->with('error', 'Already checked out!');
    }

    $attendance->update([
        'check_out' => now()
    ]);

    return back()->with('success', 'Checked out successfully 🚪');
}
}