@extends('layouts.school_admin')

@section('content')

<div class="p-6">

<h2 class="text-xl font-bold mb-4">👥 Role Management</h2>

<form method="POST" action="{{ route('school_admin.roles.store') }}" class="flex gap-2 mb-4">
    @csrf
    <input name="name" class="border p-2 rounded w-full" placeholder="Role name">
    <button class="bg-indigo-600 text-white px-4">Add</button>
</form>

@foreach($roles as $role)
<div class="flex justify-between border-b py-2">
    <span>{{ $role->name }}</span>
    <form method="POST" action="{{ route('school_admin.roles.delete',$role->id) }}">
        @csrf @method('DELETE')
        <button class="text-red-600">Delete</button>
    </form>
</div>
@endforeach

</div>

@endsection