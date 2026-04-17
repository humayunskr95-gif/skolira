@extends('layouts.school_admin')

@section('content')

<div class="p-4 md:p-6">

    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">📊 Dashboard Overview</h1>

        <!-- Date -->
        <div class="text-sm text-gray-500">
            {{ date('d M Y') }}
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 mb-6">

        <!-- Students -->
        <div class="bg-white p-5 rounded-2xl shadow hover:shadow-lg transition">
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="text-gray-500 text-sm">Students</h3>
                    <p class="text-3xl font-bold text-indigo-600">{{ $students }}</p>
                </div>
                <div class="text-3xl">👨‍🎓</div>
            </div>

            <!-- Progress -->
            @if(auth()->user()->school->student_limit)
            <div class="mt-4">
                <div class="text-xs text-gray-400 mb-1">
                    Limit: {{ $students }} / {{ auth()->user()->school->student_limit }}
                </div>
                <div class="w-full bg-gray-200 h-2 rounded">
                    <div class="bg-indigo-600 h-2 rounded"
                         style="width: {{ ($students / auth()->user()->school->student_limit)*100 }}%">
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Teachers -->
        <div class="bg-white p-5 rounded-2xl shadow hover:shadow-lg transition">
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="text-gray-500 text-sm">Teachers</h3>
                    <p class="text-3xl font-bold text-green-600">{{ $teachers }}</p>
                </div>
                <div class="text-3xl">👨‍🏫</div>
            </div>

            @if(auth()->user()->school->teacher_limit)
            <div class="mt-4">
                <div class="text-xs text-gray-400 mb-1">
                    Limit: {{ $teachers }} / {{ auth()->user()->school->teacher_limit }}
                </div>
                <div class="w-full bg-gray-200 h-2 rounded">
                    <div class="bg-green-600 h-2 rounded"
                         style="width: {{ ($teachers / auth()->user()->school->teacher_limit)*100 }}%">
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Parents -->
        <div class="bg-white p-5 rounded-2xl shadow hover:shadow-lg transition">
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="text-gray-500 text-sm">Parents</h3>
                    <p class="text-3xl font-bold text-pink-600">{{ $parents }}</p>
                </div>
                <div class="text-3xl">👪</div>
            </div>
        </div>

    </div>

    <!-- Quick Actions -->
    <div class="bg-white p-6 rounded-2xl shadow mb-6">
        <h2 class="font-semibold text-gray-700 mb-4">⚡ Quick Actions</h2>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">

            <a href="#" class="bg-indigo-50 p-4 rounded-lg text-center hover:bg-indigo-100">
                ➕ Add Student
            </a>

            <a href="#" class="bg-green-50 p-4 rounded-lg text-center hover:bg-green-100">
                ➕ Add Teacher
            </a>

            <a href="#" class="bg-yellow-50 p-4 rounded-lg text-center hover:bg-yellow-100">
                💰 Collect Fees
            </a>

            <a href="#" class="bg-pink-50 p-4 rounded-lg text-center hover:bg-pink-100">
                📊 Reports
            </a>

        </div>
    </div>

    <!-- Info Box -->
    <div class="bg-indigo-50 border border-indigo-200 p-4 rounded-xl text-sm text-indigo-700">
        🚀 Welcome to your school dashboard! Manage students, teachers and track usage easily.
    </div>

</div>

@endsection