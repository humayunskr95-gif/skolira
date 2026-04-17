@extends('layouts.super_admin')

@section('content')

<div class="p-4 md:p-6 max-w-4xl mx-auto">

    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-xl md:text-2xl font-bold text-gray-800">✏️ Edit Plan</h1>

        <a href="{{ route('super_admin.plans') }}"
           class="bg-gray-200 px-3 py-2 rounded-lg text-sm">
            ← Back
        </a>
    </div>

    <!-- Card -->
    <div class="bg-white p-5 md:p-8 rounded-2xl shadow">

        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('super_admin.plans.update', $plan->id) }}">
    @csrf
    @method('PUT')

            <!-- BASIC -->
            <h2 class="font-semibold text-gray-700 mb-3">📦 Basic Info</h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                <input type="text" name="name"
                    value="{{ old('name', $plan->name) }}"
                    class="input" placeholder="Plan Name">

                <input type="number" name="price"
                    value="{{ old('price', $plan->price) }}"
                    class="input" placeholder="Price">

                <input type="number" name="duration"
                    value="{{ old('duration', $plan->duration) }}"
                    class="input" placeholder="Duration">

            </div>

            <!-- LIMITS -->
            <h2 class="font-semibold text-gray-700 mt-6 mb-3">🎯 Limits</h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                <input type="number" name="student_limit"
                    value="{{ old('student_limit', $plan->student_limit) }}"
                    class="input" placeholder="Student Limit">

                <input type="number" name="teacher_limit"
                    value="{{ old('teacher_limit', $plan->teacher_limit) }}"
                    class="input" placeholder="Teacher Limit">

                <input type="number" name="parent_limit"
                    value="{{ old('parent_limit', $plan->parent_limit) }}"
                    class="input" placeholder="Parent Limit">

            </div>

            <!-- FEATURES -->
            <h2 class="font-semibold text-gray-700 mt-6 mb-3">⚙️ Features</h2>

            <div class="grid grid-cols-2 md:grid-cols-3 gap-4 text-sm">

                @php
                $features = [
                    'subjects' => 'Subjects',
                    'classes' => 'Classes',
                    'sections' => 'Sections',
                    'attendance' => 'Attendance',
                    'results' => 'Results',
                    'fees' => 'Fees',
                    'accountant' => 'Accountant',
                    'hostel' => 'Hostel',
                    'driver' => 'Driver',
                    'driver_assign' => 'Driver Assign',
                    'vehicles' => 'Vehicles',
                    'routes' => 'Routes',
                    'staff_attendance' => 'Staff Attendance',
                    'leave' => 'Leave',
                    'reports' => 'Reports',
                ];
                @endphp

                @foreach($features as $key => $label)
                    <label class="flex items-center gap-2">

                        <!-- 🔥 hidden for unchecked -->
                        <input type="hidden" name="{{ $key }}" value="0">

                        <!-- checkbox -->
                        <input type="checkbox" name="{{ $key }}" value="1"
                        {{ old($key, $plan->$key) ? 'checked' : '' }}>

                        {{ $label }}
                    </label>
                @endforeach

            </div>

            <!-- Submit -->
            <div class="mt-8 text-right">
                <button type="submit"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg shadow">
                    🔄 Update Plan
                </button>
            </div>

        </form>

    </div>

</div>

<style>
.input {
    width: 100%;
    padding: 10px;
    border-radius: 8px;
    border: 1px solid #ddd;
}
.input:focus {
    outline: none;
    border-color: #6366f1;
}
</style>

@endsection