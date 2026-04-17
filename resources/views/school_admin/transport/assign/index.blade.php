@extends('layouts.school_admin')

@section('content')

<div class="p-4 md:p-6">

    <!-- 🔥 HEADER -->
    <div class="flex justify-between items-center mb-6">

        <h1 class="text-2xl font-bold text-gray-800">
            🚐 Driver Assignment
        </h1>

        <a href="{{ route('school_admin.transport.assign.create') }}"
           class="bg-indigo-600 text-white px-4 py-2 rounded-lg">
            ➕ Assign Driver
        </a>

    </div>

    <!-- 📊 TABLE -->
    <div class="bg-white shadow-xl rounded-2xl overflow-hidden">

        <div class="overflow-x-auto">

        <table class="w-full text-sm">

            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="p-3">#</th>
                    <th class="p-3 text-left">Driver</th>
                    <th class="p-3">Vehicle</th>
                    <th class="p-3">Route</th>
                    <th class="p-3">Action</th>
                </tr>
            </thead>

            <tbody>

            @forelse($assignments as $index => $a)

                <tr class="border-t hover:bg-gray-50">

                    <!-- SL -->
                    <td class="p-3">
                        {{ $index + 1 }}
                    </td>

                    <!-- DRIVER -->
                    <td class="p-3">
                        <div class="font-semibold">
                            {{ optional($a->driver)->name ?? '-' }}
                        </div>
                        <div class="text-xs text-gray-500">
                            {{ optional($a->driver)->mobile ?? '-' }}
                        </div>
                    </td>

                    <!-- VEHICLE -->
                    <td class="p-3">
                        <span class="bg-indigo-100 text-indigo-700 px-2 py-1 rounded text-xs">
                            {{ optional($a->vehicle)->vehicle_no ?? '-' }}
                        </span>
                    </td>

                    <!-- ROUTE -->
                    <td class="p-3">
                        <div>
                            {{ optional($a->route)->name ?? '-' }}
                        </div>
                        <div class="text-xs text-gray-500">
                            {{ optional($a->route)->start_point ?? '-' }}
                            →
                            {{ optional($a->route)->end_point ?? '-' }}
                        </div>
                    </td>

                    <!-- ⚙️ ACTION -->
                    <td class="p-3 text-center relative">

                        <div class="relative inline-block">

                            <button onclick="toggleDropdown({{ $a->id }})"
                                    class="bg-gray-200 px-3 py-1 rounded">
                                ⚙️
                            </button>

                            <div id="dropdown-{{ $a->id }}"
                                 class="hidden absolute right-0 mt-2 w-40 bg-white border rounded shadow z-50">

                                <a href="{{ route('school_admin.transport.assign.edit',$a->id) }}"
                                   class="block px-3 py-2 hover:bg-gray-100">
                                   ✏️ Edit
                                </a>

                                <form method="POST"
                                      action="{{ route('school_admin.transport.assign.delete',$a->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Delete this assignment?')"
                                            class="w-full text-left px-3 py-2 text-red-600 hover:bg-gray-100">
                                        🗑 Delete
                                    </button>
                                </form>

                            </div>

                        </div>

                    </td>

                </tr>

            @empty
                <tr>
                    <td colspan="5" class="text-center p-6 text-gray-500">
                        🚫 No Assignments Found
                    </td>
                </tr>
            @endforelse

            </tbody>

        </table>

        </div>

    </div>

</div>

<!-- DROPDOWN SCRIPT -->
<script>
function toggleDropdown(id){
    document.querySelectorAll('[id^="dropdown-"]').forEach(el=>{
        if(el.id !== 'dropdown-'+id){
            el.classList.add('hidden');
        }
    });

    document.getElementById('dropdown-'+id).classList.toggle('hidden');
}

document.addEventListener('click', function(e){
    if(!e.target.closest('.relative')){
        document.querySelectorAll('[id^="dropdown-"]').forEach(el=>{
            el.classList.add('hidden');
        });
    }
});
</script>

@endsection