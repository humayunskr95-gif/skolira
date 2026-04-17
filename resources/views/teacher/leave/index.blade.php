@extends('layouts.teacher')

@section('content')

<div class="p-4 md:p-6">

<!-- HEADER -->
<h2 class="text-xl font-bold mb-4">📄 My Leave</h2>

<!-- SUCCESS -->
@if(session('success'))
<div class="bg-green-100 text-green-700 p-3 rounded mb-4">
    {{ session('success') }}
</div>
@endif

<!-- APPLY FORM -->
<div class="bg-white p-4 rounded shadow mb-6">

    <h3 class="font-semibold mb-3">➕ Apply Leave</h3>

    <form method="POST" action="{{ route('teacher.leave.store') }}">
        @csrf

        <div class="grid md:grid-cols-3 gap-3">

            <input type="date" name="from_date"
                   class="border p-2 rounded" required>

            <input type="date" name="to_date"
                   class="border p-2 rounded" required>

            <input type="text" name="reason"
                   placeholder="Reason"
                   class="border p-2 rounded" required>

        </div>

        <button class="mt-3 bg-indigo-500 text-white px-4 py-2 rounded">
            Submit
        </button>

    </form>

</div>

<!-- LEAVE LIST -->
<div class="bg-white shadow rounded-lg overflow-hidden">

<table class="w-full text-sm">

    <thead class="bg-gray-100">
        <tr>
            <th class="p-3">#</th>
            <th class="p-3">From</th>
            <th class="p-3">To</th>
            <th class="p-3">Reason</th>
            <th class="p-3">Status</th>
        </tr>
    </thead>

    <tbody>
        @forelse($leaves as $leave)
        <tr class="border-t text-center">

            <td>{{ $loop->iteration }}</td>

            <td>{{ $leave->from_date }}</td>

            <td>{{ $leave->to_date }}</td>

            <td>{{ $leave->reason }}</td>

            <td>
                <span class="px-2 py-1 rounded text-white text-xs
                    {{ $leave->status == 'approved' ? 'bg-green-500' :
                       ($leave->status == 'rejected' ? 'bg-red-500' : 'bg-yellow-500') }}">
                    {{ ucfirst($leave->status) }}
                </span>
            </td>

        </tr>
        @empty
        <tr>
            <td colspan="5" class="text-center p-4 text-gray-500">
                No Leave Found 😔
            </td>
        </tr>
        @endforelse
    </tbody>

</table>

</div>

</div>

@endsection