@extends('layouts.school_admin')

@section('content')

<h1 class="text-xl font-bold mb-6">➕ Add Notice</h1>

<form method="POST" action="{{ route('school_admin.notices.store') }}">
@csrf

<input type="text" name="title" placeholder="Title"
       class="w-full mb-3 p-2 border rounded">

<textarea name="description" placeholder="Description"
          class="w-full mb-3 p-2 border rounded"></textarea>

<input type="date" name="date"
       class="w-full mb-3 p-2 border rounded">

<button class="bg-indigo-600 text-white px-4 py-2 rounded">
    Save
</button>

</form>

@endsection