<?php

namespace App\Http\Controllers\SchoolAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Fee;

class SchoolFeeController extends Controller
{
    /**
     * 📋 Fees List (View Only)
     */
    public function index()
    {
        $school = auth()->user()->school_id;

        $fees = Fee::where('school_id', $school)
                    ->latest()
                    ->paginate(10);

        return view('school_admin.fees.index', compact('fees'));
    }

    /**
     * 🧾 Invoice View (PDF/Page)
     */
    public function invoice($id)
    {
        $school = auth()->user()->school_id;

        $fee = Fee::where('school_id', $school)
                    ->findOrFail($id);

        return view('school_admin.fees.invoice', compact('fee'));
    }
}