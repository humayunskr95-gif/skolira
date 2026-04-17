@extends('layouts.school_admin')

@section('content')

<h1 class="text-xl font-bold mb-6">🎓 Admission Requests</h1>

<table class="w-full bg-white shadow rounded">
    <thead class="bg-gray-100">
        <tr>
            <th class="p-3">Name</th>
            <th class="p-3">Class</th>
            <th class="p-3">Status</th>
            <th class="p-3">Action</th>
        </tr>
    </thead>

    <tbody>
        @foreach($admissions as $a)
        <tr class="border-t">
            <td class="p-3">{{ $a->name }}</td>
            <td class="p-3">{{ $a->class }}</td>

            <td class="p-3">
                {{ $a->status }}
            </td>

            <td class="p-3 space-x-2">
                <a href="{{ route('school_admin.admissions.approve',$a->id) }}"
                   class="text-green-600">Approve</a>

                <a href="{{ route('school_admin.admissions.reject',$a->id) }}"
                   class="text-red-600">Reject</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection