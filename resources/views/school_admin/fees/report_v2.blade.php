@extends('layouts.school_admin')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-3 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Fees Report</h1>
            <p class="text-sm text-gray-500">Select a class first, then view paid fees, dues, expenses and final bill.</p>
        </div>

        <div class="rounded-2xl bg-white px-4 py-3 text-sm text-gray-600 shadow-sm ring-1 ring-gray-100">
            Report Range: <span class="font-semibold text-gray-900">{{ \Carbon\Carbon::parse($from)->format('d M Y') }}</span>
            to
            <span class="font-semibold text-gray-900">{{ \Carbon\Carbon::parse($to)->format('d M Y') }}</span>
        </div>
    </div>

    <form method="GET" action="{{ route('school_admin.fees.report') }}"
          class="grid grid-cols-1 gap-4 rounded-3xl bg-white p-5 shadow-sm ring-1 ring-gray-100 md:grid-cols-2 xl:grid-cols-5">
        <div>
            <label class="mb-2 block text-sm font-medium text-gray-700">Class</label>
            <select name="class_id" class="w-full rounded-2xl border border-gray-200 px-4 py-3 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-100">
                <option value="">All Classes</option>
                @foreach($classes as $class)
                    <option value="{{ $class->id }}" {{ (string) $classId === (string) $class->id ? 'selected' : '' }}>
                        {{ $class->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="mb-2 block text-sm font-medium text-gray-700">From Date</label>
            <input type="date" name="from" value="{{ $from }}"
                   class="w-full rounded-2xl border border-gray-200 px-4 py-3 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-100">
        </div>

        <div>
            <label class="mb-2 block text-sm font-medium text-gray-700">To Date</label>
            <input type="date" name="to" value="{{ $to }}"
                   class="w-full rounded-2xl border border-gray-200 px-4 py-3 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-100">
        </div>

        <div class="flex items-end">
            <button type="submit"
                    class="w-full rounded-2xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-indigo-700">
                Show Report
            </button>
        </div>

        <div class="flex items-end">
            <a href="{{ route('school_admin.fees.report.export', ['class_id' => $classId, 'from' => $from, 'to' => $to, 'export_type' => 'paid']) }}"
               class="w-full rounded-2xl bg-emerald-600 px-5 py-3 text-center text-sm font-semibold text-white transition hover:bg-emerald-700">
                Paid PDF
            </a>
        </div>
    </form>

    <div class="grid grid-cols-1 gap-3 md:grid-cols-3">
        <a href="{{ route('school_admin.fees.report.export', ['class_id' => $classId, 'from' => $from, 'to' => $to, 'export_type' => 'due']) }}"
           class="rounded-2xl bg-rose-600 px-5 py-3 text-center text-sm font-semibold text-white transition hover:bg-rose-700">
            Due PDF
        </a>
        <a href="{{ route('school_admin.fees.report.export', ['class_id' => $classId, 'from' => $from, 'to' => $to, 'export_type' => 'final']) }}"
           class="rounded-2xl bg-slate-900 px-5 py-3 text-center text-sm font-semibold text-white transition hover:bg-slate-800">
            Final Bill PDF
        </a>
        <div class="rounded-2xl border border-gray-200 bg-white px-5 py-3 text-center text-sm text-gray-600">
            Paid বা Due export এ expenses যাবে না. Final Bill export এ expenses minus হবে.
        </div>
    </div>

    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-5">
        <div class="rounded-3xl bg-gradient-to-br from-slate-900 to-slate-700 p-5 text-white shadow-lg">
            <p class="text-sm text-slate-200">Selected Class</p>
            <h3 class="mt-2 text-xl font-bold">{{ $selectedClass?->name ?? 'All Classes' }}</h3>
        </div>

        <div class="rounded-3xl bg-gradient-to-br from-blue-500 to-blue-600 p-5 text-white shadow-lg">
            <p class="text-sm text-blue-100">Total Fees</p>
            <h3 class="mt-2 text-2xl font-bold">Rs {{ number_format($total, 2) }}</h3>
        </div>

        <div class="rounded-3xl bg-gradient-to-br from-green-500 to-green-600 p-5 text-white shadow-lg">
            <p class="text-sm text-green-100">Paid Fees</p>
            <h3 class="mt-2 text-2xl font-bold">Rs {{ number_format($paid, 2) }}</h3>
        </div>

        <div class="rounded-3xl bg-gradient-to-br from-rose-500 to-rose-600 p-5 text-white shadow-lg">
            <p class="text-sm text-rose-100">Due Fees</p>
            <h3 class="mt-2 text-2xl font-bold">Rs {{ number_format($due, 2) }}</h3>
        </div>

        <div class="rounded-3xl bg-gradient-to-br from-amber-400 to-orange-500 p-5 text-white shadow-lg">
            <p class="text-sm text-amber-100">Expenses</p>
            <h3 class="mt-2 text-2xl font-bold">Rs {{ number_format($expense, 2) }}</h3>
        </div>
    </div>

    <div class="rounded-3xl border border-indigo-100 bg-indigo-50 p-5 shadow-sm">
        <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
            <div>
                <p class="text-sm font-medium text-indigo-700">Final Bill</p>
                <h2 class="mt-1 text-3xl font-bold text-indigo-900">Rs {{ number_format($netBalance, 2) }}</h2>
            </div>
            <div class="text-sm text-indigo-800">Formula: Paid Fees - Expenses = Final Bill</div>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
        <div class="rounded-3xl bg-white shadow-sm ring-1 ring-gray-100 xl:col-span-2">
            <div class="flex items-center justify-between border-b border-gray-100 px-5 py-4">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Student Fees Details</h3>
                    <p class="text-sm text-gray-500">Student name, class, fee, paid amount, due amount and status.</p>
                </div>
                <span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-600">{{ $fees->count() }} Records</span>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-gray-50 text-gray-600">
                        <tr>
                            <th class="px-5 py-3 text-left font-semibold">Student</th>
                            <th class="px-5 py-3 text-left font-semibold">Class</th>
                            <th class="px-5 py-3 text-left font-semibold">Date</th>
                            <th class="px-5 py-3 text-left font-semibold">Total Fee</th>
                            <th class="px-5 py-3 text-left font-semibold">Paid</th>
                            <th class="px-5 py-3 text-left font-semibold">Due</th>
                            <th class="px-5 py-3 text-left font-semibold">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($fees as $fee)
                            <tr class="hover:bg-gray-50">
                                <td class="px-5 py-4 font-medium text-gray-900">{{ $fee->resolved_student_name }}</td>
                                <td class="px-5 py-4 text-gray-600">{{ $fee->class->name ?? ('Class ' . ($fee->class_id ?? 'N/A')) }}</td>
                                <td class="px-5 py-4 text-gray-600">{{ optional($fee->date)->format('d M Y') }}</td>
                                <td class="px-5 py-4 text-gray-900">Rs {{ number_format($fee->calculated_amount, 2) }}</td>
                                <td class="px-5 py-4 text-green-700 font-semibold">Rs {{ number_format($fee->calculated_paid_amount, 2) }}</td>
                                <td class="px-5 py-4 text-rose-700 font-semibold">Rs {{ number_format($fee->calculated_due_amount, 2) }}</td>
                                <td class="px-5 py-4">
                                    <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $fee->calculated_status === 'paid' ? 'bg-green-100 text-green-700' : ($fee->calculated_status === 'partial' ? 'bg-amber-100 text-amber-700' : 'bg-rose-100 text-rose-700') }}">
                                        {{ ucfirst($fee->calculated_status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-5 py-8 text-center text-gray-500">No fees found for this class and date range.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="space-y-6">
            <div class="rounded-3xl bg-white shadow-sm ring-1 ring-gray-100">
                <div class="border-b border-gray-100 px-5 py-4">
                    <h3 class="text-lg font-semibold text-gray-900">Class Wise Summary</h3>
                </div>
                <div class="space-y-3 p-5">
                    @forelse($classWise as $row)
                        <div class="rounded-2xl bg-gray-50 p-4">
                            <div class="flex items-center justify-between">
                                <h4 class="font-semibold text-gray-900">{{ $row['class_name'] }}</h4>
                                <span class="text-xs text-gray-500">{{ $row['students'] }} Records</span>
                            </div>
                            <div class="mt-3 grid grid-cols-3 gap-2 text-xs">
                                <div>
                                    <p class="text-gray-500">Total</p>
                                    <p class="font-semibold text-gray-900">Rs {{ number_format($row['total'], 2) }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500">Paid</p>
                                    <p class="font-semibold text-green-700">Rs {{ number_format($row['paid'], 2) }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500">Due</p>
                                    <p class="font-semibold text-rose-700">Rs {{ number_format($row['due'], 2) }}</p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500">No class summary available.</p>
                    @endforelse
                </div>
            </div>

            <div class="rounded-3xl bg-white shadow-sm ring-1 ring-gray-100">
                <div class="flex items-center justify-between border-b border-gray-100 px-5 py-4">
                    <h3 class="text-lg font-semibold text-gray-900">Expense Details</h3>
                    <span class="text-xs text-gray-500">{{ $expenses->count() }} Items</span>
                </div>
                <div class="space-y-3 p-5">
                    @forelse($expenses as $item)
                        <div class="rounded-2xl border border-gray-100 p-4">
                            <div class="flex items-start justify-between gap-3">
                                <div>
                                    <h4 class="font-semibold text-gray-900">{{ $item->title ?: 'Expense' }}</h4>
                                    <p class="mt-1 text-xs text-gray-500">{{ $item->date ? \Carbon\Carbon::parse($item->date)->format('d M Y') : 'No Date' }}</p>
                                </div>
                                <p class="font-semibold text-amber-700">Rs {{ number_format($item->amount, 2) }}</p>
                            </div>
                            @if($item->description)
                                <p class="mt-2 text-sm text-gray-600">{{ $item->description }}</p>
                            @endif
                        </div>
                    @empty
                        <p class="text-sm text-gray-500">No expense found in this period.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
