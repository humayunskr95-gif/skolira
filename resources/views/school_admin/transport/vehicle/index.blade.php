@extends('layouts.school_admin')

@section('content')

<div class="p-6">

    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold flex items-center gap-2">
            🚐 Vehicle Management
        </h2>

        <div class="flex gap-2">

            <!-- Export -->
            <a href="{{ route('school_admin.transport.vehicle.export') }}"
               class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded shadow">
                📤 Export
            </a>

            <!-- Add Vehicle -->
            <a href="{{ route('school_admin.transport.vehicle.create') }}"
               class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded shadow">
                ➕ Add Vehicle
            </a>

        </div>
    </div>

    <!-- Search -->
    <div class="bg-white p-4 rounded shadow mb-4">
        <form method="GET" class="flex gap-3">
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Search vehicle no / type..."
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
                    <th class="p-3 text-left">Vehicle No</th>
                    <th class="p-3 text-left">Type</th>
                    <th class="p-3 text-left">Capacity</th>
                    <th class="p-3 text-center">⚙</th>
                </tr>
            </thead>

            <tbody>
                @forelse($vehicles as $v)
                <tr class="border-t hover:bg-gray-50">

                    <td class="p-3">
                        {{ ($vehicles->currentPage()-1)*$vehicles->perPage() + $loop->iteration }}
                    </td>

                    <td class="p-3 font-semibold text-blue-600">
                        {{ $v->vehicle_no }}
                    </td>

                    <td class="p-3">
                        {{ $v->vehicle_type ?? '-' }}
                    </td>

                    <td class="p-3">
                        {{ $v->capacity ?? '-' }}
                    </td>

                    <!-- Actions -->
                    <td class="p-3 text-center">

                        <div class="relative inline-block text-left">

                            <button onclick="toggleDropdown({{ $v->id }})"
                                class="bg-gray-200 px-3 py-1 rounded hover:bg-gray-300">
                                ⚙
                            </button>

                            <div id="dropdown-{{ $v->id }}"
                                 class="hidden absolute right-0 mt-2 w-40 bg-white border rounded shadow-lg z-10">

                                <!-- Edit -->
                                <a href="{{ route('school_admin.transport.vehicle.edit',$v->id) }}"
                                   class="block px-4 py-2 hover:bg-gray-100">
                                    ✏️ Edit
                                </a>

                                <!-- Delete -->
                                <form method="POST"
                                      action="{{ route('school_admin.transport.vehicle.delete',$v->id) }}">
                                    @csrf
                                    @method('DELETE')

                                    <button onclick="return confirm('Delete this vehicle?')"
                                            class="w-full text-left px-4 py-2 hover:bg-red-100 text-red-600">
                                        🗑 Delete
                                    </button>
                                </form>

                            </div>

                        </div>

                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center p-4 text-gray-500">
                        No Vehicles Found 😔
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $vehicles->links() }}
    </div>

</div>

<script>
function toggleDropdown(id){
    let el = document.getElementById('dropdown-'+id);
    el.classList.toggle('hidden');
}
</script>

@endsection