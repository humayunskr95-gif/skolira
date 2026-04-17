<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


@vite(['resources/css/app.css', 'resources/js/app.js'])


</head>

<body class="bg-gray-100">

<div class="flex min-h-screen">

<!-- OVERLAY -->
<div id="overlay" class="fixed inset-0 bg-black/40 hidden z-40"></div>

<!-- SIDEBAR -->
<aside id="sidebar"
    class="fixed md:static z-50 w-72 max-w-[85%]
           bg-gradient-to-b from-indigo-700 to-indigo-900 
           text-white flex flex-col
           transform -translate-x-full md:translate-x-0 
           transition duration-300">

    <!-- HEADER -->
    <div class="p-5 text-xl font-bold border-b border-indigo-500 flex justify-between items-center">
        🎓 Student Panel
        <button id="closeSidebar" class="md:hidden text-2xl">✖</button>
    </div>

    <!-- MENU -->
    <nav class="flex-1 p-4 space-y-2 text-sm overflow-y-auto">

        @php
            $menu = [
                ['student.dashboard','🏠 Dashboard'],
                ['student.subjects','📚 Subjects'],
                ['student.homework','📝 Homework'],
                ['student.attendance','🧾 Attendance'],
                ['student.results','📊 Results'],
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
    <div class="p-4 border-t border-indigo-500">
        <form method="POST" action="{{ tenant_route('logout') }}">
                @csrf
                <button class="w-full bg-red-500 hover:bg-red-600 p-3 rounded-xl">
                    🚪 Logout
                </button>
            </form>
    </div>

    <!-- FOOTER -->
    <div class="p-3 text-xs text-center text-indigo-200">
        © {{ date('Y') }} SKOLIRA ERP
    </div>

</aside>


<!-- MAIN -->
<div class="flex-1 flex flex-col">

    <!-- NAVBAR -->
    <header class="bg-white shadow px-4 md:px-6 py-4 flex justify-between items-center">

        <div class="flex items-center gap-3">

            <button id="menuBtn"
                class="md:hidden text-xl bg-gray-100 px-3 py-2 rounded">
                ☰
            </button>

            <h2 class="font-semibold text-gray-700">
                Welcome, {{ auth()->user()->name }}
            </h2>
        </div>

        <!-- USER -->
        <div class="relative group">

            <button class="flex items-center gap-2 bg-gray-100 px-4 py-2 rounded-xl hover:bg-gray-200">
                👤 {{ auth()->user()->name }}
            </button>

            <div class="absolute right-0 mt-2 w-44 bg-white shadow-xl rounded-xl hidden group-hover:block">

                <a href="#" class="block px-4 py-3 hover:bg-gray-100">
                    ⚙ Profile
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
    <main class="p-4 md:p-6 flex-1 overflow-y-auto">
        @yield('content')
    </main>

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
    background: rgba(255,255,255,0.15);
}
.menu.active {
    background: white;
    color: #4f46e5;
    font-weight: 600;
}
</style>

<!-- JS -->

<script>
    const menuBtn = document.getElementById('menuBtn');
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');
    const closeSidebar = document.getElementById('closeSidebar');

    menuBtn.addEventListener('click', () => {
        sidebar.classList.remove('-translate-x-full');
        overlay.classList.remove('hidden');
    });

    overlay.addEventListener('click', close);
    closeSidebar.addEventListener('click', close);

    function close() {
        sidebar.classList.add('-translate-x-full');
        overlay.classList.add('hidden');
    }
</script>

</body>
</html>
