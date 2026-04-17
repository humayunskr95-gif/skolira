<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'ERP System')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-gradient-to-br from-indigo-600 to-purple-700 min-h-screen flex items-center justify-center">

<div class="w-full max-w-5xl bg-white rounded-2xl shadow-xl overflow-hidden grid md:grid-cols-2">

    <!-- 🔥 Left Branding -->
    <div class="hidden md:flex flex-col justify-center items-center bg-indigo-700 text-white p-10">

        <h1 class="text-3xl font-bold mb-4">🎓 SKOLIRA ERP</h1>

        <p class="text-center text-sm opacity-80">
            Smart School Management System <br>
            Multi School SaaS Platform
        </p>

    </div>

    <!-- 🔥 Right Form -->
    <div class="p-8 md:p-10">

        @yield('content')

    </div>

</div>

</body>
</html>