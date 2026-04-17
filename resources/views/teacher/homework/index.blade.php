@extends('layouts.teacher')

@section('content')

<div class="p-4 md:p-6">

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-bold">📝 My Homework</h2>

        <a href="{{ route('teacher.homework.create') }}"
           class="bg-indigo-500 text-white px-4 py-2 rounded-lg">
           ➕ Add Homework
        </a>
    </div>

    <div class="grid md:grid-cols-2 gap-4">

        @forelse($homeworks as $hw)
        <div class="bg-white shadow rounded-xl p-4">

            <h3 class="font-semibold text-lg">
                {{ $hw->title }}
            </h3>

            <p class="text-sm text-gray-500 mt-1">
                Subject: {{ $hw->subject->name }}
            </p>

            <p class="text-gray-600 mt-2">
                {{ $hw->description }}
            </p>

            <div class="mt-3 text-sm text-red-500">
                Due: {{ $hw->due_date }}
            </div>

        </div>
        @empty
        <p>No Homework Added 😔</p>
        @endforelse

    </div>

</div>

@endsection