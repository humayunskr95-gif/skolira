@extends('layouts.super_admin')

@section('content')

<div class="p-4 md:p-6 max-w-7xl mx-auto">

    <!-- Header -->
    <h1 class="text-2xl font-bold mb-6">👥 Users Monitoring</h1>

    <!-- Stats -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">

        <div class="card">Total <br><b>{{ $totalUsers }}</b></div>
        <div class="card">Students <br><b>{{ $students }}</b></div>
        <div class="card">Teachers <br><b>{{ $teachers }}</b></div>
        <div class="card">Admins <br><b>{{ $admins }}</b></div>

    </div>

    <!-- Table -->
    <div class="bg-white shadow rounded-xl overflow-x-auto">

        <table class="w-full text-sm">

            <thead class="bg-gray-100 text-xs uppercase">
                <tr>
                    <th class="p-3 text-left">User</th>
                    <th class="p-3">Role</th>
                    <th class="p-3">School</th>
                    <th class="p-3">Status</th>
                    <th class="p-3 text-center">Action</th>
                </tr>
            </thead>

            <tbody class="divide-y">

                @foreach($users as $user)
                <tr class="hover:bg-gray-50">

                    <!-- User -->
                    <td class="p-3">
                        <div>
                            <div class="font-semibold">{{ $user->name }}</div>
                            <div class="text-xs text-gray-500">{{ $user->email }}</div>
                        </div>
                    </td>

                    <!-- Role -->
                    <td class="p-3 text-center">
                        <span class="px-2 py-1 bg-indigo-100 text-indigo-600 text-xs rounded">
                            {{ ucfirst($user->role) }}
                        </span>
                    </td>

                    <!-- School -->
                    <td class="p-3 text-center text-gray-600">
                        {{ $user->school->name ?? 'N/A' }}
                    </td>

                    <!-- Status -->
                    <td class="p-3 text-center">
                        @if($user->is_active)
                            <span class="px-2 py-1 bg-green-100 text-green-600 text-xs rounded">
                                Active
                            </span>
                        @else
                            <span class="px-2 py-1 bg-red-100 text-red-600 text-xs rounded">
                                Blocked
                            </span>
                        @endif
                    </td>

                    <!-- Actions -->
                    <td class="p-3 text-center">

                        <div x-data="{open:false}" class="relative inline-block">

                            <!-- Button -->
                            <button @click="open = !open"
                                class="px-2 py-1 bg-gray-200 rounded hover:bg-gray-300">
                                ⚙️
                            </button>

                            <!-- Dropdown -->
                            <div x-show="open" @click.away="open=false"
                                class="absolute right-0 mt-2 w-40 bg-white border rounded shadow z-50">

                                <!-- Logs -->
                                <a href="{{ route('super_admin.users.logs', $user->id) }}"
                                   class="block px-3 py-2 text-sm hover:bg-gray-100">
                                    📊 Logs
                                </a>

                                <!-- Reset -->
                                <form method="POST"
                                      action="{{ route('super_admin.users.reset', $user->id) }}">
                                    @csrf
                                    <button class="w-full text-left px-3 py-2 text-sm hover:bg-gray-100">
                                        🔑 Reset Password
                                    </button>
                                </form>

                                <!-- Block/Unblock -->
                                @if($user->role !== 'super_admin')
                                <form method="POST"
                                      action="{{ route('super_admin.users.toggle', $user->id) }}">
                                    @csrf
                                    <button class="w-full text-left px-3 py-2 text-sm hover:bg-gray-100">
                                        {{ $user->is_active ? '❌ Block' : '✅ Unblock' }}
                                    </button>
                                </form>
                                @endif

                            </div>

                        </div>

                    </td>

                </tr>
                @endforeach

            </tbody>

        </table>

    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $users->links() }}
    </div>

</div>

<style>
.card {
    background: white;
    padding: 15px;
    border-radius: 12px;
    text-align: center;
    box-shadow: 0 4px 10px rgba(0,0,0,0.05);
}
</style>

@endsection