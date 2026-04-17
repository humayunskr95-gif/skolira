<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DriverAssignment;
use App\Models\User;

class DriverController extends Controller
{
    /**
     * 🚐 Driver Dashboard
     */
    public function dashboard()
    {
        $driverId = auth()->id();

        $assignment = DriverAssignment::with(['route','vehicle'])
            ->where('driver_id', $driverId)
            ->first();

        $students = User::where('role','student')
            ->where('driver_id', $driverId)
            ->get();

        return view('driver.dashboard', [
            'assignment'     => $assignment,
            'students'       => $students,
            'totalStudents'  => $students->count(),
        ]);
    }

    /**
     * 📍 My Route
     */
    public function route()
    {
        $assignment = DriverAssignment::with(['route','vehicle'])
            ->where('driver_id', auth()->id())
            ->first();

        return view('driver.route', compact('assignment'));
    }

    /**
     * 👨‍🎓 Students List
     */
    public function students()
    {
        $students = User::where('role','student')
            ->where('driver_id', auth()->id())
            ->latest()
            ->get();

        return view('driver.students', compact('students'));
    }

    /**
     * ✅ Pickup Action (TOGGLE VERSION 🔥)
     */
    public function pickup($id)
    {
        $student = User::where('role','student')
            ->where('driver_id', auth()->id())
            ->findOrFail($id);

        // 🔥 toggle pickup (0 ↔ 1)
        $student->update([
            'pickup_status' => !$student->pickup_status
        ]);

        return back()->with('success', 'Status Updated ✅');
    }

    /**
     * 🔥 Reset Pickup (NEW FEATURE)
     */
    public function resetPickup()
    {
        User::where('role','student')
            ->where('driver_id', auth()->id())
            ->update(['pickup_status' => 0]);

        return back()->with('success','All Pickup Reset 🔄');
    }

    /**
     * 🔥 Safety redirect
     */
    public function index()
    {
        return redirect()->route('driver.dashboard');
    }
}