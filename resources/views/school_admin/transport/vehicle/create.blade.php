@extends('layouts.school_admin')

@section('content')

<div class="p-6">

    <!-- Header -->
    <h2 class="text-2xl font-bold mb-6 flex items-center gap-2">
        ➕ Add Vehicle
    </h2>

    <!-- Error -->
    @if ($errors->any())
        <div class="bg-red-100 text-red-600 p-4 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>⚠ {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form Card -->
    <div class="bg-white p-6 rounded shadow">

        <form method="POST" action="{{ route('school_admin.transport.vehicle.store') }}">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                <!-- Vehicle No -->
                <div>
                    <label class="text-sm font-medium">Vehicle No *</label>
                    <input type="text" name="vehicle_no"
                           value="{{ old('vehicle_no') }}"
                           placeholder="WB 34 AB 1234"
                           class="w-full border px-3 py-2 rounded focus:ring focus:border-blue-300">
                </div>

                <!-- Vehicle Type -->
                <div>
                    <label class="text-sm font-medium">Vehicle Type</label>
                    <input type="text" name="vehicle_type"
                           value="{{ old('vehicle_type') }}"
                           placeholder="Bus / Van / Auto"
                           class="w-full border px-3 py-2 rounded focus:ring focus:border-blue-300">
                </div>

                <!-- Capacity -->
                <div>
                    <label class="text-sm font-medium">Capacity</label>
                    <input type="number" name="capacity"
                           value="{{ old('capacity') }}"
                           placeholder="50"
                           class="w-full border px-3 py-2 rounded focus:ring focus:border-blue-300">
                </div>

            </div>

            <!-- Buttons -->
            <div class="mt-6 flex gap-3">

                <button type="submit"
                        class="bg-green-500 hover:bg-green-600 text-white px-5 py-2 rounded shadow">
                    💾 Save
                </button>

                <a href="{{ route('school_admin.transport.vehicle.index') }}"
                   class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-2 rounded shadow">
                    ⬅ Back
                </a>

            </div>

        </form>

    </div>

</div>

@endsection