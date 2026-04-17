@extends('layouts.school_admin')

@section('content')

<div class="p-4 md:p-6">

    <!-- 🔥 HEADER -->
    <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4 mb-6">

        <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
            👨‍🏫 Teachers Management
        </h1>

        <div class="flex flex-wrap gap-2 items-center">

            <a href="{{ route('school_admin.teachers.create') }}"
               class="flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg shadow text-sm">
                ➕ Add
            </a>

            <a href="{{ route('school_admin.teachers.export') }}"
               class="flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg shadow text-sm">
                📥 Export
            </a>

            <a href="{{ route('school_admin.teachers.template') }}"
               class="flex items-center gap-2 bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg shadow text-sm">
                📄 Template
            </a>

            <!-- IMPORT -->
            <form action="{{ route('school_admin.teachers.import') }}"
                  method="POST"
                  enctype="multipart/form-data"
                  class="flex items-center gap-2 bg-white border rounded-lg px-2 py-1 shadow-sm">
                @csrf

                <input type="file" name="file"
                       class="text-xs border rounded px-2 py-1">

                <button class="flex items-center gap-1 bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm">
                    ⬆️ Import
                </button>
            </form>

        </div>

    </div>

    <!-- 🔍 SEARCH -->
    <form method="GET" class="grid md:grid-cols-4 gap-3 mb-4">

        <input type="text" name="search"
               value="{{ request('search') }}"
               placeholder="Search name, email, mobile..."
               class="input">

        <select name="status" class="input">
            <option value="">All Status</option>
            <option value="1" {{ request('status')=='1'?'selected':'' }}>Active</option>
            <option value="0" {{ request('status')=='0'?'selected':'' }}>Blocked</option>
        </select>

        <button class="bg-indigo-600 text-white rounded-lg py-2">
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
                    <th class="p-3 text-left">Teacher</th>
                    <th class="p-3">Code</th>
                    <th class="p-3">Mobile</th>
                    <th class="p-3">Email</th>
                    <th class="p-3">Status</th>
                    <th class="p-3">Action</th>
                </tr>
            </thead>

            <tbody>

            @forelse($teachers as $index => $t)

                <tr class="border-t hover:bg-gray-50 transition">

                    <td class="p-3">{{ $loop->iteration }}</td>

                    <!-- 👤 NAME + FATHER -->
                    <td class="p-3">
                        <div class="font-semibold text-gray-800">{{ $t->name }}</div>
                        <div class="text-xs text-gray-500">{{ $t->father_name }}</div>
                    </td>

                    <!-- CODE -->
                    <td class="p-3">
                        <span class="bg-indigo-100 text-indigo-700 px-2 py-1 rounded text-xs">
                            {{ $t->teacher_code }}
                        </span>
                    </td>

                    <td class="p-3">{{ $t->mobile }}</td>

                    <td class="p-3 text-xs">{{ $t->email }}</td>

                    <!-- STATUS -->
                    <td class="p-3">
                        <span class="px-2 py-1 text-xs rounded font-medium
                        {{ $t->is_active ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }}">
                            {{ $t->is_active ? 'Active' : 'Blocked' }}
                        </span>
                    </td>

                    <!-- ⚙️ ACTION -->
                    <td class="p-3 text-center relative">

                        <div class="relative inline-block">

                            <button onclick="toggleDropdown({{ $t->id }})"
                                    class="bg-gray-200 hover:bg-gray-300 px-3 py-1 rounded">
                                ⚙️
                            </button>

                            <div id="dropdown-{{ $t->id }}"
                                 class="hidden absolute right-0 mt-2 w-36 bg-white border rounded-xl shadow-lg z-50">

                                <a href="{{ route('school_admin.hostel_super.view',$t->id) }}"
                                   class="block px-3 py-2 hover:bg-gray-100">👁 View</a>

                                <a href="{{ route('school_admin.hostel_super.edit',$t->id) }}"
                                   class="block px-3 py-2 hover:bg-gray-100">✏️ Edit</a>

                                <form method="POST"
                                      action="{{ route('school_admin.hostel_super.delete',$t->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="w-full text-left px-3 py-2 hover:bg-gray-100">
                                        🗑 Delete
                                    </button>
                                </form>

                                <form method="POST"
                                      action="{{ route('school_admin.hostel_super.toggle',$t->id) }}">
                                    @csrf
                                    <button class="w-full text-left px-3 py-2 hover:bg-gray-100">
                                        {{ $t->is_active ? '🔒 Block' : '🔓 Active' }}
                                    </button>
                                </form>

                            </div>

                        </div>

                    </td>

                </tr>

            @empty
                <tr>
                    <td colspan="7" class="text-center p-6 text-gray-500">
                        🚫 No teachers found
                    </td>
                </tr>
            @endforelse

            </tbody>

        </table>

        </div>

        <!-- 📄 PAGINATION -->
        <div class="p-4">
            {{ $teachers->links() }}
        </div>

    </div>

</div>

<!-- 🎨 STYLE -->
<style>
.input {
    padding:10px;
    border-radius:8px;
    border:1px solid #ddd;
}
</style>

<!-- ⚙️ DROPDOWN SCRIPT -->
<script>
function toggleDropdown(id){

    // close all
    document.querySelectorAll('[id^="dropdown-"]').forEach(el=>{
        if(el.id !== 'dropdown-'+id){
            el.classList.add('hidden');
        }
    });

    // toggle current
    let el = document.getElementById('dropdown-'+id);
    el.classList.toggle('hidden');
}

// click বাইরে করলে close
document.addEventListener('click', function(e){
    if(!e.target.closest('.relative')){
        document.querySelectorAll('[id^="dropdown-"]').forEach(el=>{
            el.classList.add('hidden');
        });
    }
});
</script>

@endsection