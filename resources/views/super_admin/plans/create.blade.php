@extends('layouts.super_admin')

@section('content')

<div class="p-4 md:p-6 max-w-4xl mx-auto">

    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-xl md:text-2xl font-bold text-gray-800">
            ➕ Create Plan
        </h1>

        <a href="{{ route('super_admin.plans') }}"
           class="bg-gray-200 px-3 py-2 rounded-lg text-sm">
            ← Back
        </a>
    </div>

    <!-- Card -->
    <div class="bg-white p-5 md:p-8 rounded-2xl shadow">

        <!-- Success -->
        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        <!-- Error -->
        @if($errors->any())
            <div class="mb-4 p-3 bg-red-100 text-red-600 rounded">
                @foreach ($errors->all() as $error)
                    <div>• {{ $error }}</div>
                @endforeach
            </div>
        @endif

        <!-- Form -->
        <form method="POST" action="{{ route('super_admin.plans.store') }}">
            @csrf

            <!-- 🔹 Basic Info -->
            <h2 class="font-semibold text-gray-700 mb-3">📦 Plan Info</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <!-- Name -->
                <div>
                    <label class="text-sm text-gray-600">Plan Name</label>
                    <input type="text" name="name"
                        value="{{ old('name') }}"
                        class="input"
                        placeholder="Basic / Pro / Premium">
                </div>

                <!-- Price -->
                <div>
                    <label class="text-sm text-gray-600">Price (₹)</label>
                    <input type="number" name="price"
                        value="{{ old('price') }}"
                        class="input"
                        placeholder="Enter price">
                </div>

                <!-- Duration -->
                <div>
                    <label class="text-sm text-gray-600">Duration (Days)</label>
                    <input type="number" name="duration"
                        value="{{ old('duration') }}"
                        class="input"
                        placeholder="30 / 90 / 365">
                </div>

            </div>

            <!-- 🔹 Limits -->
            <h2 class="font-semibold text-gray-700 mt-6 mb-3">📊 Limits</h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                <!-- Student Limit -->
                <div>
                    <label class="text-sm text-gray-600">Student Limit</label>
                    <input type="number" name="student_limit"
                        value="{{ old('student_limit') }}"
                        class="input"
                        placeholder="100 / 500">
                </div>

                <!-- Teacher Limit -->
                <div>
                    <label class="text-sm text-gray-600">Teacher Limit</label>
                    <input type="number" name="teacher_limit"
                        value="{{ old('teacher_limit') }}"
                        class="input"
                        placeholder="10 / 50">
                </div>

                <!-- Parent Limit -->
                <div>
                    <label class="text-sm text-gray-600">Parent Limit</label>
                    <input type="number" name="parent_limit"
                        value="{{ old('parent_limit') }}"
                        class="input"
                        placeholder="Optional">
                </div>

            </div>

            <!-- 🔹 Feature Control -->
            <h2 class="font-semibold text-gray-700 mt-6 mb-3">⚙️ Features</h2>

<div class="grid grid-cols-2 md:grid-cols-3 gap-4 text-sm">

    {{-- 📚 Academic --}}
    <label><input type="checkbox" name="subjects" value="1"> Subjects</label>
    <label><input type="checkbox" name="classes" value="1"> Classes</label>
    <label><input type="checkbox" name="sections" value="1"> Sections</label>

    {{-- 📊 Academic System --}}
    <label><input type="checkbox" name="attendance" value="1"> Attendance</label>
    <label><input type="checkbox" name="results" value="1"> Results</label>

    {{-- 💰 Finance --}}
    <label><input type="checkbox" name="fees" value="1"> Fees Management</label>
    <label><input type="checkbox" name="accountant" value="1"> Accountant</label>

    {{-- 🏠 Hostel --}}
    <label><input type="checkbox" name="hostel" value="1"> Hostel</label>

    {{-- 🚐 Transport --}}
    <label><input type="checkbox" name="driver" value="1"> Driver</label>
    <label><input type="checkbox" name="driver_assign" value="1"> Driver Assign</label>
    <label><input type="checkbox" name="vehicles" value="1"> Vehicles</label>
    <label><input type="checkbox" name="routes" value="1"> Routes</label>

    {{-- 👨‍🏫 Staff --}}
    <label><input type="checkbox" name="staff_attendance" value="1"> Staff Attendance</label>
    <label><input type="checkbox" name="leave" value="1"> Leave</label>

    {{-- 📈 Reports --}}
    <label><input type="checkbox" name="reports" value="1"> Reports & Analytics</label>

</div>

            <!-- Submit -->
            <div class="mt-6 text-right">
                <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg shadow">
                    💾 Save Plan
                </button>
            </div>

        </form>

    </div>

</div>

<!-- 🔥 Input Style -->
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