@extends('layouts.teacher')

@section('content')

<div class="p-6">

    <h2 class="text-xl font-bold mb-4">👨‍🎓 Student Details</h2>

    <div class="bg-white p-6 rounded shadow space-y-3">

        <p><b>Name:</b> {{ $student->name }}</p>
        <p><b>Email:</b> {{ $student->email }}</p>
        <p><b>Mobile:</b> {{ $student->mobile }}</p>
        <p><b>Address:</b> {{ $student->address1 ?? '-' }}</p>

    </div>

</div>

@endsection