<!DOCTYPE html>

<html lang="en">
<head>
    <title>Driver Panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">


<script src="https://cdn.tailwindcss.com"></script>


</head>

<body class="bg-gray-100">

<div class="flex min-h-screen">


<!-- OVERLAY -->
<div id="overlay" class="fixed inset-0 bg-black/40 hidden z-40"></div>

<!-- SIDEBAR -->
<aside id="sidebar"
    class="fixed md:static z-50 w-72 max-w-[85%] min-h-screen
           bg-gradient-to-b from-blue-700 to-indigo-800 text-white
           flex flex-col justify-between
           transform -translate-x-full md:translate-x-0 transition duration-300">

    <!-- HEADER -->
    <div class="p-5 text-xl font-bold border-b border-white/20 flex justify-between items-center">
        🚐 Driver Panel
        <button onclick="closeSidebar()" class="md:hidden text-xl">✖</button>
    </div>

    <!-- MENU -->
    <nav class="flex-1 p-4 space-y-2 text-sm">

        @php
            $menu = [
                ['driver.dashboard','📊 Dashboard'],
                ['driver.route','📍 My Route'],
                ['driver.students','👨‍🎓 Students'],
            ];
        @endphp

        @foreach($menu as [$route,$label])
            <a href="{{ route($route) }}"
               class="menu {{ request()->routeIs($route.'*') ? 'active' : '' }}">
                {{ $label }}
            </a>
        @endforeach

    </nav>

    <!-- LOGOUT -->
    <div class="p-4 border-t border-white/20">
        <form method="POST" action="{{ tenant_route('logout') }}">
                @csrf
                <button class="w-full bg-red-500 hover:bg-red-600 p-3 rounded-xl">
                    🚪 Logout
                </button>
            </form>
    </div>

    <!-- FOOTER -->
    <div class="p-3 text-xs text-center text-white/70">
        © {{ date('Y') }} SKOLIRA ERP
    </div>

</aside>


<!-- MAIN -->
<div class="flex-1 flex flex-col">

    <!-- TOPBAR -->
    <header class="bg-white shadow px-4 md:px-6 py-4 flex justify-between items-center sticky top-0 z-30">

        <div class="flex items-center gap-3">

            <!-- MOBILE MENU -->
            <button onclick="openSidebar()" class="md:hidden text-xl bg-gray-100 px-3 py-2 rounded">
                ☰
            </button>

            <h3 class="font-semibold text-gray-700 hidden md:block">
                Driver Dashboard
            </h3>
        </div>

        <!-- PROFILE -->
        <div class="relative group">

            <button class="flex items-center gap-2 bg-gray-100 px-4 py-2 rounded-xl hover:bg-gray-200">
                👤 {{ auth()->user()->name }}
            </button>

            <div class="absolute right-0 mt-2 w-44 bg-white shadow-xl rounded-xl hidden group-hover:block">

                <a href="#" class="block px-4 py-3 hover:bg-gray-100">
                    Profile
                </a>

                <form method="POST" action="{{ tenant_route('logout') }}">
                @csrf
                <button class="w-full bg-red-500 hover:bg-red-600 p-3 rounded-xl">
                    🚪 Logout
                </button>
            </form>

            </div>

        </div>

    </header>

    <!-- CONTENT -->
    <main class="p-4 md:p-6 flex-1">
        @yield('content')
    </main>

    <!-- FOOTER -->
    <footer class="bg-white text-center p-3 text-sm text-gray-500 shadow">
        © {{ date('Y') }} Skolira School ERP | 🚐 Driver Panel
    </footer>

</div>


</div>

<!-- STYLE -->

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
    background: rgba(255,255,255,0.2);
}
.menu.active {
    background: white;
    color: #4f46e5;
    font-weight: 600;
}
</style>

<!-- JS -->

<script>
function openSidebar() {
    document.getElementById('sidebar').classList.remove('-translate-x-full');
    document.getElementById('overlay').classList.remove('hidden');
}

function closeSidebar() {
    document.getElementById('sidebar').classList.add('-translate-x-full');
    document.getElementById('overlay').classList.add('hidden');
}

document.getElementById('overlay').addEventListener('click', closeSidebar);
</script>

</body>
</html>
