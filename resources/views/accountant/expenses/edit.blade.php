@extends('layouts.accountant')

@section('content')

<div class="p-6 max-w-xl mx-auto bg-white shadow rounded">

    <h2 class="text-xl font-bold mb-4">✏️ Edit Expense</h2>

    <form method="POST" action="{{ route('accountant.expenses.update', $expense->id) }}">
        @csrf
        @method('PUT') <!-- 🔥 IMPORTANT -->

        <!-- TITLE -->
        <div class="mb-4">
            <label>Title</label>
            <input type="text" name="title"
                value="{{ $expense->title }}"
                class="w-full border p-2 rounded" required>
        </div>

        <!-- AMOUNT -->
        <div class="mb-4">
            <label>Amount</label>
            <input type="number" name="amount"
                value="{{ $expense->amount }}"
                class="w-full border p-2 rounded" required>
        </div>

        <!-- DATE -->
        <div class="mb-4">
            <label>Date</label>
            <input type="date" name="date"
                value="{{ $expense->date }}"
                class="w-full border p-2 rounded" required>
        </div>

        <!-- DESCRIPTION -->
        <div class="mb-4">
            <label>Description</label>
            <input type="text" name="description"
                value="{{ $expense->description }}"
                class="w-full border p-2 rounded">
        </div>

        <button class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded w-full">
            Update Expense
        </button>

    </form>

</div>

@endsection