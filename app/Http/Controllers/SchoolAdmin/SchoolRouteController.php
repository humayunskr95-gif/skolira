<?php

namespace App\Http\Controllers\SchoolAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TransportRoute;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RouteExport;

class SchoolRouteController extends Controller
{
    /**
     * 📊 LIST + SEARCH
     */
    public function index(Request $request)
    {
        $query = TransportRoute::where('school_id', auth()->user()->school_id);

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $routes = $query->latest()->paginate(10)->withQueryString();

        return view('school_admin.transport.route.index', compact('routes'));
    }

    /**
     * ➕ CREATE
     */
    public function create()
    {
        return view('school_admin.transport.route.create');
    }

    /**
     * 💾 STORE
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:transport_routes,name,NULL,id,school_id,' . auth()->user()->school_id,
            'start_point' => 'nullable|string|max:150',
            'end_point' => 'nullable|string|max:150',
        ]);

        TransportRoute::create([
            'name' => $request->name,
            'start_point' => $request->start_point,
            'end_point' => $request->end_point,
            'school_id' => auth()->user()->school_id,
        ]);

        return redirect()->route('school_admin.transport.route.index')
            ->with('success', 'Route Added ✅');
    }

    /**
     * ✏️ EDIT
     */
    public function edit($id)
    {
        $route = TransportRoute::where('school_id', auth()->user()->school_id)
            ->findOrFail($id);

        return view('school_admin.transport.route.edit', compact('route'));
    }

    /**
     * 🔄 UPDATE
     */
    public function update(Request $request, $id)
    {
        $route = TransportRoute::where('school_id', auth()->user()->school_id)
            ->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:100|unique:transport_routes,name,' . $id . ',id,school_id,' . auth()->user()->school_id,
            'start_point' => 'nullable|string|max:150',
            'end_point' => 'nullable|string|max:150',
        ]);

        $route->update([
            'name' => $request->name,
            'start_point' => $request->start_point,
            'end_point' => $request->end_point,
        ]);

        return redirect()->route('school_admin.transport.route.index')
            ->with('success', 'Updated Successfully 🔄');
    }

    /**
     * ❌ DELETE (Protected 🔥)
     */
    public function destroy($id)
    {
        $route = TransportRoute::where('school_id', auth()->user()->school_id)
            ->findOrFail($id);

        // 🔥 Prevent delete if assigned
        if ($route->assignments()->count() > 0) {
            return back()->with('error', 'Route already assigned ❌');
        }

        $route->delete();

        return back()->with('success', 'Deleted 🗑');
    }

    /**
     * 📤 EXPORT
     */
    public function export()
    {
        return Excel::download(
            new RouteExport(auth()->user()->school_id),
            'routes.xlsx'
        );
    }
}