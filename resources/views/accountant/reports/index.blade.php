@extends('layouts.accountant')

@section('content')

<div class="p-6">

<h2 class="text-2xl font-bold mb-4">📊 Financial Report</h2>

<!-- FILTER -->
<form class="flex gap-3 mb-4">
    <input type="date" name="from" value="{{ $from }}" class="border p-2">
    <input type="date" name="to" value="{{ $to }}" class="border p-2">

    <button class="bg-blue-500 text-white px-4">Filter</button>
</form>

<!-- CARDS -->
<div class="grid md:grid-cols-3 gap-4 mb-6">

    <div class="bg-green-500 text-white p-5 rounded">
        Total Fees: ₹ {{ $totalFees }}
    </div>

    <div class="bg-red-500 text-white p-5 rounded">
        Expenses: ₹ {{ $totalExpenses }}
    </div>

    <div class="bg-purple-500 text-white p-5 rounded">
        Profit: ₹ {{ $profit }}
    </div>

</div>

<!-- CHART -->
<canvas id="chart"></canvas>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
fetch("{{ route('accountant.reports.chart') }}")
.then(res => res.json())
.then(data => {

    new Chart(document.getElementById('chart'), {
        type: 'bar',
        data: {
            labels: Object.keys(data.fees),
            datasets: [
                {
                    label: 'Fees',
                    data: Object.values(data.fees),
                },
                {
                    label: 'Expenses',
                    data: Object.values(data.expenses),
                }
            ]
        }
    });

});
</script>

@endsection