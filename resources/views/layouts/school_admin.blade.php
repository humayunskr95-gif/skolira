<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>School Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
</head>
@php
    $school = auth()->user()?->school;
    $activeSubscription = $school?->subscription;
    $activePlan = $activeSubscription?->plan;
    $computedDaysLeft = $activeSubscription && method_exists($activeSubscription, 'daysLeft')
        ? $activeSubscription->daysLeft()
        : null;
    $planDaysLeft = $daysLeft ?? $computedDaysLeft;
@endphp

<body class="bg-[#f4f7fb] text-slate-900 antialiased">

<div class="flex min-h-screen overflow-hidden">

<!-- OVERLAY -->
<div id="overlay" onclick="toggleSidebar()"
     class="fixed inset-0 bg-black/50 hidden z-40 md:hidden"></div>

<!-- SIDEBAR -->
<aside id="sidebar"
    class="fixed inset-y-0 left-0 z-50 flex w-72 max-w-[85%]
    flex-col border-r border-white/10 bg-slate-950 text-slate-100
    transform -translate-x-full md:translate-x-0 md:static transition duration-300 shadow-2xl">

    <!-- LOGO -->
    <div class="p-5 border-b border-indigo-500 flex justify-between items-center">
        <h2 class="text-lg font-bold">🏫 School Panel</h2>
        <button onclick="toggleSidebar()" class="md:hidden text-xl">✕</button>
    </div>

    <!-- MENU -->
    <nav class="flex-1 p-4 space-y-2 text-sm overflow-y-auto"
         x-data="{ student:true, staff:false, web:false }">

        <!-- Dashboard -->
        <a href="{{ tenant_route('dashboard') }}"
           class="menu">
            📊 Dashboard
        </a>

        <a href="{{ route('school_admin.profile') }}"
           class="menu">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6.75a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
            </svg>
            <span>Profile</span>
        </a>

        <!-- STUDENT -->
        <div>
            <button @click="student=!student" class="menu justify-between w-full">
                🎓 Student Management
                <span x-text="student ? '-' : '+'"></span>
            </button>

            <div x-show="student" class="ml-4 space-y-1">

                <a href="{{ tenant_route('students.index') }}" class="submenu">👨‍🎓 Students</a>

@if(hasFeature('subjects'))
<a href="{{ tenant_route('subjects.index') }}" class="submenu">📚 Subjects</a>
@endif

@if(hasFeature('classes'))
<a href="{{ tenant_route('classes.index') }}" class="submenu">🏫 Classes</a>
@endif

@if(hasFeature('sections'))
<a href="{{ tenant_route('sections.index') }}" class="submenu">📌 Sections</a>
@endif

@if(hasFeature('attendance'))
<a href="{{ tenant_route('attendance.view') }}" class="submenu">📊 Attendance</a>
@endif

@if(hasFeature('results'))
<a href="{{ tenant_route('results.index') }}" class="submenu">📈 Results</a>
@endif

            </div>
        </div>

        <!-- STAFF -->
        <div>
            <button @click="staff=!staff" class="menu justify-between w-full">
                👨‍💼 Staff Management
                <span x-text="staff ? '-' : '+'"></span>
            </button>

            <div x-show="staff" class="ml-4 space-y-1">

                
                <a href="{{ tenant_route('teachers.index') }}" class="submenu">👨‍🏫 Teachers</a>
                

                @if(hasFeature('accountant'))
                <a href="{{ tenant_route('accountants.index') }}" class="submenu">💼 Accountant</a>
                @endif

                @if(hasFeature('hostel'))
                <a href="{{ tenant_route('hostel_super.index') }}" class="submenu">🏨 Hostel</a>
                @endif

                @if(hasFeature('driver'))
                <a href="{{ tenant_route('transport.index') }}" class="submenu">🚐 Driver Panel</a>
                @endif

                @if(hasFeature('driver_assign'))
                <a href="{{ tenant_route('transport.assign.index') }}" class="submenu">🔗 Driver Assign</a>
                @endif

                @if(hasFeature('vehicles'))
                <a href="{{ tenant_route('transport.vehicle.index') }}" class="submenu">🚌 Vehicles</a>
                @endif

                @if(hasFeature('routes'))
                <a href="{{ tenant_route('transport.route.index') }}" class="submenu">🛣 Routes</a>
                @endif

                @if(hasFeature('leave'))
                <a href="{{ tenant_route('staff_leave.index') }}" class="submenu">📝 Leave</a>
                @endif

                @if(hasFeature('attendance'))
                <a href="{{ tenant_route('staff_attendance.index') }}" class="submenu">📊 Attendance</a>
                @endif

            </div>
        </div>
    @if(hasFeature('fees'))

