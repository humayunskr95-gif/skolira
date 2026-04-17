@extends('layouts.accountant')

@section('content')

<div class="p-6">

<h2 class="text-2xl font-bold mb-6">📊 Accountant Dashboard</h2>

<div class="grid md:grid-cols-4 gap-4">

    <div class="bg-green-500 text-white p-5 rounded-xl">
        <h4>Total Students</h4>
        <h2 class="text-2xl">{{ $totalStudents }}</h2>
    </div>

    <div class="bg-blue-500 text-white p-5 rounded-xl">
        <h4>Total Fees</h4>
        <h2 class="text-2xl">₹ {{ $totalFees }}</h2>
    </div>

    <div class="bg-red-500 text-white p-5 rounded-xl">
        <h4>Expenses</h4>
        <h2 class="text-2xl">₹ {{ $totalExpenses }}</h2>
    </div>

    <div class="bg-purple-500 text-white p-5 rounded-xl">
        <h4>Profit</h4>
        <h2 class="text-2xl">₹ {{ $profit }}</h2>
    </div>

</div>

</div>

@endsection