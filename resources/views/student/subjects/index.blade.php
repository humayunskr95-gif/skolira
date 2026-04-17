@extends('layouts.student')

@section('content')

<div class="p-4 md:p-6">

<h2 class="text-xl font-bold mb-4">📚 My Subjects</h2>

<div class="grid md:grid-cols-3 gap-4">

@forelse($subjects as $subject)

<div class="bg-white p-4 rounded-xl shadow">
    <h3 class="font-bold text-lg">{{ $subject->name }}</h3>
    <p class="text-sm text-gray-500">
        Class: {{ $subject->class->name ?? '-' }}
    </p>
</div>

@empty
<p>No Subjects Found 😔</p>
@endforelse

</div>

</div>

@endsection