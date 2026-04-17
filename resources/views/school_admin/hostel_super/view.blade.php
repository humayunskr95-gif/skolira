@extends('layouts.school_admin')

@section('content')

<div class="p-6">

    <!-- Header -->
    <h2 class="text-xl font-semibold mb-6">
        👁 Hostel Super Profile
    </h2>

    <div class="bg-white shadow rounded p-6 grid md:grid-cols-3 gap-6">

        <!-- 👤 Profile -->
        <div class="text-center border-r pr-4">

            @if($user->photo)
                <img src="{{ asset('storage/'.$user->photo) }}"
                     class="w-28 h-28 rounded-full mx-auto object-cover">
            @else
                <div class="w-28 h-28 rounded-full bg-gray-300 mx-auto flex items-center justify-center text-2xl">
                    {{ strtoupper(substr($user->name,0,1)) }}
                </div>
            @endif

            <h4 class="mt-3 font-semibold text-lg">
                {{ $user->name }}
            </h4>

            <p class="text-sm text-gray-500">
                {{ $user->hostel_super_code }}
            </p>

            <!-- Status -->
            <div class="mt-2">
                <span class="px-3 py-1 text-xs rounded
                {{ $user->status ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }}">
                    {{ $user->status ? 'Active' : 'Blocked' }}
                </span>
            </div>

        </div>

        <!-- 📋 Details -->
        <div class="md:col-span-2 grid grid-cols-2 gap-4 text-sm">

            <!-- Personal -->
            <div><b>Father Name:</b> {{ $user->father_name ?? '-' }}</div>
            <div><b>DOB:</b> {{ $user->dob ?? '-' }}</div>

            <div><b>Gender:</b> {{ ucfirst($user->gender) ?? '-' }}</div>
            <div><b>Mobile:</b> {{ $user->mobile }}</div>

            <div><b>Email:</b> {{ $user->email }}</div>
            <div><b>PIN:</b> {{ $user->pin ?? '-' }}</div>

            <!-- Address -->
            <div><b>Address 1:</b> {{ $user->address1 ?? '-' }}</div>
            <div><b>Address 2:</b> {{ $user->address2 ?? '-' }}</div>

            <div><b>City:</b> {{ $user->city ?? '-' }}</div>
            <div><b>Block:</b> {{ $user->block ?? '-' }}</div>

            <div><b>District:</b> {{ $user->district ?? '-' }}</div>
            <div><b>State:</b> {{ $user->state ?? '-' }}</div>

            <!-- System -->
            <div><b>School ID:</b> {{ $user->school_id }}</div>
            <div><b>Role:</b> Hostel Super</div>

            <div><b>Created At:</b> {{ $user->created_at->format('d M Y') }}</div>

        </div>

    </div>

    <!-- Buttons -->
    <div class="mt-6 flex gap-3">

        <a href="{{ route('school_admin.hostel_super.edit',$user->id) }}"
           class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">
            ✏️ Edit
        </a>

        <a href="{{ route('school_admin.hostel_super.index') }}"
           class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
            ⬅ Back
        </a>

    </div>

</div>

@endsection