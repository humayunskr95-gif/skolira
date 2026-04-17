@extends('layouts.school_admin')

@section('content')

<div class="p-6">

    <h2 class="text-xl font-semibold mb-4">
        👁 Accountant Details
    </h2>

    <div class="bg-white shadow rounded p-6 grid md:grid-cols-3 gap-6">

        <!-- Profile -->
        <div class="text-center">
            @if($accountant->photo)
                <img src="{{ asset('storage/'.$accountant->photo) }}"
                     class="w-24 h-24 rounded-full mx-auto object-cover">
            @else
                <div class="w-24 h-24 rounded-full bg-gray-300 mx-auto flex items-center justify-center text-xl">
                    {{ strtoupper(substr($accountant->name,0,1)) }}
                </div>
            @endif

            <h4 class="mt-3 font-semibold">{{ $accountant->name }}</h4>
            <p class="text-sm text-gray-500">{{ $accountant->account_code }}</p>
        </div>

        <!-- Details -->
        <div class="md:col-span-2 grid grid-cols-2 gap-4 text-sm">

            <div><b>Father:</b> {{ $accountant->father_name ?? '-' }}</div>
            <div><b>Mobile:</b> {{ $accountant->mobile }}</div>
            <div><b>Email:</b> {{ $accountant->email }}</div>
            <div><b>DOB:</b> {{ $accountant->dob ?? '-' }}</div>
            <div><b>Gender:</b> {{ ucfirst($accountant->gender) ?? '-' }}</div>
            <div><b>City:</b> {{ $accountant->city ?? '-' }}</div>
            <div><b>District:</b> {{ $accountant->district ?? '-' }}</div>
            <div><b>State:</b> {{ $accountant->state ?? '-' }}</div>
            <div><b>PIN:</b> {{ $accountant->pin ?? '-' }}</div>

        </div>

    </div>

    <div class="mt-4">
        <a href="{{ route('school_admin.accountants.index') }}"
           class="bg-gray-500 text-white px-4 py-2 rounded">
            ⬅ Back
        </a>
    </div>

</div>

@endsection