@extends('layouts.super_admin')

@section('content')

<div class="p-4 md:p-6 max-w-7xl mx-auto">

    <!-- 🔥 Header -->
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-3">
        <h1 class="text-xl md:text-2xl font-bold text-gray-800">
            📊 Login Activity
        </h1>

        <!-- Search -->
        <form method="GET" class="flex gap-2 w-full md:w-auto">
            <input type="text" name="search"
                   value="{{ request('search') }}"
                   placeholder="Search IP / Device"
                   class="w-full md:w-64 p-2 border rounded-lg text-sm">

            <button class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm">
                Search
            </button>
        </form>
    </div>

    <!-- 🔥 Card -->
    <div class="bg-white shadow-xl rounded-2xl overflow-hidden">

        <!-- Table (Desktop) -->
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full text-sm">

                <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                    <tr>
                        <th class="p-3 text-left">IP Address</th>
                        <th class="p-3 text-left">Device</th>
                        <th class="p-3 text-left">Browser</th>
                        <th class="p-3 text-left">Platform</th>
                        <th class="p-3 text-left">Login Time</th>
                    </tr>
                </thead>

                <tbody class="divide-y">

                    @forelse($logs as $log)
                    <tr class="hover:bg-gray-50 transition">

                        <td class="p-3 font-medium text-gray-800">
                            {{ $log->ip }}
                        </td>

                        <td class="p-3 text-gray-500">
                            {{ $log->device ?? 'Unknown' }}
                        </td>

                        <td class="p-3 text-gray-500">
                            {{ $log->browser ?? 'N/A' }}
                        </td>

                        <td class="p-3 text-gray-500">
                            {{ $log->platform ?? 'N/A' }}
                        </td>

                        <td class="p-3 text-gray-400">
                            {{ $log->created_at->format('d M Y, h:i A') }}
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center p-6 text-gray-500">
                            No login activity found 🚫
                        </td>
                    </tr>
                    @endforelse

                </tbody>

            </table>
        </div>

        <!-- 🔥 Mobile Card View -->
        <div class="md:hidden divide-y">

            @forelse($logs as $log)
            <div class="p-4">

                <div class="text-sm font-semibold text-gray-800">
                    {{ $log->ip }}
                </div>

                <div class="text-xs text-gray-500 mt-1">
                    {{ $log->device ?? 'Unknown Device' }}
                </div>

                <div class="text-xs text-gray-400 mt-1">
                    {{ $log->browser ?? '' }} | {{ $log->platform ?? '' }}
                </div>

                <div class="text-xs text-indigo-500 mt-2">
                    {{ $log->created_at->format('d M Y, h:i A') }}
                </div>

            </div>
            @empty
            <div class="p-4 text-center text-gray-500">
                No logs found 🚫
            </div>
            @endforelse

        </div>

    </div>

    <!-- 🔥 Pagination -->
    <div class="mt-4">
        {{ $logs->links() }}
    </div>

</div>

@endsection