@extends('layouts.school_admin')

@section('content')

<div class="p-6">

    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">👨‍🎓 Student Details</h1>

        <a href="{{ route('school_admin.students.index') }}"
           class="bg-gray-200 px-4 py-2 rounded-lg">
            ← Back
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow p-6 grid md:grid-cols-3 gap-6">

        <!-- 🔥 LEFT: PHOTO -->
        <div class="text-center">

            @if($student->user && $student->user->photo)
    <img src=<img src="{{ asset('storage/'.$student->photo) }}"
         class="w-40 h-40 rounded-full mx-auto object-cover border shadow">
@else
    <div class="w-40 h-40 rounded-full bg-gray-200 mx-auto flex items-center justify-center">
        👤
    </div>
@endif

            <h2 class="mt-4 font-bold text-lg">
                {{ $student->name }}
            </h2>

            <p class="text-sm text-gray-500">
                {{ $student->student_id }}
            </p>

            <span class="inline-block mt-2 px-3 py-1 text-xs rounded
                {{ $student->is_active ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }}">
                {{ $student->is_active ? 'Active' : 'Blocked' }}
            </span>

        </div>

        <!-- 🔥 STUDENT DETAILS -->
        <div class="md:col-span-2 grid grid-cols-2 gap-4 text-sm">

            <div><b>Student ID:</b> {{ $student->student_id }}</div>
            <div><b>Mobile:</b> {{ $student->mobile }}</div>

            <div><b>Father Name:</b> {{ $student->father_name }}</div>
            <div><b>Mother Name:</b> {{ $student->mother_name }}</div>

            <div><b>Gender:</b> {{ $student->gender }}</div>
            <div><b>DOB:</b> {{ $student->dob }}</div>

            <div><b>Class:</b> {{ $student->studentClass->name ?? '-' }}</div>
            <div><b>Section:</b> ({{ $student->studentSection->name ?? '-' }})</div>

            <div><b>Address 1:</b> {{ $student->address1 }}</div>
            <div><b>Address 2:</b> {{ $student->address2 }}</div>

            <div><b>State:</b> {{ $student->state }}</div>
            <div><b>District:</b> {{ $student->district }}</div>

            <div><b>Block:</b> {{ $student->block }}</div>
            <div><b>City:</b> {{ $student->city }}</div>

            <div><b>PIN:</b> {{ $student->pin }}</div>

        </div>

    </div>

    <!-- 🔥 PARENT DETAILS -->
    <div class="bg-white mt-6 rounded-2xl shadow p-6">

        <h2 class="text-lg font-bold mb-4">👨‍👩‍👧 Parent Details</h2>

        @if($parent)
        <div class="grid grid-cols-2 gap-4 text-sm">

            <div><b>Parent Name:</b> {{ $parent->name }}</div>
            <div><b>Mobile:</b> {{ $parent->mobile }}</div>

            <div><b>Email:</b> {{ $parent->email }}</div>
            <div><b>Role:</b> {{ $parent->role }}</div>

            <div><b>Status:</b>
                <span class="px-2 py-1 text-xs rounded
                    {{ $parent->is_active ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }}">
                    {{ $parent->is_active ? 'Active' : 'Blocked' }}
                </span>
            </div>

        </div>
        @else
            <p class="text-gray-500">No parent found</p>
        @endif

    </div>

</div>

@endsection