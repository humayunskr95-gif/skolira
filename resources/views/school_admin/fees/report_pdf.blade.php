<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Fees Report PDF</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; color: #111827; font-size: 12px; }
        .header { margin-bottom: 18px; }
        .title { font-size: 22px; font-weight: bold; margin-bottom: 6px; }
        .meta { font-size: 11px; color: #4b5563; }
        .cards { width: 100%; margin: 16px 0; border-collapse: separate; border-spacing: 10px 0; }
        .card { border: 1px solid #e5e7eb; padding: 10px; vertical-align: top; width: 20%; }
        .label { font-size: 10px; color: #6b7280; margin-bottom: 4px; }
        .value { font-size: 16px; font-weight: bold; }
        table.report { width: 100%; border-collapse: collapse; margin-top: 14px; }
        table.report th, table.report td { border: 1px solid #d1d5db; padding: 8px; text-align: left; }
        table.report th { background: #f3f4f6; }
        .section-title { font-size: 15px; font-weight: bold; margin-top: 22px; margin-bottom: 10px; }
        .totals { margin-top: 18px; padding: 12px; border: 1px solid #c7d2fe; background: #eef2ff; }
        .totals strong { font-size: 16px; }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">School Admin {{ ucfirst($exportType) }} Fees Report</div>
        <div class="meta">Class: {{ $selectedClass?->name ?? 'All Classes' }}</div>
        <div class="meta">Period: {{ \Carbon\Carbon::parse($from)->format('d M Y') }} to {{ \Carbon\Carbon::parse($to)->format('d M Y') }}</div>
        <div class="meta">Generated: {{ now()->format('d M Y h:i A') }}</div>
    </div>

    <table class="cards">
        <tr>
            <td class="card"><div class="label">Total Fees</div><div class="value">Rs {{ number_format($total, 2) }}</div></td>
            <td class="card"><div class="label">Paid Fees</div><div class="value">Rs {{ number_format($paid, 2) }}</div></td>
            <td class="card"><div class="label">Due Fees</div><div class="value">Rs {{ number_format($due, 2) }}</div></td>
            @if($exportType === 'final')
                <td class="card"><div class="label">Expenses</div><div class="value">Rs {{ number_format($expense, 2) }}</div></td>
                <td class="card"><div class="label">Final Bill</div><div class="value">Rs {{ number_format($netBalance, 2) }}</div></td>
            @else
                <td class="card"><div class="label">Export Type</div><div class="value">{{ ucfirst($exportType) }}</div></td>
                <td class="card"><div class="label">Records</div><div class="value">{{ $fees->count() }}</div></td>
            @endif
        </tr>
    </table>

    <div class="section-title">Student Fees</div>
    <table class="report">
        <thead>
            <tr>
                <th>Student Name</th>
                <th>Class</th>
                <th>Date</th>
                <th>Total Fee</th>
                <th>Paid</th>
                <th>Due</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($fees as $fee)
                <tr>
                    <td>{{ $fee->resolved_student_name }}</td>
                    <td>{{ $fee->class->name ?? ('Class ' . ($fee->class_id ?? 'N/A')) }}</td>
                    <td>{{ optional($fee->date)->format('d M Y') }}</td>
                    <td>Rs {{ number_format($fee->calculated_amount, 2) }}</td>
                    <td>Rs {{ number_format($fee->calculated_paid_amount, 2) }}</td>
                    <td>Rs {{ number_format($fee->calculated_due_amount, 2) }}</td>
                    <td>{{ ucfirst($fee->calculated_status) }}</td>
                </tr>
            @empty
                <tr><td colspan="7">No fee records found.</td></tr>
            @endforelse
        </tbody>
    </table>

    @if($exportType === 'final')
        <div class="section-title">Expenses</div>
        <table class="report">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Date</th>
                    <th>Description</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                @forelse($expenses as $item)
                    <tr>
                        <td>{{ $item->title ?: 'Expense' }}</td>
                        <td>{{ $item->date ? \Carbon\Carbon::parse($item->date)->format('d M Y') : 'No Date' }}</td>
                        <td>{{ $item->description ?: '-' }}</td>
                        <td>Rs {{ number_format($item->amount, 2) }}</td>
                    </tr>
                @empty
                    <tr><td colspan="4">No expense records found.</td></tr>
                @endforelse
            </tbody>
        </table>

        <div class="totals">
            <div>Total Paid Fees: <strong>Rs {{ number_format($paid, 2) }}</strong></div>
            <div>Total Expenses: <strong>Rs {{ number_format($expense, 2) }}</strong></div>
            <div>Final Bill (Paid Fees - Expenses): <strong>Rs {{ number_format($netBalance, 2) }}</strong></div>
        </div>
    @else
        <div class="totals">
            <div>Total Fees: <strong>Rs {{ number_format($total, 2) }}</strong></div>
            <div>Total Paid: <strong>Rs {{ number_format($paid, 2) }}</strong></div>
            <div>Total Due: <strong>Rs {{ number_format($due, 2) }}</strong></div>
        </div>
    @endif
</body>
</html>
