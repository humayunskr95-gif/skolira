<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ \App\Models\Setting::first()->app_name ?? 'SKOLIRA ERP' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


<script src="https://cdn.tailwindcss.com"></script>
<script src="//unpkg.com/alpinejs" defer></script>


</head>

<body class="bg-gray-100">

@php
$setting = \App\Models\Setting::first();
@endphp

<div class="flex h-screen overflow-hidden">

<!-- OVERLAY -->
<div id="overlay" onclick="toggleSidebar()"
     class="fixed inset-0 bg-black/50 z-40 hidden md:hidden"></div>

<!-- SIDEBAR -->
<aside id="sidebar"
    class="fixed inset-y-0 left-0 z-50 w-72 max-w-[85%] bg-gradient-to-b from-indigo-700 to-indigo-900 text-white flex flex-col transform -translate-x-full transition duration-300 md:translate-x-0 md:static md:w-64">

    <!-- BRAND -->
    <div class="p-5 border-b border-indigo-500 flex items-center justify-between">
        <div class="flex items-center gap-3">
            @if($setting && $setting->logo)
                <img src="{{ asset('storage/'.$setting->logo) }}" class="w-10 h-10 rounded-full shadow">
            @endif

            <div>
                <div class="font-semibold">
                    {{ $setting->app_name ?? 'Skolira ERP' }}
                </div>
                <div class="text-xs text-indigo-200">
                    Super Admin
                </div>
            </div>
        </div>

        <button onclick="toggleSidebar()" class="md:hidden text-xl">✕</button>
    </div>

    <!-- MENU -->
    <nav class="flex-1 p-4 space-y-2 text-sm overflow-y-auto">

        <a href="{{ route('super_admin.dashboard') }}"
           class="menu {{ request()->routeIs('super_admin.dashboard') ? 'active' : '' }}">
            📊 Dashboard
        </a>

        <a href="{{ route('super_admin.schools') }}"
           class="menu {{ request()->routeIs('super_admin.schools*') ? 'active' : '' }}">
            🏫 Schools
        </a>

        <a href="{{ route('super_admin.plans') }}"
           class="menu {{ request()->routeIs('super_admin.plans*') ? 'active' : '' }}">
            💎 Plans
        </a>

        <a href="{{ route('super_admin.users') }}"
           class="menu {{ request()->routeIs('super_admin.users*') ? 'active' : '' }}">
            👥 Users
        </a>

        <a href="{{ route('super_admin.settings') }}"
           class="menu {{ request()->routeIs('super_admin.settings*') ? 'active' : '' }}">
            ⚙️ Settings
        </a>

    </nav>

    <!-- LOGOUT -->
    <div class="p-4 border-t border-indigo-500">
        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button class="w-full bg-red-500 hover:bg-red-600 p-3 rounded-xl font-semibold shadow hover:shadow-lg transition">
                🚪 Logout
            </button>
        </form>
    </div>
</aside>

<!-- MAIN -->
<div class="flex-1 flex flex-col">

    <!-- NAVBAR -->
    <header class="bg-white shadow px-4 md:px-6 py-4 flex justify-between items-center">

        <div class="flex items-center gap-3">
            <button onclick="toggleSidebar()" class="md:hidden text-2xl">☰</button>

            <h2 class="font-semibold text-gray-700">
                🚀 Super Admin Panel
            </h2>
        </div>

        <!-- USER -->
        <div x-data="{ open: false }" class="relative">

            <button @click="open = !open"
                class="flex items-center gap-2 bg-gray-100 px-4 py-2 rounded-xl hover:bg-gray-200">

                👤 {{ auth()->user()->name }}
            </button>

            <div x-show="open"
                 @click.outside="open = false"
                 class="absolute right-0 mt-2 w-48 bg-white shadow-xl rounded-xl">

                <a href="{{ route('super_admin.profile') }}"
                   class="block px-4 py-3 hover:bg-gray-100">
                    Profile
                </a>

                <a href="{{ route('super_admin.settings') }}"
                   class="block px-4 py-3 hover:bg-gray-100">
                    Settings
                </a>

                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button class="w-full text-left px-4 py-3 hover:bg-red-100 text-red-600">
                        Logout
                    </button>
                </form>

            </div>

        </div>
    </header>

    <!-- CONTENT -->
    <main class="p-4 md:p-6 overflow-y-auto flex-1">
        @yield('content')
    </main>

    <!-- FOOTER -->
    <footer class="bg-white border-t text-gray-500 text-sm px-6 py-3 flex justify-between">
        <div>
            © {{ date('Y') }} {{ $setting->app_name ?? 'Skolira ERP' }}
        </div>
        <div class="text-xs">🚀 SaaS v1.0</div>
    </footer>

</div>


</div>

<style>
.menu {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px;
    border-radius: 10px;
    transition: 0.2s;
}
.menu:hover {
    background: #4f46e5;
}
.menu.active {
    background: white;
    color: #4f46e5;
    font-weight: 600;
}
</style>

<script>
function toggleSidebar() {
    document.getElementById('sidebar').classList.toggle('-translate-x-full');
    document.getElementById('overlay').classList.toggle('hidden');
}
</script>

</body>
</html>
