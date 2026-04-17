@extends('layouts.school_admin')

@section('content')

<div x-data="userManager()" class="p-4 md:p-6">

<h2 class="text-xl md:text-2xl font-bold mb-4">👥 User Management</h2>

<!-- 🔍 SEARCH -->
<form method="GET" class="mb-4 flex flex-col md:flex-row gap-2">
    <input type="text" name="search" value="{{ request('search') }}"
        placeholder="Search name or email..."
        class="border px-3 py-2 rounded w-full md:w-1/3">

    <button class="bg-indigo-600 text-white px-4 py-2 rounded">
        🔍 Search
    </button>
</form>

<!-- 📱 TABLE -->
<div class="overflow-x-auto bg-white rounded-xl shadow">

<table class="min-w-full text-sm">

<thead class="bg-gray-100">
<tr>
    <th class="p-3 text-left">Name</th>
    <th class="p-3 text-left">Email</th>
    <th class="p-3">Role</th>
    <th class="p-3">Status</th>
    <th class="p-3">Action</th>
</tr>
</thead>

<tbody>

@foreach($users as $user)
<tr class="border-t hover:bg-gray-50">

<td class="p-3 font-medium">{{ $user->name }}</td>

<td class="p-3 text-gray-600 break-all">
    {{ $user->email }}
</td>

<td class="p-3 capitalize text-center">
    {{ $user->role }}
</td>

<td class="p-3 text-center">
    <span id="status-{{ $user->id }}"
        class="px-2 py-1 text-xs rounded
        {{ $user->is_active ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }}">
        {{ $user->is_active ? 'Active' : 'Blocked' }}
    </span>
</td>

<td class="p-3 flex flex-col md:flex-row gap-2 justify-center">

    <!-- 🔑 RESET PASSWORD -->
    <button @click="openModal({{ $user->id }})"
        class="bg-indigo-500 hover:bg-indigo-600 text-white px-3 py-1 rounded text-xs">
        Reset
    </button>

    <!-- 🔥 TOGGLE -->
    <button onclick="toggleUser({{ $user->id }})"
        class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-xs">
        Toggle
    </button>

</td>

</tr>
@endforeach

</tbody>

</table>

</div>

<!-- PAGINATION -->
<div class="mt-4">
    {{ $users->withQueryString()->links() }}
</div>


<!-- 🔥 MODAL -->
<div x-show="showModal" class="fixed inset-0 bg-black/50 flex items-center justify-center">

    <div class="bg-white rounded-xl p-6 w-80 shadow-xl">

        <h3 class="font-bold text-lg mb-3">🔑 Reset Password</h3>

        <input type="password" x-model="password"
            placeholder="Enter new password"
            class="border w-full p-2 rounded mb-3">

        <div class="flex justify-end gap-2">

            <button @click="showModal=false"
                class="px-3 py-1 bg-gray-200 rounded">
                Cancel
            </button>

            <button @click="submitReset"
                class="px-3 py-1 bg-indigo-600 text-white rounded">
                Update
            </button>

        </div>

    </div>

</div>

</div>

<!-- 🔥 SCRIPT -->
<script>
function userManager() {
    return {
        showModal: false,
        userId: null,
        password: '',

        openModal(id) {
            this.userId = id;
            this.password = '';
            this.showModal = true;
        },

        submitReset() {
            fetch(`/school-admin/users/reset/${this.userId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ password: this.password })
            })
            .then(res => res.json())
            .then(data => {
                alert(data.message);
                this.showModal = false;
            });
        }
    }
}

function toggleUser(id) {

    fetch(`/school-admin/users/toggle/${id}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(res => res.json())
    .then(data => {

        let el = document.getElementById('status-'+id);

        if(data.status === 1){
            el.innerText = 'Active';
            el.className = 'px-2 py-1 text-xs rounded bg-green-100 text-green-600';
        } else {
            el.innerText = 'Blocked';
            el.className = 'px-2 py-1 text-xs rounded bg-red-100 text-red-600';
        }

    });
}
</script>

@endsection