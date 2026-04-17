@extends('layouts.school_admin')

@section('content')

<div class="p-6">

    <h2 class="text-2xl font-bold mb-6">➕ Add Route</h2>

    @if ($errors->any())
        <div class="bg-red-100 p-3 mb-4 rounded">
            @foreach ($errors->all() as $e)
                <p>{{ $e }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('school_admin.transport.route.store') }}"
          class="bg-white p-6 rounded shadow">

        @csrf

        <div class="grid md:grid-cols-3 gap-4">

            <input type="text" name="name" placeholder="Route Name"
                   class="border p-2 rounded" value="{{ old('name') }}">

            <input type="text" name="start_point" placeholder="Start Point"
                   class="border p-2 rounded" value="{{ old('start_point') }}">

            <input type="text" name="end_point" placeholder="End Point"
                   class="border p-2 rounded" value="{{ old('end_point') }}">

        </div>

        <div class="mt-4 flex gap-2">
            <button class="bg-green-500 text-white px-4 py-2 rounded">Save</button>

            <a href="{{ route('school_admin.transport.route.index') }}"
               class="bg-gray-500 text-white px-4 py-2 rounded">Back</a>
        </div>

    </form>

</div>

@endsection