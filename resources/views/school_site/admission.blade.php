@extends('school_site.layout')

@section('content')

@php
    $school = app('currentSchool');
    $color = $school->theme_color ?? '#4f46e5';
@endphp

<style>
    .theme-btn {
        background: {{ $color }};
    }
    .theme-border:focus {
        border-color: {{ $color }};
        box-shadow: 0 0 0 2px {{ $color }}30;
    }
</style>

<div class="min-h-screen bg-gradient-to-br from-indigo-50 to-purple-50 py-10 px-4">

    <div class="max-w-3xl mx-auto">

        <!-- 🔥 CARD -->
        <div class="bg-white shadow-xl rounded-2xl p-6 md:p-10">

            <!-- Title -->
            <h2 class="text-2xl md:text-3xl font-bold text-center mb-6">
                🎓 Admission Form
            </h2>

            <!-- School Name -->
            <p class="text-center text-gray-500 mb-6">
                Apply for admission at <span class="font-semibold">{{ $school->name }}</span>
            </p>

            <!-- Success -->
            @if(session('success'))
                <div class="bg-green-100 text-green-700 p-3 mb-4 rounded text-center">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Errors -->
            @if($errors->any())
                <div class="bg-red-100 text-red-700 p-3 mb-4 rounded">
                    <ul class="text-sm space-y-1">
                        @foreach($errors->all() as $error)
                            <li>• {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- FORM -->
            <form method="POST" action="{{ route('admission.store') }}" enctype="multipart/form-data" class="space-y-4">
                @csrf

                <!-- Name -->
                <div>
                    <label class="text-sm text-gray-600">👤 Full Name</label>
                    <input type="text" name="name" value="{{ old('name') }}"
                           class="w-full mt-1 p-3 border rounded-lg theme-border"
                           placeholder="Enter full name">
                </div>

                <!-- Email -->
                <div>
                    <label class="text-sm text-gray-600">📧 Email</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                           class="w-full mt-1 p-3 border rounded-lg theme-border"
                           placeholder="Enter email">
                </div>

                <!-- Mobile -->
                <div>
                    <label class="text-sm text-gray-600">📱 Mobile</label>
                    <input type="text" name="mobile" value="{{ old('mobile') }}"
                           class="w-full mt-1 p-3 border rounded-lg theme-border"
                           placeholder="Enter mobile number">
                </div>

                <!-- Class -->
                <div>
                    <label class="text-sm text-gray-600">🏫 Class</label>
                    <input type="text" name="class" value="{{ old('class') }}"
                           class="w-full mt-1 p-3 border rounded-lg theme-border"
                           placeholder="Enter class">
                </div>

                <!-- Address -->
                <div>
                    <label class="text-sm text-gray-600">📍 Address</label>
                    <textarea name="address"
                              class="w-full mt-1 p-3 border rounded-lg theme-border"
                              placeholder="Enter address">{{ old('address') }}</textarea>
                </div>

                <!-- Photo -->
                <div>
                    <label class="text-sm text-gray-600">🖼 Upload Photo</label>
                    <input type="file" name="photo"
                           class="w-full mt-1 border p-2 rounded-lg">
                </div>

                <!-- Submit -->
                <button class="w-full theme-btn text-white py-3 rounded-lg font-semibold shadow hover:opacity-90 transition">
                    🚀 Submit Application
                </button>

            </form>

        </div>

    </div>

</div>

@endsection