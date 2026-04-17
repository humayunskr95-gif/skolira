@extends('layouts.super_admin')

@section('content')

<div class="p-4 md:p-6 space-y-6">

    <!-- 🔥 Header -->
    <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-3">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-800">
            🚀Dashboard
        </h1>

        <a href="{{ route('super_admin.schools.create') }}"
           class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-5 py-2 rounded-xl shadow hover:opacity-90 text-center">
            + Add School
        </a>
    </div>

    <!-- 🔥 Analytics Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">

        <!-- Revenue -->
        <div class="card gradient1">
            <p>💰 Revenue</p>
            <h2>₹{{ $totalRevenue ?? 0 }}</h2>
        </div>

        <!-- Active -->
        <div class="card gradient2">
            <p>🏫 Active Schools</p>
            <h2>{{ $activeSchools ?? 0 }}</h2>
        </div>

        <!-- Expired -->
        <div class="card gradient3">
            <p>❌ Expired</p>
            <h2>{{ $expiredSchools ?? 0 }}</h2>
        </div>

        <!-- New Users -->
        <div class="card gradient4">
            <p>🆕 Today Users</p>
            <h2>{{ $newUsers ?? 0 }}</h2>
        </div>

    </div>

    <!-- 🔥 System Stats -->
    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">

        <div class="bg-white p-5 rounded-2xl shadow">
            <p class="text-gray-500 text-sm">Total Schools</p>
            <h2 class="text-2xl font-bold text-indigo-600 mt-2">
                {{ $totalSchools ?? 0 }}
            </h2>
        </div>

        <div class="bg-white p-5 rounded-2xl shadow">
            <p class="text-gray-500 text-sm">School Admins</p>
            <h2 class="text-2xl font-bold text-green-600 mt-2">
                {{ $totalAdmins ?? 0 }}
            </h2>
        </div>

        <div class="bg-white p-5 rounded-2xl shadow">
            <p class="text-gray-500 text-sm">Total Users</p>
            <h2 class="text-2xl font-bold text-blue-600 mt-2">
                {{ $totalUsers ?? 0 }}
            </h2>
        </div>

    </div>

    <!-- 🔥 Latest Schools -->
    <div class="bg-white rounded-2xl shadow p-5">

        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold text-gray-700">
                🏫 Latest Schools
            </h2>

            <a href="{{ route('super_admin.schools') }}"
               class="text-indigo-600 hover:underline text-sm">
                View All →
            </a>
        </div>

        <div class="overflow-x-auto">

            <table class="w-full text-sm">

                <thead class="bg-gray-100 text-gray-600">
                    <tr>
                        <th class="p-3">#</th>
                        <th class="p-3 text-left">School</th>
                        <th class="p-3 text-left">Location</th>
                        <th class="p-3 text-center">Code</th>
                        <th class="p-3 text-center">Action</th>
                    </tr>
                </thead>

                <tbody class="divide-y">

                    @forelse($schoolsList ?? [] as $key => $school)
                    <tr class="hover:bg-gray-50 transition">

                        <td class="p-3">{{ $key + 1 }}</td>

                        <!-- School -->
                        <td class="p-3">
                            <div class="flex items-center gap-3">

                                @if($school->logo)
                                    <img src="{{ asset('storage/'.$school->logo) }}"
                                         class="w-8 h-8 rounded-full object-cover">
                                @else
                                    <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center">
                                        🏫
                                    </div>
                                @endif

                                <div>
                                    <div class="font-medium text-gray-800">
                                        {{ $school->name }}
                                    </div>
                                    <div class="text-xs text-gray-400">
                                        {{ $school->owner_name ?? 'Owner N/A' }}
                                    </div>
                                </div>

                            </div>
                        </td>

                        <!-- Location -->
                        <td class="p-3 text-gray-500">
                            {{ $school->city ?? '' }},
                            {{ $school->district ?? '' }}
                        </td>

                        <!-- Code -->
                        <td class="p-3 text-center text-indigo-600 font-semibold text-xs">
                            {{ $school->code ?? 'N/A' }}
                        </td>

                        <!-- Action -->
                        <td class="p-3 text-center">

                            <a href="{{ route('super_admin.schools.view', $school->id) }}"
                               class="text-green-600 hover:underline text-xs">
                                View
                            </a>

                        </td>

                    </tr>

                    @empty
                    <tr>
                        <td colspan="5" class="text-center p-4 text-gray-500">
                            No schools found 🚫
                        </td>
                    </tr>
                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

<!-- 🔥 Premium Style -->
<style>
.card {
    padding: 20px;
    border-radius: 16px;
    color: white;
    font-size: 14px;
}
.card h2 {
    font-size: 22px;
    font-weight: bold;
    margin-top: 5px;
}

/* Gradients */
.gradient1 { background: linear-gradient(135deg,#4f46e5,#6366f1); }
.gradient2 { background: linear-gradient(135deg,#059669,#10b981); }
.gradient3 { background: linear-gradient(135deg,#dc2626,#ef4444); }
.gradient4 { background: linear-gradient(135deg,#7c3aed,#a855f7); }
</style>

@endsection