@extends('layouts.school_admin')

@section('content')

<div class="p-6">

    <!-- HEADER -->
    <div class="flex justify-between mb-6">
        <h2 class="text-2xl font-bold">💰 Fees Management</h2>

        <a href="{{ route('school_admin.fees.create') }}"
           class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded shadow">
           ➕ Add Fee
        </a>
    </div>

    <!-- SUMMARY -->
    <div class="grid grid-cols-4 gap-4 mb-6">
        <div class="bg-green-100 p-4 rounded shadow">
            <h4 class="text-sm">Today</h4>
            <b class="text-lg">₹ {{ $summary['today'] }}</b>
        </div>

        <div class="bg-blue-100 p-4 rounded shadow">
            <h4 class="text-sm">This Month</h4>
            <b class="text-lg">₹ {{ $summary['month'] }}</b>
        </div>

        <div class="bg-purple-100 p-4 rounded shadow">
            <h4 class="text-sm">This Year</h4>
            <b class="text-lg">₹ {{ $summary['year'] }}</b>
        </div>

        <div class="bg-yellow-100 p-4 rounded shadow">
            <h4 class="text-sm">Total Records</h4>
            <b class="text-lg">{{ $fees->total() }}</b>
        </div>
    </div>

    <!-- FILTER -->
    <form method="GET" class="flex gap-2 mb-4">

        <select name="student_id" class="border p-2 rounded">
            <option value="">All Students</option>
            @foreach($students as $s)
                <option value="{{ $s->id }}"
                    {{ request('student_id') == $s->id ? 'selected' : '' }}>
                    {{ $s->name }}
                </option>
            @endforeach
        </select>

        <input type="date" name="date" value="{{ request('date') }}"
               class="border p-2 rounded">

        <select name="month" class="border p-2 rounded">
            <option value="">Month</option>
            @for($i=1;$i<=12;$i++)
                <option value="{{ $i }}"
                    {{ request('month')==$i ? 'selected':'' }}>
                    {{ $i }}
                </option>
            @endfor
        </select>

        <input type="number" name="year" value="{{ request('year') }}"
               placeholder="Year" class="border p-2 rounded">

        <button class="bg-gray-800 text-white px-4 rounded hover:bg-black">
            🔍
        </button>
    </form>

    <!-- TABLE -->
    <div class="bg-white shadow rounded overflow-hidden">

        <table class="w-full text-sm">
            <thead class="bg-gray-100 text-gray-600">
                <tr>
                    <th>#</th>
                    <th>Student</th>
                    <th>Class</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>⚙</th>
                </tr>
            </thead>

            <tbody>
            @forelse($fees as $f)
                <tr class="border-t hover:bg-gray-50">

                    <td class="p-2">{{ $loop->iteration }}</td>

                    <td>{{ $f->student->name ?? '-' }}</td>

                    <td>{{ $f->class->name ?? '-' }}</td>

                    <!-- 💰 AMOUNT + DUE -->
                    <td>
                        ₹ {{ $f->amount }} <br>

                        <span class="text-green-600 text-xs">
                            Paid: ₹ {{ $f->paid_amount }}
                        </span><br>

                        <span class="text-red-600 text-xs">
                            Due: ₹ {{ $f->amount - $f->paid_amount }}
                        </span>
                    </td>

                    <!-- STATUS -->
                    <td>
                        @if($f->status == 'paid')
                            <span class="text-green-600 font-semibold">Paid</span>
                        @elseif($f->status == 'partial')
                            <span class="text-yellow-600 font-semibold">Partial</span>
                        @else
                            <span class="text-red-600 font-semibold">Due</span>
                        @endif
                    </td>

                    <td>{{ $f->date }}</td>

                    <!-- ACTION -->
                    <td class="flex gap-2">

                        <a href="{{ route('school_admin.fees.edit',$f->id) }}"
                           class="text-blue-600">✏️</a>

                        <!-- PDF -->
                        <a href="{{ route('school_admin.fees.invoice',$f->id) }}"
                           class="text-green-600">📄</a>

                        <!-- DELETE -->
                        <form method="POST"
                              action="{{ route('school_admin.fees.delete',$f->id) }}">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-600">🗑</button>
                        </form>

                    </td>

                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center p-4 text-gray-500">
                        No Data 😔
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>

    </div>

    <!-- PAGINATION -->
    <div class="mt-4">
        {{ $fees->links() }}
    </div>

</div>

@endsection