@extends('layouts.super_admin')

@section('content')

<div class="max-w-3xl mx-auto p-6">

    <h1 class="text-2xl font-bold mb-6">👤 My Profile</h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white shadow rounded-xl p-6">

        <form method="POST" action="{{ route('super_admin.profile.update') }}">
            @csrf

            <div class="mb-4">
                <label class="text-sm text-gray-600">Name</label>
                <input type="text" name="name"
                       value="{{ auth()->user()->name }}"
                       class="w-full p-2 border rounded">
            </div>

            <div class="mb-4">
                <label class="text-sm text-gray-600">Email</label>
                <input type="email" name="email"
                       value="{{ auth()->user()->email }}"
                       class="w-full p-2 border rounded">
            </div>

            <div class="mb-4">
                <label class="text-sm text-gray-600">New Password</label>
                <input type="password" name="password"
                       placeholder="Leave blank if no change"
                       class="w-full p-2 border rounded">
            </div>

            <button class="bg-indigo-600 text-white px-6 py-2 rounded">
                💾 Update Profile
            </button>

        </form>

    </div>

</div>

@endsection