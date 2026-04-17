@extends('layouts.accountant')

@section('content')

<div class="p-6">

    <h2 class="text-xl font-bold mb-4">Add Expense</h2>

    <form action="{{ route('accountant.expenses.store') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label>Title</label>
            <input type="text" name="title" class="w-full border p-2 rounded" required>
        </div>

        <div>
            <label>Amount</label>
            <input type="number" name="amount" class="w-full border p-2 rounded" required>
        </div>

        <div>
            <label>Date</label>
            <input type="date" name="date" class="w-full border p-2 rounded">
        </div>

        <button class="bg-blue-500 text-white px-4 py-2 rounded">
            Save Expense
        </button>

    </form>

</div>

@endsection