@extends('layouts.transport')

@section('content')

<h2 class="text-xl font-bold mb-4">👨‍🎓 Students List</h2>

<!-- 🔥 SUCCESS MESSAGE -->
@if(session('success'))
    <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

<!-- 🔥 TOP BAR -->
<div class="flex justify-between items-center mb-4">

    <!-- Live Counter -->
    <div class="text-sm text-gray-600">
        Picked: 
        <span class="font-bold text-green-600">
            {{ $students->where('pickup_status',1)->count() }}
        </span>
        /
        {{ $students->count() }}
    </div>

    <!-- Reset Button -->
    <form method="POST" action="{{ route('driver.resetPickup') }}">
        @csrf
        <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs">
            🔄 Reset
        </button>
    </form>

</div>

<!-- 🔥 DESKTOP TABLE -->
<div class="hidden md:block bg-white rounded-xl shadow overflow-hidden">

    <table class="w-full text-sm">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-3 text-left">Name</th>
                <th class="p-3 text-left">Class</th>
                <th class="p-3 text-left">Status</th>
                <th class="p-3 text-left">Action</th>
            </tr>
        </thead>

        <tbody>

        @forelse($students as $student)
            <tr class="border-t hover:bg-gray-50">

                <td class="p-3 font-medium">
                    {{ $student->name }}
                </td>

                <td class="p-3">
                    {{ $student->class ?? '-' }}
                </td>

                <td class="p-3">
                    @if($student->pickup_status)
                        <span class="px-2 py-1 bg-green-100 text-green-700 rounded text-xs">
                            ✅ Picked
                        </span>
                    @else
                        <span class="px-2 py-1 bg-red-100 text-red-700 rounded text-xs">
                            ⏳ Pending
                        </span>
                    @endif
                </td>

                <td class="p-3">

                    <!-- 🔥 TOGGLE BUTTON -->
                    <form method="POST" action="{{ route('driver.pickup', $student->id) }}">
                        @csrf
                        <button class="px-3 py-1 rounded text-xs text-white
                            {{ $student->pickup_status ? 'bg-gray-400' : 'bg-blue-500 hover:bg-blue-600' }}">
                            
                            {{ $student->pickup_status ? 'Undo' : 'Pickup' }}
                        </button>
                    </form>

                </td>

            </tr>
        @empty
            <tr>
                <td colspan="4" class="p-4 text-center text-gray-500">
                    No students found
                </td>
            </tr>
        @endforelse

        </tbody>
    </table>

</div>

<!-- 📱 MOBILE VIEW -->
<div class="md:hidden space-y-3">

@forelse($students as $student)
    <div class="bg-white p-4 rounded-xl shadow">

        <div class="flex justify-between items-center">
            <h3 class="font-semibold">{{ $student->name }}</h3>

            @if($student->pickup_status)
                <span class="text-green-600 text-sm">Picked</span>
            @else
                <span class="text-red-500 text-sm">Pending</span>
            @endif
        </div>

        <p class="text-xs text-gray-500">
            Class: {{ $student->class ?? '-' }}
        </p>

        <form method="POST" action="{{ route('driver.pickup', $student->id) }}">
            @csrf
            <button class="mt-3 w-full py-2 rounded text-white
                {{ $student->pickup_status ? 'bg-gray-400' : 'bg-blue-500' }}">
                
                {{ $student->pickup_status ? 'Undo Pickup' : 'Mark Pickup' }}
            </button>
        </form>

    </div>
@empty
    <p class="text-center text-gray-500">No students found</p>
@endforelse

</div>

@endsection