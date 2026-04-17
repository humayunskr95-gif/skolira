@extends('layouts.transport')

@section('content')

<h2 class="text-xl font-bold mb-4">📍 My Route</h2>

<div class="bg-white p-6 rounded-xl shadow space-y-3">

    <div>
        <span class="font-semibold">Route Name:</span>
        {{ $assignment?->route?->name ?? 'N/A' }}
    </div>

    <div>
        <span class="font-semibold">Start Point:</span>
        {{ $assignment?->route?->start_point ?? '-' }}
    </div>

    <div>
        <span class="font-semibold">End Point:</span>
        {{ $assignment?->route?->end_point ?? '-' }}
    </div>

    <div>
        <span class="font-semibold">Vehicle:</span>
        {{ $assignment?->vehicle?->vehicle_no ?? '-' }}
    </div>

</div>

@endsection