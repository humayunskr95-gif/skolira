@extends('layouts.super_admin')

@section('content')

<div class="max-w-6xl mx-auto">

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">
            ✏️ Edit School
        </h1>

        <a href="{{ route('super_admin.schools') }}"
           class="bg-gray-200 px-4 py-2 rounded-lg">
            ← Back
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-lg p-8">

        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST"
              action="{{ route('super_admin.schools.update', $school->id) }}"
              enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- 🏫 School Info -->
            <h2 class="font-semibold mb-3">🏫 School Info</h2>

            <div class="grid grid-cols-3 gap-4">

                <input type="text" name="name"
                       value="{{ $school->name }}"
                       class="input" placeholder="School Name">

                <input type="text" name="owner_name"
                       value="{{ $school->owner_name }}"
                       class="input" placeholder="Owner Name">

                <input type="file" name="logo" class="input">

            </div>

            <!-- 📍 Address -->
            <h2 class="font-semibold mt-6 mb-3">📍 Address</h2>

            <div class="grid grid-cols-3 gap-4">

                <input type="text" name="address1"
                       value="{{ $school->address1 }}"
                       class="input" placeholder="Address 1">

                <input type="text" name="address2"
                       value="{{ $school->address2 }}"
                       class="input" placeholder="Address 2">

                <input type="text" name="city"
                       value="{{ $school->city }}"
                       class="input" placeholder="City">

                <input type="text" name="district"
                       value="{{ $school->district }}"
                       class="input" placeholder="District">

                <input type="text" name="state"
                       value="{{ $school->state }}"
                       class="input" placeholder="State">

                <input type="text" name="pin"
                       value="{{ $school->pin }}"
                       class="input" placeholder="PIN Code">

            </div>

            <!-- Logo Preview -->
            @if($school->logo)
                <div class="mt-4">
                    <p class="text-sm text-gray-500 mb-2">Current Logo:</p>
                    <img src="{{ asset('storage/'.$school->logo) }}"
                         class="w-20 h-20 rounded-full">
                </div>
            @endif

            <!-- Submit -->
            <div class="mt-8 text-right">
                <button class="bg-indigo-600 text-white px-6 py-2 rounded-lg">
                    💾 Update
                </button>
            </div>

        </form>

    </div>

</div>

<style>
.input {
    width: 100%;
    padding: 10px;
    border-radius: 8px;
    border: 1px solid #ddd;
}
.input:focus {
    outline: none;
    border-color: #6366f1;
}
</style>

@endsection