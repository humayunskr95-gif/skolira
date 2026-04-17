@extends('layouts.school_admin')

@section('content')

<h1 class="text-xl font-bold mb-6">📤 Upload Image</h1>

<form method="POST" action="{{ route('school_admin.gallery.store') }}" enctype="multipart/form-data">
@csrf

<input type="file" name="image" class="mb-3">

<input type="text" name="title" placeholder="Title"
       class="w-full mb-3 p-2 border rounded">

<button class="bg-indigo-600 text-white px-4 py-2 rounded">
    Upload
</button>

</form>

@endsection