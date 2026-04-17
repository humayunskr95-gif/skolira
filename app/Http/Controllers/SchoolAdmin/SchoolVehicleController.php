<?php

namespace App\Http\Controllers\SchoolAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vehicle;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\VehicleExport;

class SchoolVehicleController extends Controller
{
    /**
     * 📊 LIST + SEARCH
     */
    public function index(Request $request)
    {
        $query = Vehicle::where('school_id', auth()->user()->school_id);

        if ($request->filled('search')) {
            $query->where(function($q) use ($request){
                $q->where('vehicle_no','like','%'.$request->search.'%')
                  ->orWhere('vehicle_type','like','%'.$request->search.'%');
            });
        }

        $vehicles = $query->latest()->paginate(10);

        return view('school_admin.transport.vehicle.index', compact('vehicles'));
    }

    /**
     * ➕ CREATE
     */
    public function create()
    {
        return view('school_admin.transport.vehicle.create');
    }

    /**
     * 💾 STORE
     */
    public function store(Request $request)
    {
        $request->validate([
            'vehicle_no'   => 'required|string|max:100',
            'vehicle_type' => 'nullable|string|max:100',
            'capacity'     => 'nullable|integer|min:1',
        ]);

        Vehicle::create([
            'vehicle_no'   => $request->vehicle_no,
            'vehicle_type' => $request->vehicle_type,
            'capacity'     => $request->capacity,
            'school_id'    => auth()->user()->school_id,
        ]);

        return redirect()->route('school_admin.transport.vehicle.index')
            ->with('success','Vehicle Added ✅');
    }

    /**
     * ✏️ EDIT
     */
    public function edit($id)
    {
        $vehicle = Vehicle::where('school_id', auth()->user()->school_id)
                          ->findOrFail($id);

        return view('school_admin.transport.vehicle.edit', compact('vehicle'));
    }

    /**
     * 🔄 UPDATE
     */
    public function update(Request $request, $id)
    {
        $vehicle = Vehicle::where('school_id', auth()->user()->school_id)
                          ->findOrFail($id);

        $request->validate([
            'vehicle_no'   => 'required|string|max:100',
            'vehicle_type' => 'nullable|string|max:100',
            'capacity'     => 'nullable|integer|min:1',
        ]);

        $vehicle->update([
            'vehicle_no'   => $request->vehicle_no,
            'vehicle_type' => $request->vehicle_type,
            'capacity'     => $request->capacity,
        ]);

        return redirect()->route('school_admin.transport.vehicle.index')
            ->with('success','Updated Successfully 🔄');
    }

    /**
     * ❌ DELETE
     */
    public function destroy($id)
    {
        $vehicle = Vehicle::where('school_id', auth()->user()->school_id)
                          ->findOrFail($id);

        $vehicle->delete();

        return back()->with('success','Deleted 🗑');
    }

    /**
     * 📤 EXPORT (FIXED 🔥)
     */
    public function export()
    {
        return Excel::download(
            new VehicleExport(auth()->user()->school_id),
            'vehicles.xlsx'
        );
    }
}