<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ app('currentSchool')->name ?? 'School' }}</title>

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

<!-- HEADER -->
<x-school_header />

<!-- CONTENT -->
@yield('content')

<!-- FOOTER -->
<footer class="text-white text-center py-5 mt-10"
        style="background: var(--theme)">
    © {{ date('Y') }} {{ $school->name }} • Skolira School ERP
</footer>

</body>
</html>