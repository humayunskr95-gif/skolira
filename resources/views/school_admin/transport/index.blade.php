@extends('layouts.school_admin')

@section('content')

<div class="p-4 md:p-6">

    <!-- 🔥 HEADER -->
    <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4 mb-6">

        <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
            🚐 Driver Management
        </h1>

        <div class="flex gap-2 flex-wrap">

            <a href="{{ route('school_admin.transport.create') }}"
               class="bg-indigo-600 text-white px-4 py-2 rounded-lg">
                ➕ Add
            </a>

            <a href="{{ route('school_admin.transport.export') }}"
               class="bg-green-500 text-white px-4 py-2 rounded-lg">
                📤 Export
            </a>

            <a href="{{ route('school_admin.transport.index') }}"
               class="bg-gray-400 text-white px-4 py-2 rounded-lg">
                Reset
            </a>

        </div>

    </div>

    <!-- 🔍 SEARCH -->
    <form method="GET" class="flex gap-2 mb-4 flex-wrap">

        <input type="text" name="search"
               value="{{ request('search') }}"
               placeholder="Search name, mobile, email, code..."
               class="input w-64">

        <button class="bg-indigo-600 text-white px-4 py-2 rounded">
            🔍 Search
        </button>

    </form>

    <!-- 📊 TABLE -->
    <div class="bg-white shadow-xl rounded-2xl overflow-hidden">

        <div class="overflow-x-auto">

        <table class="w-full text-sm">

            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="p-3">#</th>
                    <th class="p-3 text-left">User</th>
                    <th class="p-3">Code</th>
                    <th class="p-3">Mobile</th>
                    <th class="p-3">Email</th>
                    <th class="p-3">Status</th>
                    <th class="p-3">⚙️</th>
                </tr>
            </thead>

            <tbody>

            @forelse($users as $index => $u)

                <tr class="border-t hover:bg-gray-50">

                    <!-- SL -->
                    <td class="p-3">
                        {{ $users->firstItem() + $index }}
                    </td>

                    <!-- NAME -->
                    <td class="p-3">
                        <div class="font-semibold">{{ $u->name }}</div>
                        <div class="text-xs text-gray-500">{{ $u->father_name }}</div>
                    </td>

                    <!-- CODE -->
                    <td class="p-3">
                        <span class="bg-indigo-100 text-indigo-700 px-2 py-1 rounded text-xs">
                            {{ $u->transport_code }}
                        </span>
                    </td>

                    <!-- MOBILE -->
                    <td class="p-3">{{ $u->mobile }}</td>

                    <!-- EMAIL -->
                    <td class="p-3 text-xs">{{ $u->email }}</td>

                    <!-- STATUS -->
                    <td class="p-3">
                        <form method="POST" action="{{ route('school_admin.transport.toggle',$u->id) }}">
                            @csrf
                            <button class="px-3 py-1 text-xs rounded
                                {{ $u->status ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }}">
                                {{ $u->status ? 'Active' : 'Blocked' }}
                            </button>
                        </form>
                    </td>

                    <!-- ⚙️ ACTION -->
                    <td class="p-3 text-center relative">

                        <div class="relative inline-block">

                            <button onclick="toggleDropdown({{ $u->id }})"
                                    class="bg-gray-200 px-3 py-1 rounded">
                                ⚙️
                            </button>

                            <div id="dropdown-{{ $u->id }}"
                                 class="hidden absolute right-0 mt-2 w-40 bg-white border rounded shadow z-50">

                                <a href="{{ route('school_admin.transport.view',$u->id) }}"
                                   class="block px-3 py-2 hover:bg-gray-100">👁 View</a>

                                <a href="{{ route('school_admin.transport.edit',$u->id) }}"
                                   class="block px-3 py-2 hover:bg-gray-100">✏️ Edit</a>

                                <!-- Block/Unblock -->
                                <form method="POST"
                                      action="{{ route('school_admin.transport.toggle',$u->id) }}">
                                    @csrf
                                    <button class="w-full text-left px-3 py-2 hover:bg-gray-100">
                                        {{ $u->status ? '🚫 Block' : '✅ Unblock' }}
                                    </button>
                                </form>

                                <!-- Delete -->
                                <form method="POST"
                                      action="{{ route('school_admin.transport.delete',$u->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="w-full text-left px-3 py-2 text-red-600 hover:bg-gray-100">
                                        🗑 Delete
                                    </button>
                                </form>

                            </div>

                        </div>

                    </td>

                </tr>

            @empty
                <tr>
                    <td colspan="7" class="text-center p-6 text-gray-500">
                        🚫 No Transport Users Found
                    </td>
                </tr>
            @endforelse

            </tbody>

        </table>

        </div>

        <!-- PAGINATION -->
        <div class="p-4">
            {{ $users->links() }}
        </div>

    </div>

</div>

<style>
.input{
    padding:10px;
    border-radius:8px;
    border:1px solid #ddd;
}
</style>

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