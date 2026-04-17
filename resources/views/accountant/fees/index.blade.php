@extends('layouts.accountant')

@section('content')

<div class="p-6">

    <div class="flex justify-between mb-4">
        <h2 class="text-2xl font-bold">💰 Fees List</h2>

        <a href="{{ route('accountant.fees.create') }}"
           class="bg-green-500 text-white px-4 py-2 rounded-lg shadow">
            ➕ Add Fee
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white shadow rounded-xl overflow-x-auto">

        <table class="w-full">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3 text-left">Student</th>
                    <th class="p-3">Amount</th>
                    <th class="p-3">Date</th>
                    <th class="p-3">Method</th>
                    <th class="p-3">Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse($fees as $fee)
                <tr class="border-b">
                    <td class="p-3">
                        {{ $fee->student->name ?? 'N/A' }}
                    </td>
                    <td class="p-3">₹ {{ $fee->amount }}</td>
                    <td class="p-3">{{ $fee->date }}</td>
                    <td class="p-3">{{ $fee->method }}</td>

                    <td class="p-3 flex gap-2">

                        <a href="{{ route('accountant.fees.edit',$fee->id) }}"
                           class="bg-blue-500 text-white px-2 py-1 rounded">
                           ✏️
                        </a>

                        <form method="POST"
                              action="{{ route('accountant.fees.destroy',$fee->id) }}">
                            @csrf
                            @method('DELETE')

                            <button class="bg-red-500 text-white px-2 py-1 rounded">
                                🗑
                            </button>
                        </form>

                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center p-4 text-gray-500">
                        No Fees Found ❌
                    </td>
                </tr>
                @endforelse
            </tbody>

        </table>

    </div>

</div>

@endsection