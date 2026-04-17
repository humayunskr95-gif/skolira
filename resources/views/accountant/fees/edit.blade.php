@extends('layouts.accountant')

@section('content')

<div class="p-6 max-w-xl mx-auto">

    <h2 class="text-xl font-bold mb-4">✏️ Edit Fee</h2>

    <form method="POST"
          action="{{ route('accountant.fees.update',$fee->id) }}">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label>Student</label>
        <select name="student_id" class="w-full border p-2 rounded">
            @foreach($students as $student)
                <option value="{{ $student->id }}"
                {{ $student->id == $fee->student_id ? 'selected' : '' }}>
                    {{ $student->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label>Amount</label>
        <input type="number" name="amount"
               value="{{ $fee->amount }}"
               class="w-full border p-2 rounded">
    </div>

    <div class="mb-3">
        <label>Date</label>
        <input type="date" name="date"
               value="{{ $fee->date }}"
               class="w-full border p-2 rounded">
    </div>

    <div class="mb-3">
        <label>Method</label>
        <select name="method" class="w-full border p-2 rounded">
            <option {{ $fee->method=='Cash'?'selected':'' }}>Cash</option>
            <option {{ $fee->method=='Online'?'selected':'' }}>Online</option>
            <option {{ $fee->method=='UPI'?'selected':'' }}>UPI</option>
        </select>
    </div>

    <button class="bg-blue-500 text-white px-4 py-2 rounded">
        Update Fee
    </button>

    </form>

</div>

@endsection