@extends('layouts.super_admin')

@section('content')

<div class="p-4 md:p-6 max-w-3xl mx-auto">

    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-xl md:text-2xl font-bold text-gray-800">
            💳 Assign Subscription
        </h1>

        <a href="{{ route('super_admin.schools') }}"
           class="bg-gray-200 px-3 py-2 rounded-lg text-sm">
            ← Back
        </a>
    </div>

    <!-- Card -->
    <div class="bg-white p-6 rounded-2xl shadow">

        <!-- School Info -->
        <div class="mb-6">
            <h2 class="text-lg font-semibold text-gray-700">
                🏫 {{ $school->name }}
            </h2>
            <p class="text-gray-500 text-sm">
                {{ $school->city }}, {{ $school->district }}
            </p>
        </div>

        <!-- Form -->
        <form method="POST"
              action="{{ route('super_admin.schools.subscribe.store', $school->id) }}">
            @csrf

            <!-- Plan Select -->
            <div class="mb-4">
                <label class="text-sm text-gray-600">Select Plan</label>

                <select name="plan_id"
                        class="w-full mt-1 p-2 border rounded-lg focus:ring-2 focus:ring-indigo-500">

                    <option value="">-- Choose Plan --</option>

                    @foreach($plans as $plan)
                        <option value="{{ $plan->id }}">
                            {{ $plan->name }} (₹{{ $plan->price }} / {{ $plan->duration }} days)
                        </option>
                    @endforeach

                </select>
            </div>

            <!-- Submit -->
            <div class="text-right mt-6">
                <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-lg">
                    🚀 Assign Plan
                </button>
            </div>

        </form>

    </div>

</div>

@endsection