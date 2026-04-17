@extends('layouts.student')

@section('content')

<div class="p-4 md:p-6">

<h2 class="text-xl font-bold mb-4">📊 My Results</h2>

<div class="bg-white shadow rounded-lg overflow-hidden">

<table class="w-full text-sm">
    <thead class="bg-gray-100">
        <tr>
            <th class="p-3">Subject</th>
            <th class="p-3">Marks</th>
            <th class="p-3">Grade</th>
        </tr>
    </thead>

    <tbody>
        @forelse($results as $r)
        <tr class="border-t text-center">
            <td>{{ $r->subject->name ?? '-' }}</td>
            <td>{{ $r->marks }}</td>
            <td>{{ $r->grade }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="3" class="p-4 text-center text-gray-500">
                No Results Found 😔
            </td>
        </tr>
        @endforelse
    </tbody>
</table>

</div>

</div>

@endsection