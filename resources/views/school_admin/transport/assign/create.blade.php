@extends('layouts.school_admin')

@section('content')

<div class="p-6">

    <!-- Header -->
    <h2 class="text-xl font-semibold mb-6">
        🚐 Assign Driver to Vehicle & Route
    </h2>

    <!-- Error -->
    @if ($errors->any())
        <div class="bg-red-100 text-red-600 p-3 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>⚠ {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST"
          action="{{ route('school_admin.transport.assign.store') }}"
          class="bg-white p-6 rounded shadow">

        @csrf

        <div class="grid md:grid-cols-3 gap-4">

            <!-- Driver -->
            <div>
                <label class="block text-sm mb-1">Select Driver *</label>
                <select name="driver_id" required class="input">
                    <option value="">Select Driver</option>
                    @foreach($drivers as $d)
                        <option value="{{ $d->id }}">
                            {{ $d->name }} ({{ $d->mobile }})
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Vehicle -->
            <div>
                <label class="block text-sm mb-1">Select Vehicle *</label>
                <select name="vehicle_id" required class="input">
                    <option value="">Select Vehicle</option>
                    @foreach($vehicles as $v)
                        <option value="{{ $v->id }}">
                            {{ $v->vehicle_no }} ({{ $v->vehicle_type }})
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Route -->
            <div>
                <label class="block text-sm mb-1">Select Route *</label>
                <select name="route_id" required class="input">
                    <option value="">Select Route</option>
                    @foreach($routes as $r)
                        <option value="{{ $r->id }}">
                            {{ $r->name }} ({{ $r->start_point }} → {{ $r->end_point }})
                        </option>
                    @endforeach
                </select>
            </div>

        </div>

        <!-- Info -->
        <div class="mt-4 text-sm text-gray-500">
            ⚠️ One driver should have only one active assignment
        </div>

        <!-- Buttons -->
        <div class="mt-6 flex gap-3">

            <button type="submit"
                    class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                💾 Assign
            </button>

            <a href="{{ route('school_admin.transport.assign.index') }}"
               class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
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