<div x-data="{ fees: false }">

    <!-- BUTTON -->
    <button type="button"
        @click="fees = !fees"
        class="menu flex justify-between items-center w-full">

        <span>💰 Fees Management</span>
        <span x-text="fees ? '-' : '+'"></span>
    </button>

    <!-- DROPDOWN -->
    <div x-show="fees"
         x-transition
         class="ml-4 mt-2 space-y-1">

        <a href="{{ route('school_admin.fees.report') }}"
           class="submenu block">
            📊 Fees Report
        </a>

    </div>

</div>

@endif
    
    <div x-data="{ user:false }">

    <!-- Parent Button -->
    <button @click="user=!user" class="menu flex justify-between w-full">
        👥 User Management
        <span x-text="user ? '-' : '+'"></span>
    </button>

    <!-- Sub Menu -->
    <div x-show="user" class="ml-4 space-y-1 mt-2">

        <!-- All Users -->
        <a href="{{ tenant_route('users.index') }}" class="submenu">
            👤 All Users
        </a>

</div>
       <!-- WEBSITE -->
        <div>
    <button @click="web=!web" class="menu justify-between w-full">
        🌐 Website
        <span x-text="web ? '-' : '+'"></span>
    </button>

    <div x-show="web" class="ml-4 space-y-1">

        {{-- 🎓 Admissions --}}
        <a href="{{ tenant_route('admissions.index') }}" class="submenu">
            🎓 Admissions
        </a>

        {{-- 📢 Notices --}}
        <a href="{{ tenant_route('notices.index') }}" class="submenu">
            📢 Notices
        </a>

        {{-- 📷 Gallery --}}
        <a href="{{ tenant_route('gallery.index') }}" class="submenu">
            📷 Gallery
        </a>

    </div>
</div>
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

</aside>

<!-- MAIN -->
<div class="flex-1 flex flex-col">

    <!-- NAVBAR -->
    <!-- NAVBAR -->
<!-- NAVBAR -->
<header class="bg-white border-b px-4 md:px-6 py-3 flex justify-between items-center shadow-sm">

    <!-- LEFT -->
    <div class="flex items-center gap-3">
        <button onclick="toggleSidebar()" class="md:hidden text-2xl">☰</button>

        <div>
            <h2 class="font-semibold text-gray-800 flex items-center gap-2">
                🚀 Dashboard
            </h2>
        </div>
    </div>

    <!-- RIGHT -->
    <div class="flex items-center gap-4">

        <!-- PLAN BADGE -->
        @if($activePlan)
        <div class="flex items-center gap-2 bg-gradient-to-r from-indigo-500 to-purple-600 text-white px-4 py-1.5 rounded-full shadow">

            💎 <span class="text-sm font-medium">{{ $activePlan->name }}</span>

            <span class="bg-white/20 px-2 py-0.5 rounded-full text-xs">
                {{ intval($planDaysLeft) }} days
            </span>

        </div>
        @endif

        <!-- USER -->
        <div x-data="{open:false}" class="relative">

    <!-- BUTTON -->
    <button @click.stop="open = !open"
        class="flex items-center gap-2 bg-gray-100 hover:bg-gray-200 px-3 py-2 rounded-lg text-sm">

        👤 <span class="hidden md:block">{{ auth()->user()->name }}</span>
    </button>

    <!-- DROPDOWN -->
    <div x-show="open"
        x-transition.scale.origin.top.right
        @click.outside="open = false"
        @click.stop
        x-cloak
        class="absolute right-0 mt-2 w-48 bg-white shadow-xl rounded-xl border z-50 overflow-hidden">

        <a href="{{ route('school_admin.profile') }}"
           class="block px-4 py-2 hover:bg-gray-100">
            👤 Profile
        </a>

        <form method="POST" action="{{ tenant_route('logout') }}">
            @csrf
            <button type="submit"
                class="w-full text-left px-4 py-2 hover:bg-red-100 text-red-600">
                🚪 Logout
            </button>
        </form>

    </div>

</div>

    </div>
</header>

    <!-- CONTENT -->
    <main class="p-4 md:p-6 flex-1 overflow-y-auto">
        @yield('content')
    </main>

    <!-- FOOTER -->
    <footer class="bg-white text-center text-sm text-gray-500 py-3 border-t">
        © {{ date('Y') }} Skolira School ERP
    </footer>

</div>

</div>

<style>
.menu {
    display:flex;
    align-items:center;
    gap:10px;
    padding:12px;
    border-radius:10px;
}
.menu:hover { background:#4f46e5; }
.submenu {
    display:block;
    padding:8px;
    border-radius:8px;
}
.submenu:hover { background:#6366f1; }
</style>

<script>
function toggleSidebar(){
    document.getElementById('sidebar').classList.toggle('-translate-x-full');
    document.getElementById('overlay').classList.toggle('hidden');
}
</script>

</body>
</html>
