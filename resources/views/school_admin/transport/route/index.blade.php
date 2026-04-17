@extends('layouts.school_admin')

@section('content')

<div class="p-6">

    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">🛣 Route Management</h2>

        <div class="flex gap-2">
            <a href="{{ route('school_admin.transport.route.export') }}"
               class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded shadow">
               📤 Export
            </a>

            <a href="{{ route('school_admin.transport.route.create') }}"
               class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded shadow">
               ➕ Add Route
            </a>
        </div>
    </div>

    <!-- Search -->
    <div class="bg-white p-4 rounded shadow mb-4">
        <form method="GET" class="flex gap-3">
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Search route..."
                   class="w-full border px-4 py-2 rounded focus:outline-none focus:ring focus:border-blue-300">

            <button class="bg-gray-800 text-white px-4 py-2 rounded hover:bg-black">
                🔍 Search
            </button>
        </form>
    </div>

    <!-- Table -->
    <div class="bg-white rounded shadow overflow-hidden">

        <table class="w-full text-sm">
            <thead class="bg-gray-100 text-gray-600">
                <tr>
                    <th class="p-3 text-left">#</th>
                    <th class="p-3 text-left">Name</th>
                    <th class="p-3 text-left">Start</th>
                    <th class="p-3 text-left">End</th>
                    <th class="p-3 text-center">⚙</th>
                </tr>
            </thead>

            <tbody>
                @forelse($routes as $r)
                <tr class="border-t hover:bg-gray-50">

                    <td class="p-3">
                        {{ ($routes->currentPage()-1)*$routes->perPage() + $loop->iteration }}
                    </td>

                    <td class="p-3 font-semibold text-blue-600">
                        {{ $r->name ?? '-' }}
                    </td>

                    <td class="p-3">
                        {{ $r->start_point ?? '-' }}
                    </td>

                    <td class="p-3">
                        {{ $r->end_point ?? '-' }}
                    </td>

                    <!-- Actions -->
                    <td class="p-3 text-center">

                        <div class="flex justify-center gap-2">

                            <!-- Edit -->
                            <a href="{{ route('school_admin.transport.route.edit', $r->id) }}"
                               class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">
                                ✏️
                            </a>

                            <!-- Delete -->
                            <form method="POST"
                                  action="{{ route('school_admin.transport.route.delete', $r->id) }}">
                                @csrf
                                @method('DELETE')

                                <button onclick="return confirm('Delete this route?')"
                                        class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">
                                    🗑
                                </button>
                            </form>

                        </div>

                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center p-4 text-gray-500">
                        No Routes Found 😔
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $routes->links() }}
    </div>

</div>

@endsection