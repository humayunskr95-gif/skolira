<!DOCTYPE html>
<html lang="en">
<head>
    <title>Accountant Panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        .sidebar-transition {
            transition: all 0.3s ease;
        }
    </style>
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">

<div class="flex flex-1">

    <!-- 🔥 SIDEBAR -->
    <aside id="sidebar"
        class="sidebar-transition fixed md:static z-50 w-64 bg-gradient-to-b from-indigo-700 to-purple-700 text-white p-5 h-full md:h-auto flex flex-col justify-between md:translate-x-0 -translate-x-full">

        <div>
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold">💰 Accountant</h2>
                <button onclick="toggleSidebar()" class="md:hidden">✖</button>
            </div>

            <ul class="space-y-3 text-sm">

                <li>
                    <a href="{{ route('accountant.dashboard') }}"
                       class="block px-3 py-2 rounded hover:bg-white/20 
                       {{ request()->routeIs('accountant.dashboard') ? 'bg-white/30' : '' }}">
                        📊 Dashboard
                    </a>
                </li>

                <li>
                    <a href="{{ route('accountant.fees.index') }}"
                       class="block px-3 py-2 rounded hover:bg-white/20
                       {{ request()->routeIs('accountant.fees.*') ? 'bg-white/30' : '' }}">
                        💵 Fees
                    </a>
                </li>

                <li>
                    <a href="{{ route('accountant.expenses.index') }}"
                       class="block px-3 py-2 rounded hover:bg-white/20
                       {{ request()->routeIs('accountant.expenses.*') ? 'bg-white/30' : '' }}">
                        💸 Expenses
                    </a>
                </li>

                <li>
                    <a href="{{ route('accountant.reports') }}"
                       class="block px-3 py-2 rounded hover:bg-white/20
                       {{ request()->routeIs('accountant.reports') ? 'bg-white/30' : '' }}">
                        📈 Reports
                    </a>
                </li>

            </ul>
        </div>

        <!-- 🔥 Logout Bottom -->
        <div class="mt-6 border-t pt-4">
            <form method="POST" action="{{ tenant_route('logout') }}">
                @csrf
                <button class="w-full bg-red-500 hover:bg-red-600 p-3 rounded-xl">
                    🚪 Logout
                </button>
            </form>
        </div>

    </aside>

    <!-- 🔥 MAIN CONTENT -->
    <div class="flex-1 flex flex-col">

        <!-- 🔥 TOPBAR -->
        <div class="bg-white shadow p-4 flex justify-between items-center sticky top-0 z-40">

            <!-- Mobile Menu -->
            <button onclick="toggleSidebar()" class="md:hidden text-xl">
                ☰
            </button>

            <h3 class="font-semibold text-gray-700 hidden md:block">
                Dashboard
            </h3>

            <!-- 🔥 PROFILE -->
            <div class="relative">
                <button onclick="toggleProfile()" class="flex items-center gap-2">
                    <img src="https://i.pravatar.cc/40" class="w-8 h-8 rounded-full">
                    <span class="hidden md:block">{{ auth()->user()->name }}</span>
                </button>

                <div id="profileMenu"
                     class="hidden absolute right-0 mt-2 w-40 bg-white shadow rounded">

                    <a href="#" class="block px-4 py-2 hover:bg-gray-100">
                        👤 Profile
                    </a>

                    <form method="POST" action="{{ tenant_route('logout') }}">
                @csrf
                <button class="w-full bg-red-500 hover:bg-red-600 p-3 rounded-xl">
                    🚪 Logout
                </button>
            </form>

                </div>
            </div>

        </div>

        <!-- 🔥 CONTENT -->
        <div class="flex-1 p-6">
            @yield('content')
        </div>

        <!-- 🔥 FOOTER -->
        <footer class="bg-white shadow text-center py-3 text-sm text-gray-600">
            © {{ date('Y') }} SKOLIRA ERP | All Rights Reserved 🚀
        </footer>

    </div>

</div>

<!-- 🔥 JS -->
<script>
function toggleSidebar() {
    document.getElementById('sidebar').classList.toggle('-translate-x-full');
}

function toggleProfile() {
    document.getElementById('profileMenu').classList.toggle('hidden');
}
</script>

</body>
</html>