<header class="bg-white shadow sticky top-0 z-50">

    @php
        $school = app('currentSchool');
        $color = $school->theme_color ?? '#4f46e5';
    @endphp

    <style>
        .theme-btn {
            background: {{ $color }};
        }
        .theme-text {
            color: {{ $color }};
        }
    </style>

    <div class="max-w-7xl mx-auto px-4 md:px-6 py-3 flex items-center justify-between">

        <!-- 🔥 LEFT -->
        <div class="flex items-center gap-3">

            @if($school && $school->logo)
                <img src="{{ asset('storage/'.$school->logo) }}"
                     class="h-10 w-10 rounded-full object-cover border-2 border-indigo-200">
            @endif

            <div>
                <h1 class="font-bold text-lg theme-text flex items-center gap-1">
                    {{ $school->name ?? 'School Website' }}
                </h1>

                <p class="text-xs text-gray-500 hidden md:block">
                    📍 {{ $school->city ?? '' }}, {{ $school->district ?? '' }}
                </p>
            </div>

        </div>

        <!-- 🔥 CENTER MENU -->
        <nav class="hidden md:flex items-center gap-6 text-sm font-medium text-gray-600">

    <a href="{{ route('school.home') }}">Home</a>
<a href="{{ route('school.about') }}">About</a>
<a href="{{ route('school.features') }}">Features</a>
<a href="{{ route('school.gallery') }}">Gallery</a>
<a href="{{ route('school.contact') }}">Contact</a>

</nav>

        <!-- 🔥 RIGHT -->
        <div class="flex items-center gap-3">

            <!-- Login -->
            <a href="/login"
               class="hidden md:flex items-center gap-1 theme-btn text-white px-4 py-2 rounded-lg text-sm shadow hover:opacity-90 transition">
                🔐 Login
            </a>

            <!-- Mobile -->
            <button onclick="toggleMenu()" class="md:hidden text-2xl">
                ☰
            </button>

        </div>

    </div>

    <!-- 🔥 MOBILE MENU -->
    <div id="mobileMenu"
         class="hidden md:hidden bg-white border-t px-4 py-3 space-y-3 text-sm shadow">

        <a href="/" class="flex items-center gap-2">
            🏠 Home
        </a>

        <a href="#about" class="flex items-center gap-2">
            📖 About
        </a>

        <a href="#features" class="flex items-center gap-2">
            ⚡ Features
        </a>

        <a href="#gallery" class="flex items-center gap-2">
            📷 Gallery
        </a>

        <a href="#contact" class="flex items-center gap-2">
            📞 Contact
        </a>

        <a href="/login"
           class="flex items-center justify-center gap-2 theme-btn text-white py-2 rounded-lg shadow">
            🔐 Login
        </a>

    </div>

</header>

<script>
function toggleMenu() {
    document.getElementById('mobileMenu').classList.toggle('hidden');
}
</script>