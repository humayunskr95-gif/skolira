<?php

namespace App\Http\Controllers\SchoolAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Fee;
use App\Models\Expense;

class SchoolFeesController extends Controller
{
    public function report(Request $request)
    {
        $school = auth()->user()->school_id;

        $from = $request->from ?? now()->startOfMonth();
        $to   = $request->to ?? now();

        $fees = Fee::where('school_id', $school)
                    ->whereBetween('created_at', [$from, $to]);

        $total = $fees->sum('amount');
        $paid  = $fees->where('status', 'paid')->sum('amount');
        $due   = $fees->where('status', 'due')->sum('amount');

        $expense = Expense::where('school_id', $school)
                        ->whereBetween('created_at', [$from, $to])
                        ->sum('amount');

        $profit = $paid - $expense;

        // 📊 Class wise
        $classWise = Fee::where('school_id', $school)
                        ->selectRaw('class_id, SUM(amount) as total')
                        ->groupBy('class_id')
                        ->get();

        return view('school_admin.fees.report', compact(
            'total','paid','due','expense','profit','classWise','from','to'
        ));
    }
}