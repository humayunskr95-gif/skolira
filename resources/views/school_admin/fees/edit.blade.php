@extends('layouts.school_admin')

@section('content')

<div class="p-6">

<h2 class="text-xl font-bold mb-4">✏️ Edit Fee</h2>

<form method="POST"
      action="{{ route('school_admin.fees.update',$fee->id) }}"
      class="bg-white p-6 rounded shadow">

@csrf
@method('PUT')

<div class="grid grid-cols-2 gap-4">

    <select name="student_id" class="border p-2">
        @foreach($students as $s)
            <option value="{{ $s->id }}"
                {{ $fee->student_id == $s->id ? 'selected' : '' }}>
                {{ $s->name }}
            </option>
        @endforeach
    </select>

    <select name="class_id" class="border p-2">
        @foreach($classes as $c)
            <option value="{{ $c->id }}"
                {{ $fee->class_id == $c->id ? 'selected' : '' }}>
                {{ $c->name }}
            </option>
        @endforeach
    </select>

    <input type="number" name="amount"
           value="{{ $fee->amount }}"
           class="border p-2">

    <input type="date" name="date"
           value="{{ $fee->date->format('Y-m-d') }}"
           class="border p-2">

    <input type="text" name="payment_method"
           value="{{ $fee->payment_method }}"
           class="border p-2">

    <input type="text" name="transaction_id"
           value="{{ $fee->transaction_id }}"
           class="border p-2">

</div>

<button class="mt-4 bg-blue-500 text-white px-4 py-2 rounded">
    Update
</button>

</form>

</div>

@endsection