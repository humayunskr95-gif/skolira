@extends('layouts.super_admin')

@section('content')

<div class="p-4 md:p-6">

    <!-- Header -->
    <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-3 mb-6">
        <h1 class="text-2xl font-bold text-gray-800">💎 Plans Management</h1>

        <a href="{{ route('super_admin.plans.create') }}"
           class="bg-indigo-600 text-white px-4 py-2 rounded-lg shadow hover:bg-indigo-700 text-center">
            + Create Plan
        </a>
    </div>

    <!-- Success -->
    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    <!-- Plans -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">

        @forelse($plans as $plan)

        <div class="bg-white rounded-2xl shadow hover:shadow-xl transition p-6 flex flex-col relative">

            <!-- Highlight -->
            @if($plan->price > 10000)
                <span class="absolute top-3 right-3 bg-indigo-600 text-white text-xs px-2 py-1 rounded">
                    ⭐ Popular
                </span>
            @endif

            <!-- Name -->
            <h2 class="text-xl font-bold text-gray-800 mb-1">
                {{ $plan->name }}
            </h2>

            <!-- Price -->
            <div class="text-3xl font-bold text-indigo-600 mb-1">
                ₹{{ number_format($plan->price) }}
            </div>

            <!-- Duration -->
            <p class="text-gray-500 mb-4">
                {{ $plan->duration }} Days Access
            </p>

            <hr class="mb-4">

            <!-- Limits -->
            <div class="text-sm text-gray-700 space-y-1 mb-4">
                <p>👨‍🎓 Students: <b>{{ $plan->student_limit ?: 'Unlimited' }}</b></p>
                <p>👨‍🏫 Teachers: <b>{{ $plan->teacher_limit ?: 'Unlimited' }}</b></p>
                <p>👪 Parents: <b>{{ $plan->parent_limit ?: 'Unlimited' }}</b></p>
            </div>

            <!-- Features -->
            <ul class="text-sm space-y-1 mb-4">

                {{-- 📚 Academic --}}
                <li>{{ $plan->subjects ? '✔' : '❌' }} Subjects</li>
                <li>{{ $plan->classes ? '✔' : '❌' }} Classes</li>
                <li>{{ $plan->sections ? '✔' : '❌' }} Sections</li>

                {{-- 📊 Study --}}
                <li>{{ $plan->attendance ? '✔' : '❌' }} Attendance</li>
                <li>{{ $plan->results ? '✔' : '❌' }} Results</li>

                {{-- 💰 Finance --}}
                <li>{{ $plan->fees ? '✔' : '❌' }} Fees Management</li>
                <li>{{ $plan->accountant ? '✔' : '❌' }} Accountant</li>

                {{-- 🏨 Hostel --}}
                <li>{{ $plan->hostel ? '✔' : '❌' }} Hostel</li>

                {{-- 🚐 Transport --}}
                <li>{{ $plan->driver ? '✔' : '❌' }} Driver</li>
                <li>{{ $plan->driver_assign ? '✔' : '❌' }} Driver Assign</li>
                <li>{{ $plan->vehicles ? '✔' : '❌' }} Vehicles</li>
                <li>{{ $plan->routes ? '✔' : '❌' }} Routes</li>

                {{-- 👨‍💼 Staff --}}
                <li>{{ $plan->staff_attendance ? '✔' : '❌' }} Staff Attendance</li>
                <li>{{ $plan->leave ? '✔' : '❌' }} Leave</li>

                {{-- 📈 Reports --}}
                <li>{{ $plan->reports ? '✔' : '❌' }} Reports & Analytics</li>

            </ul>

            <!-- Actions -->
            <div class="mt-auto flex justify-between items-center pt-4 border-t">

                <a href="{{ route('super_admin.plans.edit', $plan->id) }}"
                   class="text-blue-600 hover:underline text-sm">
                    ✏️ Edit
                </a>

                <form action="{{ route('super_admin.plans.delete', $plan->id) }}"
                      method="POST"
                      onsubmit="return confirm('Delete this plan?')">
                    @csrf
                    @method('DELETE')

                    <button class="text-red-600 hover:underline text-sm">
                        🗑 Delete
                    </button>
                </form>

            </div>

        </div>

        @empty
        <div class="col-span-3 text-center text-gray-500">
            No plans found 🚫
        </div>
        @endforelse

    </div>

</div>

@endsection