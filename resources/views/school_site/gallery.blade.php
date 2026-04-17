@extends('school_site.layout')

@section('content')

<h2 class="text-3xl text-center font-bold my-8">📷 Gallery</h2>

<div class="grid grid-cols-2 md:grid-cols-4 gap-4 max-w-6xl mx-auto">

@foreach(app('currentSchool')->galleries ?? [] as $img)
    <img src="{{ asset('storage/'.$img->image) }}"
         class="rounded shadow">
@endforeach

</div>

@endsection