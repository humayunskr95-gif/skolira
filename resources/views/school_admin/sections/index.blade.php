@extends('layouts.school_admin')

@section('content')

<div class="p-6">

    <h2 class="text-xl font-bold mb-4">📚 Section Management</h2>

    <!-- Add -->
    <form method="POST" action="{{ route('school_admin.sections.store') }}" class="flex gap-2 mb-4">
        @csrf

        <select name="school_class_id" class="border p-2 rounded">
            @foreach($classes as $class)
                <option value="{{ $class->id }}">{{ $class->name }}</option>
            @endforeach
        </select>

        <input type="text" name="name" placeholder="Section (A,B,C)"
               class="border p-2 rounded">

        <button class="bg-indigo-600 text-white px-4 rounded">Add</button>
    </form>

    <!-- List -->
    <div class="bg-white shadow rounded-xl p-4">

        @foreach($sections as $sec)
        <div class="flex justify-between border-b py-2">

            <div>
                {{ $sec->class->name }} - {{ $sec->name }}
            </div>

            <form method="POST" action="{{ route('school_admin.sections.destroy',$sec->id) }}">
                @csrf @method('DELETE')
                <button class="text-red-600">Delete</button>
            </form>

        </div>
        @endforeach

    </div>

</div>

@endsection