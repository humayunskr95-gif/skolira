@extends('layouts.school_admin')

@section('content')

<div class="p-6">

    <h2 class="text-xl font-semibold mb-4">
        ✏️ Edit Driver Assignment
    </h2>

    <form method="POST"
          action="{{ route('school_admin.transport.assign.update',$assignment->id) }}"
          class="bg-white p-6 rounded shadow">

        @csrf
        @method('PUT')

        <div class="grid md:grid-cols-3 gap-4">

            <!-- Driver -->
            <div>
                <label>Driver</label>
                <select name="driver_id" class="input">
                    @foreach($drivers as $d)
                        <option value="{{ $d->id }}"
                            {{ $assignment->driver_id == $d->id ? 'selected' : '' }}>
                            {{ $d->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Vehicle -->
            <div>
                <label>Vehicle</label>
                <select name="vehicle_id" class="input">
                    @foreach($vehicles as $v)
                        <option value="{{ $v->id }}"
                            {{ $assignment->vehicle_id == $v->id ? 'selected' : '' }}>
                            {{ $v->vehicle_no }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Route -->
            <div>
                <label>Route</label>
                <select name="route_id" class="input">
                    @foreach($routes as $r)
                        <option value="{{ $r->id }}"
                            {{ $assignment->route_id == $r->id ? 'selected' : '' }}>
                            {{ $r->name }}
                        </option>
                    @endforeach
                </select>
            </div>

        </div>

        <div class="mt-6 flex gap-3">

            <button class="bg-green-500 text-white px-4 py-2 rounded">
                🔄 Update
            </button>

            <a href="{{ route('school_admin.transport.assign.index') }}"
               class="bg-gray-500 text-white px-4 py-2 rounded">
               ⬅ Back
            </a>

        </div>

    </form>

</div>

<style>
.input{
    width:100%;
    padding:10px;
    border:1px solid #ddd;
    border-radius:8px;
}
</style>

@endsection