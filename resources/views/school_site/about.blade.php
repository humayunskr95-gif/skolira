@extends('school_site.layout')

@section('content')

<div class="max-w-6xl mx-auto py-10 px-6">

    <h2 class="text-3xl font-bold mb-6">🏫 About Us</h2>

    <p class="text-gray-600">
        {{ app('currentSchool')->name }} is located at 
        {{ app('currentSchool')->city }}.
    </p>

</div>

@endsection