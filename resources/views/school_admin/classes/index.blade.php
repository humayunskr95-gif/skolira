@extends('layouts.school_admin')

@section('content')

<div class="p-6">

    <h2 class="text-xl font-bold mb-4">🎓 Class Management</h2>

    <!-- Add -->
    <form method="POST" action="{{ route('school_admin.classes.store') }}" class="flex gap-2 mb-4">
        @csrf
        <input type="text" name="name" placeholder="Class name"
               class="border p-2 rounded w-full">
        <button class="bg-indigo-600 text-white px-4 rounded">Add</button>
    </form>

    <!-- List -->
    <div class="bg-white shadow rounded-xl p-4">
        @foreach($classes as $class)
        <div class="flex justify-between border-b py-2">

            <form method="POST" action="{{ route('school_admin.classes.update',$class->id) }}" class="flex gap-2">
                @csrf @method('PUT')
                <input type="text" name="name" value="{{ $class->name }}"
                       class="border p-1 rounded">
                <button class="text-blue-600">Update</button>
            </form>

            <form method="POST" action="{{ route('school_admin.classes.destroy',$class->id) }}">
                @csrf @method('DELETE')
                <button class="text-red-600">Delete</button>
            </form>

        </div>
        @endforeach
    </div>

</div>

@endsection