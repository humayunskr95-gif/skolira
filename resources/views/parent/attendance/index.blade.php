@extends('layouts.parent')

@section('content')

<div class="p-6">

<h2 class="font-bold mb-4">📅 Attendance - {{ $student->name }}</h2>

<table class="w-full bg-white shadow rounded">
<tr>
    <th>Date</th>
    <th>Status</th>
</tr>

@foreach($attendance as $a)
<tr>
    <td>{{ $a->date }}</td>
    <td>{{ $a->status }}</td>
</tr>
@endforeach

</table>

</div>

@endsection