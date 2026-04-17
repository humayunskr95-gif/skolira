@extends('layouts.super_admin')

@section('content')

<div class="max-w-5xl mx-auto">

    <div class="bg-white rounded-2xl shadow-lg p-8">

        <!-- Top -->
        <div class="flex items-center gap-6 mb-6">

            @if($school->logo)
                <img src="{{ asset('storage/'.$school->logo) }}"
                     class="w-24 h-24 rounded-full object-cover border">
            @else
                <div class="w-24 h-24 bg-gray-200 rounded-full flex items-center justify-center text-3xl">
                    🏫
                </div>
            @endif

            <div>
                <h1 class="text-2xl font-bold text-gray-800">
                    {{ $school->name ?? 'N/A' }}
                </h1>

                <p class="text-gray-500">
                    👤 Owner:
                    <strong>{{ $school->owner_name ?? 'N/A' }}</strong>
                </p>

                <p class="text-gray-400 text-sm">
                    📅 {{ $school->created_at?->format('d M Y') }}
                </p>
            </div>

        </div>

        <hr class="my-6">

        <!-- Address -->
        <div class="grid grid-cols-2 gap-6 text-sm">

            <!-- Address Box -->
            <div class="bg-gray-50 p-4 rounded-lg">
                <h3 class="font-semibold text-gray-600 mb-2">📍 Address</h3>

                <p>{{ $school->address1 ?? '-' }}</p>
                <p>{{ $school->address2 ?? '-' }}</p>

                <p class="text-gray-500 mt-2">
                    {{ $school->city ?? '-' }},
                    {{ $school->district ?? '-' }}
                </p>

                <p class="text-gray-500">
                    {{ $school->state ?? '-' }} - {{ $school->pin ?? '-' }}
                </p>
            </div>

            <!-- Location -->
            <div class="bg-gray-50 p-4 rounded-lg">
                <h3 class="font-semibold text-gray-600 mb-2">🌍 Location</h3>

                <p><strong>City:</strong> {{ $school->city ?? '-' }}</p>
                <p><strong>District:</strong> {{ $school->district ?? '-' }}</p>
                <p><strong>State:</strong> {{ $school->state ?? '-' }}</p>
                <p><strong>PIN:</strong> {{ $school->pin ?? '-' }}</p>
            </div>

        </div>

        <!-- Back -->
        <div class="mt-6">
            <a href="{{ route('super_admin.schools') }}"
               class="bg-gray-200 px-4 py-2 rounded-lg">
                ← Back
            </a>
        </div>

    </div>

</div>

@endsection