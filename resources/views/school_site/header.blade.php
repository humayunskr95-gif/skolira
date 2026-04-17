<header class="sticky top-0 z-50 bg-white/70 backdrop-blur-xl border-b border-gray-200">

<div class="max-w-7xl mx-auto px-6 py-3 flex items-center justify-between">

    <!-- 🔥 LEFT: Logo -->
    <div class="flex items-center gap-3">

        @php $school = app('currentSchool'); @endphp

        @if($school && $school->logo)
            <img src="{{ asset('storage/'.$school->logo) }}"
                 class="h-11 w-11 rounded-full object-cover border-2 border-indigo-500 shadow">
        @endif

        <div>
            <h1 class="font-bold text-lg text-indigo-700 leading-none">
                {{ $school->name ?? 'School' }}
            </h1>
            <span class="text-xs text-gray-500">Digital School ERP</span>
        </div>

    </div>

    <!-- 🔥 CENTER: MENU -->
    <nav class="hidden md:flex items-center gap-8 text-gray-700 font-medium">

        <a href="/" class="relative group">
            Home
            <span class="absolute left-0 -bottom-1 w-0 h-[2px] bg-indigo-600 transition-all group-hover:w-full"></span>
        </a>

        <a href="#about" class="relative group">
            About
            <span class="absolute left-0 -bottom-1 w-0 h-[2px] bg-indigo-600 transition-all group-hover:w-full"></span>
        </a>

        <a href="#contact" class="relative group">
            Contact
            <span class="absolute left-0 -bottom-1 w-0 h-[2px] bg-indigo-600 transition-all group-hover:w-full"></span>
        </a>

    </nav>

    <!-- 🔥 RIGHT: ACTION -->
    <div class="flex items-center gap-3">

        <!-- Login -->
        <a href="/login"
           class="hidden md:inline-flex items-center gap-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-5 py-2 rounded-xl shadow hover:scale-105 transition">
            🔐 Login
        </a>

        <!-- Mobile Button -->
        <button onclick="toggleMenu()" class="md:hidden text-2xl">
            ☰
        </button>

    </div>

</div>

<!-- 🔥 MOBILE MENU -->
<div id="mobileMenu" class="hidden md:hidden px-6 pb-4 bg-white border-t">

    <a href="/" class="block py-2 border-b">🏠 Home</a>
    <a href="#about" class="block py-2 border-b">ℹ️ About</a>
    <a href="#contact" class="block py-2 border-b">📞 Contact</a>

    <a href="/login"
       class="block mt-3 bg-indigo-600 text-white text-center py-2 rounded-lg">
        Login
    </a>

</div>


</header>

<!-- 🔥 SCRIPT -->

<script>
function toggleMenu() {
    document.getElementById('mobileMenu').classList.toggle('hidden');
}
</script>
