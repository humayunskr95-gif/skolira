@extends('layouts.student')

@section('content')

<div class="p-4 md:p-6">

<h2 class="text-xl font-bold mb-4">📝 My Attendance</h2>

<div class="bg-white shadow rounded-lg overflow-hidden">

<table class="w-full text-sm">
    <thead class="bg-gray-100">
        <tr>
            <th class="p-3">Date</th>
            <th class="p-3">Status</th>
        </tr>
    </thead>

    <tbody>
        @forelse($attendances as $a)
        <tr class="border-t text-center">
            <td>{{ $a->date }}</td>

            <td>
                <span class="px-2 py-1 rounded text-white text-xs
                    {{ $a->status == 'present' ? 'bg-green-500' : 'bg-red-500' }}">
                    {{ ucfirst($a->status) }}
                </span>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="2" class="p-4 text-center text-gray-500">
                No Attendance Found 😔
            </td>
        </tr>
        @endforelse
    </tbody>
</table>

</div>

<div class="mt-4">
    {{ $attendances->links() }}
</div>

</div>

@endsection