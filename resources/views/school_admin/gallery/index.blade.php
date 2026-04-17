@extends('layouts.school_admin')

@section('content')

<div class="flex justify-between mb-6">
    <h1 class="text-xl font-bold">📷 Gallery</h1>

    <a href="{{ route('school_admin.gallery.create') }}"
       class="bg-indigo-600 text-white px-4 py-2 rounded">
        + Upload
    </a>
</div>

@if(session('success'))
<div class="bg-green-100 text-green-700 p-3 mb-4 rounded">
    {{ session('success') }}
</div>
@endif

<div class="grid grid-cols-2 md:grid-cols-4 gap-4">

    @foreach($galleries as $img)
    <div class="bg-white p-2 rounded shadow">

        <img src="{{ asset('storage/'.$img->image) }}"
             class="rounded h-40 w-full object-cover">

        <p class="text-sm mt-2">{{ $img->title }}</p>

        <form method="POST" action="{{ route('school_admin.gallery.delete',$img->id) }}">
            @csrf
            @method('DELETE')

            <button class="text-red-600 text-sm mt-1">Delete</button>
        </form>

    </div>
    @endforeach

</div>

@endsection