@extends('school_site.layout')

@section('content')

<div class="text-center py-10">

    <h2 class="text-3xl font-bold mb-4">📞 Contact</h2>

    <p>{{ app('currentSchool')->address1 }}</p>
    <p>{{ app('currentSchool')->city }}</p>

</div>

@endsection