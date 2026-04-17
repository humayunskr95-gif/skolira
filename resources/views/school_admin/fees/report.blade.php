@extends('layouts.school_admin')

@section('content')

<div class="p-4 md:p-6 space-y-6">

    <!-- 🔥 HEADER -->
    <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-3">
        <h2 class="text-2xl md:text-3xl font-bold text-gray-800">
            📊 Fees Report Dashboard
        </h2>

        <span class="text-sm text-gray-500">
            {{ now()->format('d M Y') }}
        </span>
    </div>

    <!-- 🔍 FILTER -->
    <form class="bg-white p-4 rounded-2xl shadow flex flex-col md:flex-row gap-3 items-center">

        <input type="date" name="from" value="{{ $from }}"
            class="border p-2 rounded-lg w-full md:w-auto">

        <input type="date" name="to" value="{{ $to }}"
            class="border p-2 rounded-lg w-full md:w-auto">

        <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-lg shadow w-full md:w-auto">
            🔍 Filter
        </button>

    </form>

    <!-- 💰 SUMMARY CARDS -->
    <div class="grid grid-cols-2 md:grid-cols-5 gap-4">

        <!-- Total -->
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white p-4 rounded-2xl shadow hover:scale-105 transition">
            <p class="text-sm opacity-80">Total</p>
            <h3 class="text-xl font-bold mt-1">₹{{ $total }}</h3>
        </div>

        <!-- Paid -->
        <div class="bg-gradient-to-r from-green-500 to-green-600 text-white p-4 rounded-2xl shadow hover:scale-105 transition">
            <p class="text-sm opacity-80">Paid</p>
            <h3 class="text-xl font-bold mt-1">₹{{ $paid }}</h3>
        </div>

        <!-- Due -->
        <div class="bg-gradient-to-r from-red-500 to-red-600 text-white p-4 rounded-2xl shadow hover:scale-105 transition">
            <p class="text-sm opacity-80">Due</p>
            <h3 class="text-xl font-bold mt-1">₹{{ $due }}</h3>
        </div>

        <!-- Expense -->
        <div class="bg-gradient-to-r from-yellow-400 to-yellow-500 text-white p-4 rounded-2xl shadow hover:scale-105 transition">
            <p class="text-sm opacity-80">Expense</p>
            <h3 class="text-xl font-bold mt-1">₹{{ $expense }}</h3>
        </div>

        <!-- Profit -->
        <div class="bg-gradient-to-r from-purple-500 to-purple-600 text-white p-4 rounded-2xl shadow hover:scale-105 transition">
            <p class="text-sm opacity-80">Profit</p>
            <h3 class="text-xl font-bold mt-1">₹{{ $profit }}</h3>
        </div>

    </div>

    <!-- 🏫 CLASS WISE -->
    <div class="bg-white rounded-2xl shadow overflow-hidden">

        <div class="p-4 border-b flex justify-between items-center">
            <h3 class="font-semibold text-gray-700">
                🏫 Class Wise Collection
            </h3>

            <span class="text-xs text-gray-400">
                Total Classes: {{ count($classWise) }}
            </span>
        </div>

        <div class="overflow-x-auto">

            <table class="w-full text-sm">

                <thead class="bg-gray-100 text-gray-600">
                    <tr>
                        <th class="p-3 text-left">Class</th>
                        <th class="p-3 text-left">Collection</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($classWise as $row)

                    <tr class="border-t hover:bg-gray-50 transition">
                        <td class="p-3 font-medium">
                            Class {{ $row->class_id }}
                        </td>

                        <td class="p-3 text-green-600 font-semibold">
                            ₹{{ $row->total }}
                        </td>
                    </tr>

                    @empty

                    <tr>
                        <td colspan="2" class="p-4 text-center text-gray-400">
                            No Data Found 🚫
                        </td>
                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection