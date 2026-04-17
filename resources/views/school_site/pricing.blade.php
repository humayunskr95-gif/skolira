@extends('school_site.layout')

@section('content')

<div class="max-w-7xl mx-auto py-16 px-4 md:px-6">

    <!-- Title -->
    <h1 class="text-3xl md:text-4xl font-bold text-center mb-3">
        💎 Choose Your Plan
    </h1>

    <p class="text-center text-gray-500 mb-10">
        Upgrade your school & unlock premium features 🚀
    </p>

    <!-- Plans -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">

        @foreach($plans as $plan)

        <div class="bg-white p-6 rounded-2xl shadow hover:shadow-xl transition transform hover:-translate-y-1 flex flex-col">

            <!-- Plan Name -->
            <h2 class="text-xl font-bold text-gray-800">
                {{ $plan->name }}
            </h2>

            <!-- Price -->
            <div class="text-4xl font-bold text-indigo-600 my-3">
                ₹{{ $plan->price }}
            </div>

            <!-- Duration -->
            <p class="text-gray-500 mb-4">
                {{ $plan->duration }} Days
            </p>

            <hr class="mb-4">

            <!-- Limits -->
            <div class="text-sm text-gray-700 space-y-1 mb-4">
                <p>👨‍🎓 Students: <b>{{ $plan->student_limit ?: 'Unlimited' }}</b></p>
                <p>👨‍🏫 Teachers: <b>{{ $plan->teacher_limit ?: 'Unlimited' }}</b></p>
                <p>👪 Parents: <b>{{ $plan->parent_limit ?: 'Unlimited' }}</b></p>
            </div>

            <!-- Features -->
            <ul class="text-sm text-gray-600 space-y-2 mb-6">

                <li>{{ $plan->subjects ? '✔' : '❌' }} Subjects</li>
                <li>{{ $plan->classes ? '✔' : '❌' }} Classes</li>
                <li>{{ $plan->sections ? '✔' : '❌' }} Sections</li>

                <li>{{ $plan->attendance ? '✔' : '❌' }} Attendance</li>
                <li>{{ $plan->results ? '✔' : '❌' }} Results</li>

                <li>{{ $plan->fees ? '✔' : '❌' }} Fees Management</li>
                <li>{{ $plan->accountant ? '✔' : '❌' }} Accountant</li>

                <li>{{ $plan->hostel ? '✔' : '❌' }} Hostel</li>

                <li>{{ $plan->driver ? '✔' : '❌' }} Driver</li>
                <li>{{ $plan->driver_assign ? '✔' : '❌' }} Driver Assign</li>
                <li>{{ $plan->vehicles ? '✔' : '❌' }} Vehicles</li>
                <li>{{ $plan->routes ? '✔' : '❌' }} Routes</li>

                <li>{{ $plan->staff_attendance ? '✔' : '❌' }} Staff Attendance</li>
                <li>{{ $plan->leave ? '✔' : '❌' }} Leave</li>

                <li>{{ $plan->reports ? '✔' : '❌' }} Reports</li>

            </ul>

            <!-- Button -->
            <form method="POST" action="{{ route('payment.pay',$plan->id) }}">
                @csrf

                <button class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-2 rounded-lg shadow">
                    💳 Buy Now
                </button>
            </form>

        </div>

        @endforeach

    </div>

</div>

@endsection