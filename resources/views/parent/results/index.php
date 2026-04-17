@extends('layouts.parent')

@section('content')

<div class="p-6">

<h2 class="font-bold mb-4">📊 Results - {{ $student->name }}</h2>

<table class="w-full bg-white shadow rounded">

<tr>
    <th>Subject</th>
    <th>Marks</th>
</tr>

@foreach($results as $r)
<tr>
    <td>{{ $r->subject->name }}</td>
    <td>{{ $r->marks }}</td>
</tr>
@endforeach

</table>

</div>

@endsection