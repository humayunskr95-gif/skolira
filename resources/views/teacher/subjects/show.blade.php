@extends('layouts.teacher')

@section('content')

<div class="p-6">

    <h2 class="text-xl font-bold mb-4">📘 Subject Details</h2>

    <div class="bg-white p-4 rounded shadow">

        <p><b>Name:</b> {{ $subject->name }}</p>
        <p><b>Code:</b> {{ $subject->code ?? '-' }}</p>

    </div>

</div>

@endsection