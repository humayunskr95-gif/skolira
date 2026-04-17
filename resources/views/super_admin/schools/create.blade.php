@extends('layouts.super_admin')

@section('content')

<div class="p-4 md:p-6 max-w-6xl mx-auto">

    <!-- Header -->
    <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-6 gap-3">
        <h1 class="text-xl md:text-2xl font-bold text-gray-800">
            ➕ Create New School
        </h1>

        <a href="{{ route('super_admin.schools') }}"
           class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg text-center">
            ← Back
        </a>
    </div>

    <!-- Success -->
    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    <!-- Error -->
    @if(session('error'))
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
            {{ session('error') }}
        </div>
    @endif

    <!-- Validation Errors -->
    @if ($errors->any())
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
            @foreach ($errors->all() as $error)
                <div>• {{ $error }}</div>
            @endforeach
        </div>
    @endif

    <!-- Card -->
    <div class="bg-white rounded-2xl shadow-lg p-4 md:p-8">

        <form method="POST"
              action="{{ route('super_admin.schools.store') }}"
              enctype="multipart/form-data">
            @csrf

            <!-- 🏫 School Info -->
            <h2 class="text-lg font-semibold mb-4">🏫 School Information</h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                <!-- School Name -->
                <div>
                    <input type="text" name="school_name"
                        value="{{ old('school_name') }}"
                        placeholder="School Name"
                        class="input">
                    @error('school_name')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Owner -->
                <div>
                    <input type="text" name="owner_name"
                        value="{{ old('owner_name') }}"
                        placeholder="Owner Name"
                        class="input">
                </div>

                <!-- Logo -->
                <div>
                    <input type="file" name="logo" class="input">
                </div>

            </div>

            <!-- 📍 Address -->
            <h2 class="text-lg font-semibold mt-6 mb-4">📍 Address</h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                <input type="text" name="address1" placeholder="Address Line 1" class="input">
                <input type="text" name="address2" placeholder="Address Line 2" class="input">
                <input type="text" name="city" placeholder="City" class="input">

                <input type="text" name="district" placeholder="District" class="input">
                <input type="text" name="state" placeholder="State" class="input">
                <input type="text" name="pin" placeholder="PIN Code" class="input">

            </div>

            <!-- 👤 Admin -->
            <h2 class="text-lg font-semibold mt-6 mb-4">👤 School Admin</h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                <!-- Name -->
                <div>
                    <input type="text" name="admin_name"
                        value="{{ old('admin_name') }}"
                        placeholder="Admin Name"
                        class="input">
                    @error('admin_name')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <input type="email" name="admin_email"
                        value="{{ old('admin_email') }}"
                        placeholder="Admin Email"
                        class="input">
                    @error('admin_email')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <input type="password" name="password"
                        placeholder="Password"
                        class="input">
                    @error('password')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            <!-- Submit -->
            <div class="mt-8 flex justify-end">
                <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg shadow w-full md:w-auto">
                    💾 Save School
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
.error {
    color: red;
    font-size: 12px;
    margin-top: 4px;
}
</style>

@endsection