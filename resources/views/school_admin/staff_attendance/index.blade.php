@extends('layouts.school_admin')

@section('content')

<div class="p-6">

<h2 class="text-2xl font-bold mb-6">📊 Staff Attendance</h2>

<!-- 🔍 FILTER -->
<form method="GET" class="flex gap-3 mb-4">

    <input type="date" name="date" value="{{ request('date') }}"
           class="border px-3 py-2 rounded">

    <select name="staff_id" class="border px-3 py-2 rounded">
        <option value="">All Staff</option>
        @foreach($staffs as $s)
            <option value="{{ $s->id }}"
                {{ request('staff_id')==$s->id ? 'selected':'' }}>
                {{ $s->name }}
            </option>
        @endforeach
    </select>

    <button class="bg-gray-800 text-white px-4 py-2 rounded">
        Filter
    </button>

</form>

<!-- 📊 TABLE -->
<table class="w-full bg-white shadow rounded text-sm">

<thead class="bg-gray-100">
<tr>
    <th class="p-3">Staff</th>
    <th>Date</th>
    <th>Status</th>
    <th>Check In</th>
    <th>Check Out</th>
</tr>
</thead>

<tbody>

@forelse($attendances as $a)
<tr class="border-t">

    <td class="p-3">{{ $a->staff->name }}</td>

    <td>{{ $a->date->format('d M Y') }}</td>

    <td>
        @if($a->status == 'present')
            <span class="text-green-600">Present</span>
        @elseif($a->status == 'late')
            <span class="text-yellow-600">Late</span>
        @else
            <span class="text-red-600">Absent</span>
        @endif
    </td>

    <td>{{ $a->check_in ?? '-' }}</td>
    <td>{{ $a->check_out ?? '-' }}</td>

</tr>
@empty
<tr>
<td colspan="5" class="text-center p-4">No Data</td>
</tr>
@endforelse

</tbody>

</table>

<!-- Pagination -->
<div class="mt-4">
    {{ $attendances->links() }}
</div>

</div>

@endsection