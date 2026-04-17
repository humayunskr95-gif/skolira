@extends('layouts.auth')

@section('title', 'Login')

@section('content')

<div class="w-full max-w-md mx-auto">

    <!-- LOGO / BRAND -->
    <div class="text-center mb-6">
        <h1 class="text-3xl font-extrabold text-indigo-600">SKOLIRA</h1>
        <p class="text-gray-500 text-sm">Smart School ERP Platform</p>
    </div>

    <!-- CARD -->
    <div class="bg-white shadow-xl rounded-2xl p-8 border border-gray-100">

        <h2 class="text-xl font-semibold text-gray-800 mb-6 text-center">
            🔐 Login to Your Account
        </h2>

        @if(session('error'))
            <div class="bg-red-100 text-red-600 p-3 rounded-lg mb-4 text-sm">
                {{ session('error') }}
            </div>
        @endif

        <!-- FORM -->
        <form method="POST" action="/login">
            @csrf

            <!-- EMAIL -->
            <div class="mb-4">
                <label class="text-sm text-gray-600">Email</label>
                <input type="email" name="email"
                       class="w-full p-3 mt-1 border rounded-xl focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                       placeholder="Enter your email" required>
            </div>

            <!-- PASSWORD -->
            <div class="mb-5">
                <label class="text-sm text-gray-600">Password</label>
                <input type="password" name="password"
                       class="w-full p-3 mt-1 border rounded-xl focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                       placeholder="Enter your password" required>
            </div>

            <!-- BUTTON -->
            <button
                class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-3 rounded-xl font-semibold hover:scale-[1.02] transition">
                Login
            </button>
        </form>

        <!-- FOOTER -->
        <div class="text-center mt-6 text-sm text-gray-500">
            © {{ date('Y') }} SKOLIRA ERP
        </div>

    </div>

</div>

@endsection