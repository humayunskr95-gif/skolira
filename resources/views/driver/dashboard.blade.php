@extends('layouts.transport')

@section('content')

<h2 class="text-2xl font-bold mb-6">🚐 Driver Dashboard</h2>

<div class="grid grid-cols-1 md:grid-cols-3 gap-5">

    <!-- Route -->
    <div class="bg-gradient-to-r from-blue-500 to-indigo-500 text-white p-5 rounded-xl shadow">
        <p class="text-sm">Assigned Route</p>
        <h3 class="text-xl font-bold mt-2">
            {{ $assignment->route->name ?? 'N/A' }}
        </h3>
    </div>

    <!-- Vehicle -->
    <div class="bg-gradient-to-r from-green-500 to-emerald-500 text-white p-5 rounded-xl shadow">
        <p class="text-sm">Vehicle</p>
        <h3 class="text-xl font-bold mt-2">
            {{ $assignment->vehicle->vehicle_no ?? 'N/A' }}
        </h3>
    </div>

    <!-- Students -->
    <div class="bg-gradient-to-r from-purple-500 to-pink-500 text-white p-5 rounded-xl shadow">
        <p class="text-sm">Total Students</p>
        <h3 class="text-xl font-bold mt-2">
            {{ $students->count() }}
        </h3>
    </div>

</div>

@endsection