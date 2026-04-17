<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ERP System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Tailwind --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Icons --}}
    <script src="https://unpkg.com/lucide@latest"></script>

</head>

<body class="bg-gray-100">

<div class="flex h-screen overflow-hidden">

    <!-- 🔥 Sidebar -->
    <aside class="w-64 bg-indigo-700 text-white flex flex-col">

        <div class="p-5 text-xl font-bold border-b border-indigo-500">
            🎓 ERP PANEL
        </div>

        <nav class="flex-1 p-4 space-y-2">

            <a href="{{ route('super_admin.dashboard') }}"
               class="flex items-center gap-2 p-2 rounded hover:bg-indigo-600">
                📊 Dashboard
            </a>

            <a href="{{ route('super_admin.schools') }}"
               class="flex items-center gap-2 p-2 rounded hover:bg-indigo-600">
                🏫 Schools
            </a>

            <hr class="border-indigo-500 my-3">

            <a href="#" class="flex items-center gap-2 p-2 rounded hover:bg-indigo-600">
                👨‍🏫 Teachers
            </a>

            <a href="#" class="flex items-center gap-2 p-2 rounded hover:bg-indigo-600">
                👨‍🎓 Students
            </a>

            <a href="#" class="flex items-center gap-2 p-2 rounded hover:bg-indigo-600">
                💰 Accounts
            </a>

        </nav>

        <div class="p-4 border-t border-indigo-500">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="w-full bg-red-500 hover:bg-red-600 p-2 rounded">
                    Logout
                </button>
            </form>
        </div>

    </aside>

    <!-- 🔥 Main Content -->
    <div class="flex-1 flex flex-col">

        <!-- Navbar -->
        <header class="bg-white shadow px-6 py-4 flex justify-between items-center">

            <h2 class="text-lg font-semibold text-gray-700">
                Welcome, {{ auth()->user()->name }}
            </h2>

            <div class="flex items-center gap-4">
                <span class="text-sm text-gray-500">
                    {{ auth()->user()->role }}
                </span>
            </div>

        </header>

        <!-- Page Content -->
        <main class="flex-1 p-6 overflow-y-auto">
            @yield('content')
        </main>

    </div>

</div>

<script>
    lucide.createIcons();
</script>

</body>
</html>