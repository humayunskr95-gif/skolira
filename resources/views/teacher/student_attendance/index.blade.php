@extends('layouts.teacher')

@section('content')

<div class="p-6">

<h2 class="text-xl font-bold mb-4">📝 Student Attendance</h2>

<form method="POST" action="{{ route('teacher.student.attendance.store') }}">
@csrf

<!-- DATE -->
<div class="mb-4">
    <input type="date" name="date" value="{{ date('Y-m-d') }}"
           class="border p-2 rounded">
</div>

<!-- IMPORTANT HIDDEN FIELDS -->
<input type="hidden" name="class_id" value="1">
<input type="hidden" name="section_id" value="1">

<div class="bg-white shadow rounded overflow-hidden">

<table class="w-full text-sm">
    <thead class="bg-gray-100">
        <tr>
            <th class="p-3">#</th>
            <th class="p-3 text-left">Name</th>
            <th class="p-3">Present</th>
            <th class="p-3">Absent</th>
        </tr>
    </thead>

    <tbody>
        @foreach($students as $s)
        <tr class="border-t text-center hover:bg-gray-50">

            <td class="p-3">{{ $loop->iteration }}</td>

            <td class="p-3 text-left">{{ $s->name }}</td>

            <td>
                <input type="radio" 
                       name="students[{{ $s->id }}]" 
                       value="present" 
                       required>
            </td>

            <td>
                <input type="radio" 
                       name="students[{{ $s->id }}]" 
                       value="absent">
            </td>

        </tr>
        @endforeach
    </tbody>

</table>

</div>

<button class="mt-4 bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
    💾 Save Attendance
</button>

</form>

</div>

@endsection