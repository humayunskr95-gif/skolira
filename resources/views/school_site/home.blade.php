<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ app('currentSchool')->name ?? 'School Website' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://cdn.tailwindcss.com"></script>

    @php
        $school = app('currentSchool');
        $color = $school->theme_color ?? '#4f46e5';
    @endphp

    <style>
        :root {
            --theme: {{ $color }};
        }
    </style>
</head>

<body class="bg-gray-50">

<!-- 🔥 HEADER -->
<x-school_header />

<!-- 🔥 HERO -->
<section class="text-white py-28 text-center relative"
    style="
        background:
        linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)),
        url('{{ $school->banner ? asset('storage/'.$school->banner) : 'https://images.unsplash.com/photo-1580582932707-520aed937b7b' }}');
        background-size: cover;
        background-position: center;
    ">

    <h2 class="text-4xl md:text-5xl font-extrabold mb-4 tracking-wide">
        🎓 {{ $school->name }}
    </h2>

    <p class="text-lg mb-8 opacity-90">
        Smart School • Digital ERP • Future Ready
    </p>

    <!-- 🎯 APPLY BUTTON -->
    <a href="{{ route('school.admission.form') }}"
       class="bg-white text-[var(--theme)] px-8 py-3 rounded-xl font-semibold shadow-lg hover:scale-105 transition inline-block">
        🚀 Admission Now
    </a>

</section>

    <!-- 🔥 LOGIN SECTION (PREMIUM UPDATED) -->

<section class="py-20 bg-white text-center">

<h3 class="text-3xl font-bold mb-12">
    🔐 Login to Your Portal
</h3>

<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-8 max-w-7xl mx-auto px-6">

    @php
        $roles = [
            ['student','🎓','indigo'],
            ['parent','👨‍👩‍👧','green'],
            ['teacher','🧑‍🏫','blue'],
            ['accountant','💰','yellow'],
            ['hostel','🏠','purple'],
            ['driver','🚌','rose'], // ✅ NEW DRIVER
        ];
    @endphp

    @foreach($roles as [$role,$icon,$color])
        <a href="{{ route('school.login') }}?role={{ $role }}"
           class="group bg-white border border-gray-200 
                  hover:bg-{{ $color }}-50 
                  p-8 rounded-2xl shadow-md 
                  hover:shadow-2xl 
                  transition duration-300 
                  hover:-translate-y-2 hover:scale-105">

            <!-- ICON -->
            <div class="text-4xl mb-3 transition group-hover:scale-125">
                {{ $icon }}
            </div>

            <!-- TEXT -->
            <p class="font-semibold text-gray-700 capitalize text-lg
                      group-hover:text-{{ $color }}-600 transition">
                {{ $role }}
            </p>

        </a>
    @endforeach

</div>

</section>

<!-- 🔥 NOTICE -->
<section class="py-16 bg-gray-50">

    <h3 class="text-2xl font-bold text-center mb-10">
        📢 Latest Notices
    </h3>

    <div class="max-w-4xl mx-auto px-6 space-y-5">

        @forelse($school->notices ?? [] as $notice)

            <div class="bg-white p-5 rounded-xl shadow hover:shadow-lg transition border-l-4"
                 style="border-color: var(--theme)">

                <h4 class="font-semibold text-lg text-gray-800">
                    📌 {{ $notice->title }}
                </h4>

                <p class="text-sm text-gray-500 mt-1">
                    {{ $notice->description }}
                </p>

                <p class="text-xs text-gray-400 mt-2">
                    🗓 {{ $notice->created_at->format('d M Y') }}
                </p>

            </div>

        @empty

            <div class="text-center text-gray-500">
                No notices available
            </div>

        @endforelse

    </div>

</section>

<!-- 🔥 CTA SECTION (NEW PREMIUM) -->
<section class="py-16 text-center text-white"
    style="background: linear-gradient(135deg, var(--theme), #6366f1)">

    <h3 class="text-3xl font-bold mb-4">
        Ready to Join {{ $school->name }}?
    </h3>

    <p class="mb-6 opacity-90">
        Start your journey with our smart digital education system
    </p>

    <a href="{{ route('school.admission.form') }}"
       class="bg-white text-[var(--theme)] px-8 py-3 rounded-xl font-semibold shadow hover:scale-105 transition">
        Get Started 🚀
    </a>

</section>

<!-- 🔥 FOOTER -->
<footer class="text-white text-center py-6"
        style="background: var(--theme)">

    © {{ date('Y') }} {{ $school->name }}  
    <br>
    Powered by <span class="font-semibold">Skolira School ERP</span> 🚀

</footer>

</body>
</html>