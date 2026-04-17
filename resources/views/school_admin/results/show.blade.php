@extends('layouts.school_admin')

@section('content')

<div class="p-6 max-w-5xl mx-auto">

    <!-- 🎓 HEADER -->
    <div class="bg-gradient-to-r from-indigo-500 to-purple-600 text-white p-6 rounded-2xl shadow mb-6">

        <h2 class="text-2xl font-bold">🎓 {{ $student->name }}</h2>

        <div class="mt-2 text-sm opacity-90">
            Roll: {{ $student->roll ?? '-' }} |
            Class: {{ $student->studentClass->name ?? '-' }} |
            Section: {{ $student->studentSection->name ?? '-' }}
        </div>

    </div>

    <!-- 📊 SUMMARY -->
    <div class="grid md:grid-cols-3 gap-4 mb-6">

        <div class="bg-white p-4 rounded-xl shadow text-center">
            <p class="text-gray-500">Total Marks</p>
            <h3 class="text-2xl font-bold text-indigo-600">{{ $total }}</h3>
        </div>

        <div class="bg-white p-4 rounded-xl shadow text-center">
            <p class="text-gray-500">Average</p>
            <h3 class="text-2xl font-bold text-green-600">
                {{ number_format($avg,2) }}
            </h3>
        </div>

        <div class="bg-white p-4 rounded-xl shadow text-center">
            <p class="text-gray-500">Grade</p>

            <span class="px-4 py-1 rounded-full text-white
                @if($grade == 'A+') bg-green-600
                @elseif($grade == 'A') bg-blue-600
                @elseif($grade == 'B') bg-yellow-500
                @elseif($grade == 'C') bg-orange-500
                @else bg-red-600
                @endif
            ">
                {{ $grade }}
            </span>

        </div>

    </div>

    <!-- 📋 TABLE -->
    <div class="bg-white shadow rounded-2xl overflow-hidden">

        <table class="w-full text-sm">

            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3 text-left">#</th>
                    <th class="p-3 text-left">Subject</th>
                    <th class="p-3 text-center">Marks</th>
                    <th class="p-3 text-center">Status</th>
                </tr>
            </thead>

            <tbody>

            @forelse($student->results as $index => $r)

                <tr class="border-t hover:bg-gray-50">

                    <td class="p-3">{{ $index + 1 }}</td>

                    <!-- 🔥 FIXED SUBJECT -->
                    <td class="p-3 font-medium">
                        {{ $r->subject->name ?? 'N/A' }}
                    </td>

                    <td class="p-3 text-center font-bold">
                        {{ $r->marks }}
                    </td>

                    <td class="p-3 text-center">
                        <span class="{{ $r->marks >= 40 ? 'text-green-600' : 'text-red-600' }}">
                            {{ $r->marks >= 40 ? '✔ Pass' : '✖ Fail' }}
                        </span>
                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="4" class="text-center p-6 text-gray-500">
                        🚫 No results found
                    </td>
                </tr>

            @endforelse

            </tbody>

        </table>

    </div>

    <!-- BACK -->
    <div class="mt-6">
        <a href="{{ route('school_admin.results.index') }}"
           class="bg-gray-200 hover:bg-gray-300 px-4 py-2 rounded-lg">
            ← Back
        </a>
    </div>

</div>

@endsection