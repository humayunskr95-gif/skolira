@extends('layouts.teacher')

@section('content')

<div class="p-6 space-y-6 bg-gray-100 min-h-screen">

    <!-- HEADER -->
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">
                👨‍🏫 Welcome, {{ auth()->user()->name }}
            </h2>
            <p class="text-sm text-gray-500">
                {{ now()->format('l, d M Y') }}
            </p>
        </div>

        <div class="bg-white px-4 py-2 rounded-lg shadow text-sm">
            🟢 Active
        </div>
    </div>


    <!-- ================= STATS ================= -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">

        <!-- Attendance -->
        <div class="bg-gradient-to-r from-green-400 to-green-600 text-white p-5 rounded-2xl shadow hover:scale-105 transition">
            <p class="text-sm">Today Attendance</p>
            <h3 class="text-xl font-bold mt-1">
                {{ $data['today_attendance']->status ?? 'Not Marked' }}
            </h3>
        </div>

        <!-- Students -->
        <div class="bg-gradient-to-r from-blue-400 to-blue-600 text-white p-5 rounded-2xl shadow hover:scale-105 transition">
            <p class="text-sm">Total Students</p>
            <h3 class="text-xl font-bold mt-1">
                {{ $data['total_students'] }}
            </h3>
        </div>

        <!-- Subjects -->
        <div class="bg-gradient-to-r from-purple-400 to-purple-600 text-white p-5 rounded-2xl shadow hover:scale-105 transition">
            <p class="text-sm">My Subjects</p>
            <h3 class="text-xl font-bold mt-1">
                {{ $data['total_subjects'] }}
            </h3>
        </div>

        <!-- Leaves -->
        <div class="bg-gradient-to-r from-red-400 to-red-600 text-white p-5 rounded-2xl shadow hover:scale-105 transition">
            <p class="text-sm">My Leaves</p>
            <h3 class="text-xl font-bold mt-1">
                {{ $data['total_leaves'] }}
            </h3>
        </div>

    </div>


    <!-- ================= MAIN GRID ================= -->
    <div class="grid md:grid-cols-3 gap-6">

        <!-- QUICK ACTIONS -->
        <div class="bg-white p-5 rounded-2xl shadow md:col-span-2">
            <h3 class="font-semibold mb-4 text-lg">⚡ Quick Actions</h3>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">

                <a href="{{ route('teacher.subjects') }}"
                   class="flex flex-col items-center bg-indigo-500 text-white p-4 rounded-xl hover:bg-indigo-600 transition">
                   📚
                   <span class="text-sm mt-2">Subjects</span>
                </a>

                <a href="{{ route('teacher.students') }}"
                   class="flex flex-col items-center bg-green-500 text-white p-4 rounded-xl hover:bg-green-600 transition">
                   👨‍🎓
                   <span class="text-sm mt-2">Students</span>
                </a>

                <a href="{{ route('teacher.attendance') }}"
                   class="flex flex-col items-center bg-yellow-500 text-white p-4 rounded-xl hover:bg-yellow-600 transition">
                   📝
                   <span class="text-sm mt-2">Attendance</span>
                </a>

                <a href="{{ route('teacher.leave') }}"
                   class="flex flex-col items-center bg-red-500 text-white p-4 rounded-xl hover:bg-red-600 transition">
                   📅
                   <span class="text-sm mt-2">Leave</span>
                </a>

            </div>
        </div>


        <!-- PROFILE CARD -->
        <div class="bg-white p-5 rounded-2xl shadow text-center">
            <div class="text-5xl mb-3">👨‍🏫</div>
            <h4 class="font-bold">{{ auth()->user()->name }}</h4>
            <p class="text-sm text-gray-500">Teacher</p>

            <div class="mt-4">
                <a href="#"
                   class="bg-indigo-500 text-white px-4 py-2 rounded-lg text-sm hover:bg-indigo-600">
                   View Profile
                </a>
            </div>
        </div>

    </div>


    <!-- ================= ACTIVITY ================= -->
    <div class="grid md:grid-cols-2 gap-6">

        <!-- Recent Activity -->
        <div class="bg-white p-5 rounded-2xl shadow">
            <h4 class="font-semibold mb-3">📊 Recent Activity</h4>

            <ul class="space-y-2 text-sm text-gray-600">
                <li>✔ Attendance marked today</li>
                <li>✔ Subject updated</li>
                <li>✔ Leave request submitted</li>
            </ul>
        </div>

        <!-- Notice -->
        <div class="bg-indigo-600 text-white p-5 rounded-2xl shadow">
            <h4 class="font-semibold mb-2">📢 Notice</h4>
            <p class="text-sm">
                Stay updated with your classes and maintain daily attendance.
            </p>
        </div>

    </div>

</div>

@endsection