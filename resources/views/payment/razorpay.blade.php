<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Secure Payment • SKOLIRA School ERP</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

<div class="min-h-screen flex items-center justify-center px-4">

    <div class="bg-white rounded-2xl shadow-xl max-w-md w-full p-6 text-center">

        <!-- 🔥 LOGO -->
        <div class="flex justify-center mb-4">
            <img src="{{ asset('logo.png') }}" 
                 alt="SKOLIRA ERP"
                 class="h-14">
        </div>

        <!-- BRAND -->
        <h1 class="text-xl font-bold text-gray-800">
            SKOLIRA School ERP
        </h1>

        <p class="text-gray-500 text-sm mb-4">
            Secure Plan Payment 🔒
        </p>

        <!-- PLAN INFO -->
        <div class="bg-gray-50 p-4 rounded-xl mb-5">

            <h2 class="font-semibold text-lg text-gray-700">
                {{ $plan->name }}
            </h2>

            <p class="text-3xl font-bold text-indigo-600 my-2">
                ₹{{ $plan->price }}
            </p>

            <p class="text-sm text-gray-500">
                {{ $plan->duration }} Days Access
            </p>

        </div>

        <!-- USER INFO -->
        <div class="text-left text-sm text-gray-600 mb-5">
            <p><strong>Name:</strong> {{ $user->name }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
        </div>

        <!-- PAYMENT BUTTON -->
        <form action="{{ route('payment.success') }}" method="POST">
            @csrf

            <script
                src="https://checkout.razorpay.com/v1/checkout.js"
                data-key="{{ $key }}"
                data-amount="{{ $order['amount'] }}"
                data-currency="INR"
                data-order_id="{{ $order['id'] }}"
                data-buttontext="💳 Pay Securely"
                data-name="SKOLIRA ERP"
                data-description="{{ $plan->name }} Plan"
                data-image="{{ asset('logo.png') }}"
                data-prefill.name="{{ $user->name }}"
                data-prefill.email="{{ $user->email }}"
                data-theme.color="#4f46e5">
            </script>

            <input type="hidden" name="plan_id" value="{{ $plan->id }}">
        </form>

        <!-- TRUST TEXT -->
        <p class="text-xs text-gray-400 mt-4">
            🔒 100% Secure Payment via Razorpay
        </p>

    </div>

</div>

</body>
</html>