<?php

namespace App\Http\Controllers\SchoolAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\TransportRoute;
use App\Models\DriverAssignment;
use Illuminate\Http\Request;

class SchoolDriverAssignController extends Controller
{
    /**
     * 📋 Assignment List
     */
    public function index()
    {
        $assignments = DriverAssignment::with(['driver','vehicle','route'])
            ->latest()
            ->get();

        return view('school_admin.transport.assign.index', compact('assignments'));
    }

    /**
     * ➕ Create Page
     */
    public function create()
    {
        // 🔥 FIX: driver role same rakho everywhere
        $drivers = User::where('role','driver')->get();

        $vehicles = Vehicle::all();
        $routes   = TransportRoute::all();

        return view('school_admin.transport.assign.create', compact('drivers','vehicles','routes'));
    }

    /**
     * 💾 Store Assignment
     */
    public function store(Request $request)
    {
        $request->validate([
            'driver_id'  => 'required|exists:users,id',
            'vehicle_id' => 'required|exists:vehicles,id',
            'route_id'   => 'required|exists:transport_routes,id',
        ]);

        // 🚫 Prevent duplicate driver assign
        if (DriverAssignment::where('driver_id',$request->driver_id)->exists()) {
            return back()->withErrors([
                'driver_id' => '⚠ Driver already assigned!'
            ]);
        }

        // ✅ Create assignment
        $assignment = DriverAssignment::create([
            'driver_id'  => $request->driver_id,
            'vehicle_id' => $request->vehicle_id,
            'route_id'   => $request->route_id,
        ]);

        // 🔥 AUTO ASSIGN STUDENTS
        User::where('role','student')
            ->where('route_id', $request->route_id)
            ->update([
                'driver_id' => $request->driver_id
            ]);

        return redirect()->route('school_admin.transport.assign.index')
            ->with('success','Driver Assigned & Students Linked ✅');
    }

    /**
     * ✏️ Edit Page
     */
    public function edit($id)
    {
        $assignment = DriverAssignment::findOrFail($id);

        $drivers  = User::where('role','driver')->get();
        $vehicles = Vehicle::all();
        $routes   = TransportRoute::all();

        return view('school_admin.transport.assign.edit', compact(
            'assignment',
            'drivers',
            'vehicles',
            'routes'
        ));
    }

    /**
     * 🔄 Update Assignment
     */
    public function update(Request $request, $id)
    {
        $assignment = DriverAssignment::findOrFail($id);

        $request->validate([
            'driver_id'  => 'required|exists:users,id',
            'vehicle_id' => 'required|exists:vehicles,id',
            'route_id'   => 'required|exists:transport_routes,id',
        ]);

        // 🔥 OLD DRIVER REMOVE FROM STUDENTS
        User::where('driver_id', $assignment->driver_id)
            ->update(['driver_id' => null]);

        // ✅ Update assignment
        $assignment->update([
            'driver_id'  => $request->driver_id,
            'vehicle_id' => $request->vehicle_id,
            'route_id'   => $request->route_id,
        ]);

        // 🔥 NEW AUTO ASSIGN
        User::where('role','student')
            ->where('route_id', $request->route_id)
            ->update([
                'driver_id' => $request->driver_id
            ]);

        return redirect()->route('school_admin.transport.assign.index')
            ->with('success', 'Updated & Students Reassigned 🔄');
    }

    /**
     * ❌ Delete Assignment
     */
    public function destroy($id)
    {
        $assignment = DriverAssignment::findOrFail($id);

        // 🔥 REMOVE DRIVER FROM STUDENTS
        User::where('driver_id', $assignment->driver_id)
            ->update(['driver_id' => null]);

        $assignment->delete();

        return back()->with('success','Assignment Deleted ❌');
    }
}