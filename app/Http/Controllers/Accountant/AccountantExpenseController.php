<?php

namespace App\Http\Controllers\Accountant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Expense;

class AccountantExpenseController extends Controller
{
    /**
     * 📋 Expense List
     */
    public function index()
    {
        $expenses = Expense::latest()->paginate(10);

        return view('accountant.expenses.index', compact('expenses'));
    }

    /**
     * ➕ Create Page
     */
    public function create()
    {
        return view('accountant.expenses.create');
    }

    /**
     * 💾 Store Expense
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'amount'      => 'required|numeric|min:1',
            'date'        => 'required|date',
            'description' => 'nullable|string',
        ]);

        $school_id = 1; // 🔥 TEMP FIX (later change)

        Expense::create([
            'title'       => $request->title,
            'amount'      => $request->amount,
            'date'        => $request->date,
            'description' => $request->description,
            'school_id'   => $school_id, // 🔥 MUST
        ]);

        return redirect()
            ->route('accountant.expenses.index')
            ->with('success', 'Expense Added Successfully ✅');
    }

    /**
     * ✏️ Edit Page
     */
    public function edit($id)
    {
        $expense = Expense::findOrFail($id);

        return view('accountant.expenses.edit', compact('expense'));
    }

    /**
     * 🔄 Update Expense
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'amount'      => 'required|numeric|min:1',
            'date'        => 'required|date',
            'description' => 'nullable|string',
        ]);

        $expense = Expense::findOrFail($id);

        $expense->update([
            'title'       => $request->title,
            'amount'      => $request->amount,
            'date'        => $request->date,
            'description' => $request->description,
            'school_id'   => 1, // 🔥 FIX
        ]);

        return redirect()
            ->route('accountant.expenses.index') // 🔥 FIX
            ->with('success', 'Expense Updated Successfully ✏️');
    }

    /**
     * ❌ Delete Expense
     */
    public function destroy($id)
    {
        $expense = Expense::findOrFail($id);
        $expense->delete();

        return redirect()
            ->route('accountant.expenses.index') // 🔥 FIX
            ->with('success', 'Expense Deleted ❌');
    }
}