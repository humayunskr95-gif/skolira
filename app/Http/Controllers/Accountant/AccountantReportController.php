<?php

namespace App\Http\Controllers\Accountant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Fee;
use App\Models\Expense;

class AccountantReportController extends Controller
{
    /**
     * 📊 Main Report Page
     */
    public function index(Request $request)
    {
        // 🔍 Date Filter (optional)
        $from = $request->from;
        $to   = $request->to;

        $feesQuery = Fee::query();
        $expenseQuery = Expense::query();

        if ($from && $to) {
            $feesQuery->whereBetween('date', [$from, $to]);
            $expenseQuery->whereBetween('date', [$from, $to]);
        }

        // 💰 Calculations
        $totalFees     = $feesQuery->sum('amount');
        $totalExpenses = $expenseQuery->sum('amount');
        $profit        = $totalFees - $totalExpenses;

        // 📅 Monthly Report
        $monthlyFees = Fee::selectRaw('MONTH(date) as month, SUM(amount) as total')
            ->groupBy('month')
            ->pluck('total', 'month');

        $monthlyExpenses = Expense::selectRaw('MONTH(date) as month, SUM(amount) as total')
            ->groupBy('month')
            ->pluck('total', 'month');

        return view('accountant.reports.index', compact(
            'totalFees',
            'totalExpenses',
            'profit',
            'monthlyFees',
            'monthlyExpenses',
            'from',
            'to'
        ));
    }

    /**
     * 📊 Monthly Report JSON (for charts)
     */
    public function chart()
    {
        $fees = Fee::selectRaw('MONTH(date) as month, SUM(amount) as total')
            ->groupBy('month')
            ->pluck('total', 'month');

        $expenses = Expense::selectRaw('MONTH(date) as month, SUM(amount) as total')
            ->groupBy('month')
            ->pluck('total', 'month');

        return response()->json([
            'fees' => $fees,
            'expenses' => $expenses
        ]);
    }
}