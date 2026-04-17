@extends('layouts.auth')

@section('title', 'Register')

@section('content')

<h2 class="text-2xl font-bold text-gray-800 mb-6">📝 Register</h2>

<form method="POST" action="{{ route('register.store') }}">
    @csrf

    <div class="mb-3">
        <label class="text-sm text-gray-600">Full Name</label>
        <input type="text" name="name"
               class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-indigo-500" required>
    </div>

    <div class="mb-3">
        <label class="text-sm text-gray-600">Email</label>
        <input type="email" name="email"
               class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-indigo-500" required>
    </div>

    <div class="mb-3">
        <label class="text-sm text-gray-600">Password</label>
        <input type="password" name="password"
               class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-indigo-500" required>
    </div>

    <div class="mb-3">
        <label class="text-sm text-gray-600">Role</label>
        <select name="role"
                class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-indigo-500">
            <option value="student">Student</option>
            <option value="teacher">Teacher</option>
            <option value="parent">Parent</option>
        </select>
    </div>

    <div class="mb-4">
        <label class="text-sm text-gray-600">School Code</label>
        <input type="text" name="school_code"
               class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-indigo-500" required>
    </div>

    <button class="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700">
        Register
    </button>
</form>

<p class="text-sm mt-4 text-center">
    Already have account?
    <a href="{{ route('login') }}" class="text-indigo-600 font-medium">
        Login
    </a>
</p>

@endsection