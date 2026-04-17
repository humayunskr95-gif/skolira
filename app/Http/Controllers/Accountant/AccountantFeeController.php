<?php

namespace App\Http\Controllers\Accountant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Fee;
use App\Models\User;

class AccountantFeeController extends Controller
{
    /**
     * 📋 Fee List
     */
    public function index()
    {
        $fees = Fee::with('student')
            ->latest()
            ->paginate(10);

        return view('accountant.fees.index', compact('fees'));
    }

    /**
     * ➕ Create Page
     */
    public function create()
    {
        $students = User::where('role', 'student')->get();

        return view('accountant.fees.create', compact('students'));
    }

    /**
     * 💾 Store Fee
     */
    public function store(Request $request)
{
    $request->validate([
        'student_id' => 'required|exists:users,id',
        'class_id'   => 'required',
        'amount'     => 'required|numeric|min:1',
        'date'       => 'required|date',
        'method'     => 'required|string',
    ]);

    $school_id = 1; // 🔥 FIX

    Fee::create([
        'student_id' => $request->student_id,
        'class_id'   => $request->class_id,
        'school_id'  => $school_id, // 🔥 MUST
        'amount'     => $request->amount,
        'date'       => $request->date,
        'method'     => $request->method,
    ]);

    return redirect()->route('accountant.fees.index')
        ->with('success', 'Fee Added Successfully ✅');
}

    /**
     * ✏️ Edit Page
     */
    public function edit($id)
    {
        $fee = Fee::findOrFail($id);
        $students = User::where('role', 'student')->get();

        return view('accountant.fees.edit', compact('fee', 'students'));
    }

    /**
     * 🔄 Update Fee
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'student_id' => 'required|exists:users,id',
            'class_id'   => 'required', // 🔥 FIX
            'amount'     => 'required|numeric|min:1',
            'date'       => 'required|date',
            'method'     => 'required|string',
        ]);

        $fee = Fee::findOrFail($id);

        $fee->update([
            'student_id' => $request->student_id,
            'class_id'   => $request->class_id, // 🔥 FIX
            'amount'     => $request->amount,
            'date'       => $request->date,
            'method'     => $request->method,
        ]);

        return redirect()
            ->route('accountant.fees.index') // 🔥 FIX
            ->with('success', 'Fee Updated ✏️');
    }

    /**
     * ❌ Delete Fee
     */
    public function destroy($id)
    {
        $fee = Fee::findOrFail($id);
        $fee->delete();

        return redirect()
            ->route('accountant.fees.index') // 🔥 FIX
            ->with('success', 'Fee Deleted ❌');
    }
}