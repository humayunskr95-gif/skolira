@extends('layouts.super_admin')

@section('content')

<div class="p-4 md:p-6 max-w-7xl mx-auto">

    <!-- 🔥 Header -->
    <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-6 gap-3">
        <h1 class="text-2xl font-bold text-gray-800">
            🏫 Schools Management
        </h1>

        <a href="{{ route('super_admin.schools.create') }}"
           class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg shadow text-center">
            ➕ Add School
        </a>
    </div>

    <!-- Success -->
    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <!-- 🔥 Table Card -->
    <div class="bg-white shadow-xl rounded-2xl overflow-hidden">

        <div class="overflow-x-auto">

            <table class="w-full text-sm min-w-[750px]">

                <!-- Header -->
                <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                    <tr>
                        <th class="p-3">#</th>
                        <th class="p-3 text-left">School</th>
                        <th class="p-3 text-left">Location</th>
                        <th class="p-3 text-center">Code</th>
                        <th class="p-3 text-center">Status</th>
                        <th class="p-3 text-center">Created</th>
                        <th class="p-3 text-center">Action</th>
                    </tr>
                </thead>

                <!-- Body -->
                <tbody class="divide-y">

                    @forelse($schools as $key => $school)
                    <tr class="hover:bg-gray-50 transition">

                        <!-- ID -->
                        <td class="p-3">{{ $key + 1 }}</td>

                        <!-- School -->
                        <td class="p-3">
                            <div class="flex items-center gap-3">

                                @if($school->logo)
                                    <img src="{{ asset('storage/'.$school->logo) }}"
                                         class="w-10 h-10 rounded-full object-cover">
                                @else
                                    <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center">
                                        🏫
                                    </div>
                                @endif

                                <div>
                                    <div class="font-semibold text-gray-800">
                                        {{ $school->name }}
                                    </div>
                                    <div class="text-xs text-gray-400">
                                        {{ $school->owner_name ?? 'Owner N/A' }}
                                    </div>
                                </div>

                            </div>
                        </td>

                        <!-- Location -->
                        <td class="p-3 text-gray-500 text-sm">
                            {{ $school->city ?? '' }}
                            {{ $school->city && $school->district ? ',' : '' }}
                            {{ $school->district ?? '' }}
                        </td>

                        <!-- School Code -->
                        <td class="p-3 text-center text-xs font-semibold text-indigo-600">
                            {{ $school->code ?? 'N/A' }}
                        </td>

                        <!-- Subscription Status -->
                        <td class="p-3 text-center">

                            @php
                                $sub = \App\Models\Subscription::where('school_id', $school->id)
                                        ->latest()
                                        ->first();
                            @endphp

                            @if($school->is_active == false)
                                <span class="px-2 py-1 bg-gray-200 text-gray-600 rounded text-xs">
                                    Suspended
                                </span>

                            @elseif($sub && $sub->status == 'active' && $sub->end_date >= now())
                                <span class="px-2 py-1 bg-green-100 text-green-700 rounded text-xs">
                                    Active
                                </span>
                            @else
                                <span class="px-2 py-1 bg-red-100 text-red-600 rounded text-xs">
                                    Expired
                                </span>
                            @endif

                        </td>

                        <!-- Date -->
                        <td class="p-3 text-gray-400 text-center text-xs">
                            {{ $school->created_at->format('d M Y') }}
                        </td>

                        <!-- 🔥 ACTION DROPDOWN -->
                        <td class="p-3 text-center">

                            <div x-data="{ open: false }" class="relative inline-block">

                                <!-- Gear -->
                                <button @click="open = !open"
                                        class="p-2 bg-gray-100 hover:bg-gray-200 rounded-full">
                                    ⚙️
                                </button>

                                <!-- Dropdown -->
                                <div x-show="open"
                                     @click.outside="open = false"
                                     x-transition
                                     class="absolute right-0 mt-2 w-44 bg-white rounded-xl shadow-lg border z-50">

                                    <a href="{{ route('super_admin.schools.view', $school->id) }}"
                                       class="block px-4 py-2 text-sm hover:bg-gray-100 text-green-600">
                                        👁 View
                                    </a>

                                    <a href="{{ route('super_admin.schools.edit', $school->id) }}"
                                       class="block px-4 py-2 text-sm hover:bg-gray-100 text-blue-600">
                                        ✏️ Edit
                                    </a>

                                    <a href="{{ route('super_admin.schools.subscribe', $school->id) }}"
                                       class="block px-4 py-2 text-sm hover:bg-gray-100 text-indigo-600">
                                        💳 Plan
                                    </a>

                                    <!-- Toggle -->
                                    <form method="POST"
                                          action="{{ route('super_admin.schools.toggle', $school->id) }}">
                                        @csrf
                                        <button class="w-full text-left px-4 py-2 text-sm hover:bg-gray-100 text-yellow-600">
                                            {{ $school->is_active ? '⛔ Suspend' : '✅ Activate' }}
                                        </button>
                                    </form>

                                    <!-- Delete -->
                                    <form method="POST"
                                          action="{{ route('super_admin.schools.delete', $school->id) }}"
                                          onsubmit="return confirm('Delete this school?')">
                                        @csrf
                                        @method('DELETE')

                                        <button class="w-full text-left px-4 py-2 text-sm hover:bg-red-100 text-red-600">
                                            🗑 Delete
                                        </button>
                                    </form>

                                </div>

                            </div>

                        </td>

                    </tr>

                    @empty
                    <tr>
                        <td colspan="7" class="text-center p-6 text-gray-500">
                            No schools found 🚫
                        </td>
                    </tr>
                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection