@extends('layouts.accountant')

@section('content')

<div class="p-6">

    <div class="flex justify-between mb-4">
        <h2 class="text-2xl font-bold">💸 Expenses</h2>

        <a href="{{ route('accountant.expenses.create') }}"
           class="bg-green-500 text-white px-4 py-2 rounded">
            ➕ Add Expense
        </a>
    </div>

    <table class="w-full bg-white shadow rounded">

        <tr class="bg-gray-200">
            <th class="p-3">Title</th>
            <th>Amount</th>
            <th>Date</th>
            <th>Action</th>
        </tr>

        @foreach($expenses as $exp)
        <tr class="border-b">
            <td class="p-3">{{ $exp->title }}</td>
            <td>₹ {{ $exp->amount }}</td>
            <td>{{ $exp->date }}</td>

            <td class="flex gap-2 p-3">
                <a href="{{ route('accountant.expenses.edit',$exp->id) }}"
                   class="bg-blue-500 text-white px-2 py-1 rounded">✏️</a>

                <form method="POST"
                      action="{{ route('accountant.expenses.destroy',$exp->id) }}">
                    @csrf
                    @method('DELETE')

                    <button class="bg-red-500 text-white px-2 py-1 rounded">
                        🗑
                    </button>
                </form>
            </td>
        </tr>
        @endforeach

    </table>

</div>

@endsection