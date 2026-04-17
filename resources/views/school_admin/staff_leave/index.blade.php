@extends('layouts.school_admin')

@section('content')

<div class="p-6">

<h2 class="text-2xl font-bold mb-6">📝 Staff Leave Requests</h2>

<table class="w-full bg-white shadow rounded">

    <thead class="bg-gray-100">
        <tr>
            <th class="p-3">Staff</th>
            <th>Reason</th>
            <th>From</th>
            <th>To</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
        @foreach($leaves as $l)
        <tr class="border-t">

            <td class="p-3">{{ $l->staff->name }}</td>
            <td>{{ $l->reason }}</td>
            <td>{{ $l->from_date }}</td>
            <td>{{ $l->to_date }}</td>

            <td>
                @if($l->status == 'pending')
                    <span class="text-yellow-500">Pending</span>
                @elseif($l->status == 'approved')
                    <span class="text-green-600">Approved</span>
                @else
                    <span class="text-red-600">Rejected</span>
                @endif
            </td>

            <td class="flex gap-2">

                @if($l->status == 'pending')
                    <a href="{{ route('school_admin.staff_leave.approve',$l->id) }}"
                       class="bg-green-500 text-white px-2 py-1 rounded">Approve</a>

                    <a href="{{ route('school_admin.staff_leave.reject',$l->id) }}"
                       class="bg-red-500 text-white px-2 py-1 rounded">Reject</a>
                @endif

            </td>

        </tr>
        @endforeach
    </tbody>

</table>

</div>

@endsection