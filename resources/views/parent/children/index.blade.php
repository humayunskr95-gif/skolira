@extends('layouts.parent')

@section('content')

<div class="p-6">
<h2 class="text-xl font-bold mb-4">👶 My Children</h2>

<table class="w-full bg-white shadow rounded">
<thead>
<tr>
    <th>Name</th>
    <th>Class</th>
</tr>
</thead>

<tbody>
@foreach($children as $child)
<tr>
    <td>{{ $child->name }}</td>
    <td>{{ $child->class->name ?? '-' }}</td>
</tr>
@endforeach
</tbody>
</table>

</div>

@endsection