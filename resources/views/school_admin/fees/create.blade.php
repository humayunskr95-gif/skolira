@extends('layouts.school_admin')

@section('content')

<div class="p-6">

<h2 class="text-xl font-bold mb-4">➕ Add Fee</h2>

<form method="POST" action="{{ route('school_admin.fees.store') }}"
      class="bg-white p-6 rounded shadow">

@csrf

<div class="grid grid-cols-2 gap-4">

    <!-- STUDENT -->
    <select name="student_id" class="border p-2 rounded" required>
        <option value="">Select Student</option>
        @foreach($students as $s)
            <option value="{{ $s->id }}">{{ $s->name }}</option>
        @endforeach
    </select>

    <!-- CLASS -->
    <select name="class_id" class="border p-2 rounded" required>
        <option value="">Select Class</option>
        @foreach($classes as $c)
            <option value="{{ $c->id }}">{{ $c->name }}</option>
        @endforeach
    </select>

    <!-- TOTAL AMOUNT -->
    <input type="number" name="amount" placeholder="Total Amount"
           class="border p-2 rounded" required>

    <!-- PAID AMOUNT -->
    <input type="number" name="paid_amount" placeholder="Paid Amount (optional)"
           class="border p-2 rounded">

    <!-- DATE -->
    <input type="date" name="date" class="border p-2 rounded" required>

    <!-- PAYMENT METHOD -->
    <input type="text" name="payment_method"
           placeholder="Payment Method (Cash / UPI / Bank)"
           class="border p-2 rounded">

    <!-- TRANSACTION ID -->
    <input type="text" name="transaction_id"
           placeholder="Transaction ID"
           class="border p-2 rounded">

</div>

<button class="mt-4 bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">
    💾 Save Fee
</button>

</form>

</div>

@endsection