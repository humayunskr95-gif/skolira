@extends('layouts.school_admin')

@section('content')

<div class="p-6">

    <h2 class="text-2xl font-bold mb-6">✏️ Edit Route</h2>

    <form method="POST"
          action="{{ route('school_admin.transport.route.update',$route->id) }}"
          class="bg-white p-6 rounded shadow">

        @csrf
        @method('PUT')

        <div class="grid md:grid-cols-3 gap-4">

            <input type="text" name="name"
                   value="{{ old('name',$route->name) }}"
                   class="border p-2 rounded">

            <input type="text" name="start_point"
                   value="{{ old('start_point',$route->start_point) }}"
                   class="border p-2 rounded">

            <input type="text" name="end_point"
                   value="{{ old('end_point',$route->end_point) }}"
                   class="border p-2 rounded">

        </div>

        <div class="mt-4 flex gap-2">
            <button class="bg-green-500 text-white px-4 py-2 rounded">Update</button>

            <a href="{{ route('school_admin.transport.route.index') }}"
               class="bg-gray-500 text-white px-4 py-2 rounded">Back</a>
        </div>

    </form>

</div>

@endsection