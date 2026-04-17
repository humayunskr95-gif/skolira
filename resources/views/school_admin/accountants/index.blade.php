@extends('layouts.school_admin')

@section('content')

<div class="p-4">

    <!-- HEADER -->
    <form method="GET" class="flex flex-wrap items-center justify-between mb-4 gap-2">

        <h2 class="text-xl font-semibold flex items-center gap-2">
            💼 Accountant Management
        </h2>

        <div class="flex gap-2 flex-wrap">

            <!-- Search -->
            <input type="text" name="search"
                   value="{{ request('search') }}"
                   placeholder="Search name, email, code..."
                   class="border px-3 py-2 rounded w-56 focus:ring-2 focus:ring-indigo-400">

            <!-- Search Button -->
            <button class="bg-indigo-500 text-white px-3 py-2 rounded hover:bg-indigo-600">
                🔍 Search
            </button>

            <!-- Reset -->
            <a href="{{ route('school_admin.accountants.index') }}"
               class="bg-gray-400 text-white px-3 py-2 rounded">
                Reset
            </a>

            <!-- Export -->
            <a href="{{ route('school_admin.accountants.export') }}"
               class="bg-green-500 text-white px-3 py-2 rounded hover:bg-green-600">
                📤 Export
            </a>

            <!-- Add -->
            <a href="{{ route('school_admin.accountants.create') }}"
               class="bg-indigo-600 text-white px-3 py-2 rounded hover:bg-indigo-700">
                ➕ Add
            </a>

        </div>

    </form>

    <!-- TABLE -->
    <div class="bg-white shadow rounded overflow-hidden">

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-left">

                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="px-4 py-3">#</th>
                        <th class="px-4 py-3">Code</th>
                        <th class="px-4 py-3">Name</th>
                        <th class="px-4 py-3">Father</th>
                        <th class="px-4 py-3">Mobile</th>
                        <th class="px-4 py-3">Email</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3 text-center">⚙️</th>
                    </tr>
                </thead>

                <tbody class="divide-y">

                    @forelse($accountants as $key => $user)
                    <tr class="hover:bg-gray-50">

                        <td class="px-4 py-3">
                            {{ $accountants->firstItem() + $key }}
                        </td>

                        <td class="px-4 py-3 font-semibold text-indigo-600">
                            {{ $user->account_code ?? 'N/A' }}
                        </td>

                        <td class="px-4 py-3 flex items-center gap-2">

                            @if($user->photo)
                                <img src="{{ asset('storage/'.$user->photo) }}"
                                     class="w-8 h-8 rounded-full object-cover">
                            @else
                                <div class="w-8 h-8 rounded-full bg-gray-300 flex items-center justify-center text-xs">
                                    {{ strtoupper(substr($user->name,0,1)) }}
                                </div>
                            @endif

                            {{ $user->name }}
                        </td>

                        <td class="px-4 py-3">{{ $user->father_name ?? '-' }}</td>
                        <td class="px-4 py-3">{{ $user->mobile }}</td>
                        <td class="px-4 py-3">{{ $user->email }}</td>

                        <!-- Status Toggle -->
                        <td class="px-4 py-3">
                            <form method="POST" action="{{ route('school_admin.accountants.toggle',$user->id) }}">
                                @csrf
                                <button class="px-2 py-1 rounded text-xs
                                    {{ $user->status ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }}">
                                    {{ $user->status ? 'Active' : 'Inactive' }}
                                </button>
                            </form>
                        </td>

                        <!-- Action -->
                        <td class="px-4 py-3 text-center">
                            <div class="relative inline-block text-left" x-data="{open:false}">

                                <button @click="open = !open"
                                        class="bg-gray-200 px-2 py-1 rounded">
                                    ⚙️
                                </button>

                                <div x-show="open" @click.away="open=false"
                                     class="absolute right-0 mt-2 w-36 bg-white border rounded shadow z-50">

                                    <a href="{{ route('school_admin.accountants.show',$user->id) }}"
                                       class="block px-3 py-2 hover:bg-gray-100">👁 View</a>

                                    <a href="{{ route('school_admin.accountants.edit',$user->id) }}"
                                       class="block px-3 py-2 hover:bg-gray-100">✏️ Edit</a>

                                    <form method="POST"
                                          action="{{ route('school_admin.accountants.destroy',$user->id) }}">
                                        @csrf @method('DELETE')
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
                        <td colspan="8" class="text-center py-4 text-gray-500">
                            No Data Found
                        </td>
                    </tr>
                    @endforelse

                </tbody>

            </table>
        </div>

        <!-- PAGINATION -->
        <div class="p-4">
            {{ $accountants->links() }}
        </div>

    </div>

</div>

@endsection