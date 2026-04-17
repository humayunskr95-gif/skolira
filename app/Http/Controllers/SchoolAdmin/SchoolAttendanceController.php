<?php

namespace App\Http\Controllers\SchoolAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SchoolClass;
use App\Models\Attendance;
use App\Models\User;
use App\Exports\AttendanceExport;
use Maatwebsite\Excel\Facades\Excel;

class SchoolAttendanceController extends Controller
{
    // 📊 ADMIN VIEW (UPDATED 🔥)
    public function view(Request $request)
    {
        $classes = SchoolClass::with('sections')->get();

        $students = collect();

        if ($request->class_id && $request->date) {

            // ✅ Students fetch
            $students = User::where('role','student')
                ->where('school_id', auth()->user()->school_id)
                ->where('class_id', $request->class_id)
                ->when($request->section_id, function ($q) use ($request) {
                    $q->where('section_id', $request->section_id);
                })
                ->orderBy('roll')
                ->get();

            // ✅ Attendance fetch
            $attendances = Attendance::with('student')
    ->where('class_id', $request->class_id)
    ->when($request->section_id, function ($q) use ($request) {
        $q->where('section_id', $request->section_id);
    })
    ->whereDate('date', $request->date)
    ->get()
    ->keyBy('student_id');

            // ✅ Merge (MOST IMPORTANT 🔥)
            foreach ($students as $student) {
                $student->status = $attendances[$student->id]->status ?? 'absent';
            }
        }

        return view('school_admin.attendance.view', compact('classes','students'));
    }

    // 📊 CHART DATA (UNCHANGED)
    public function chart(Request $request)
    {
        $data = Attendance::selectRaw('status, COUNT(*) as total')
            ->where('school_id', auth()->user()->school_id)
            ->where('class_id', $request->class_id)
            ->when($request->section_id, function ($q) use ($request) {
                $q->where('section_id', $request->section_id);
            })
            ->when($request->date, function ($q) use ($request) {
                $q->whereDate('date', $request->date);
            })
            ->groupBy('status')
            ->pluck('total','status');

        return response()->json([
            'present' => $data['present'] ?? 0,
            'absent'  => $data['absent'] ?? 0,
        ]);
    }

    // 📅 MONTHLY REPORT
    public function monthlyReport(Request $request)
    {
        $records = Attendance::with('student')
            ->where('school_id', auth()->user()->school_id)
            ->where('class_id', $request->class_id)
            ->when($request->section_id, function ($q) use ($request) {
                $q->where('section_id', $request->section_id);
            })
            ->whereMonth('date', $request->month)
            ->get()
            ->groupBy('student_id');

        return view('school_admin.attendance.monthly', compact('records'));
    }

    // 📥 EXPORT
    public function export(Request $request)
    {
        return Excel::download(
            new AttendanceExport(
                $request->class_id,
                $request->section_id,
                auth()->user()->school_id
            ),
            'attendance.xlsx'
        );
    }
}