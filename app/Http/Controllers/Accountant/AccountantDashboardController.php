<?php
namespace App\Http\Controllers\Accountant;

use App\Http\Controllers\Controller;
use App\Models\Fee;
use App\Models\Expense;
use App\Models\User;

class AccountantDashboardController extends Controller
{
    public function index()
    {
        $totalStudents = User::where('role','student')->count();

        $totalFees = Fee::sum('amount');
        $totalExpenses = Expense::sum('amount');

        $profit = $totalFees - $totalExpenses;

        return view('accountant.dashboard', compact(
            'totalStudents',
            'totalFees',
            'totalExpenses',
            'profit'
        ));
    }
}