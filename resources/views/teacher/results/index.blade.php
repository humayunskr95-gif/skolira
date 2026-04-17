@extends('layouts.teacher')

@section('content')

<div class="p-4 md:p-6">

    <h2 class="text-xl font-bold mb-6">📊 My Subjects (Result Entry)</h2>

    <div class="grid md:grid-cols-3 gap-4">

        @forelse($subjects as $subject)
        <div class="bg-white shadow rounded-xl p-4 hover:shadow-lg transition">

            <h3 class="font-semibold text-lg mb-2">
                {{ $subject->name }}
            </h3>

            <p class="text-sm text-gray-500 mb-4">
                Class: {{ $subject->class->name ?? '-' }}
            </p>

            <a href="{{ route('teacher.results.create', $subject->id) }}"
               class="block text-center bg-indigo-500 text-white py-2 rounded-lg hover:bg-indigo-600">
               ➕ Enter Marks
            </a>

        </div>
        @empty
        <p>No Subjects Assigned 😔</p>
        @endforelse

    </div>

</div>

@endsection