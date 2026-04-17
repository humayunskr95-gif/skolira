@extends('layouts.student')

@section('content')

<div class="p-3 md:p-6">

<!-- HEADER -->
<div class="flex flex-col md:flex-row justify-between md:items-center gap-3 mb-6">
    <h2 class="text-lg md:text-2xl font-bold">
        🎓 Student Dashboard
    </h2>

    <span class="bg-green-100 text-green-600 px-3 py-1 rounded text-xs md:text-sm w-fit">
        Active
    </span>
</div>

<!-- STUDENT INFO -->
<div class="bg-white p-4 rounded-xl shadow mb-6 text-sm md:text-base">
    <h3 class="font-semibold mb-2">👤 Student Info</h3>

    <p><b>Name:</b> {{ auth()->user()->name }}</p>
    <p><b>Class:</b> {{ $student->studentClass->name ?? 'N/A' }}</p>
    <p><b>Section:</b> {{ $student->studentSection->name ?? 'N/A' }}</p>
</div>

<!-- CARDS -->
<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mb-6">

    <div class="bg-gradient-to-r from-green-400 to-green-600 text-white p-4 rounded-xl shadow">
        <h4 class="text-xs md:text-sm">Attendance</h4>
        <b class="text-xl md:text-2xl">
            {{ $present ?? 0 }} / {{ $totalAttendance ?? 0 }}
        </b>
    </div>

    <div class="bg-gradient-to-r from-indigo-400 to-indigo-600 text-white p-4 rounded-xl shadow">
        <h4 class="text-xs md:text-sm">Subjects</h4>
        <b class="text-xl md:text-2xl">
            {{ $subjects->count() }}
        </b>
    </div>

    <div class="bg-gradient-to-r from-purple-400 to-purple-600 text-white p-4 rounded-xl shadow">
        <h4 class="text-xs md:text-sm">Performance</h4>
        <b class="text-xl md:text-2xl">
            {{ $avg ? number_format($avg,1) : '0' }}
        </b>
    </div>

</div>

<!-- CHARTS -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">

    <!-- Attendance -->
    <div class="bg-white p-4 rounded-xl shadow">
        <h3 class="font-semibold mb-2 text-sm md:text-base">📊 Attendance</h3>
        <div class="h-48 md:h-56">
            <canvas id="attendanceChart"></canvas>
        </div>
    </div>

    <!-- Fees -->
    <div class="bg-white p-4 rounded-xl shadow">
        <h3 class="font-semibold mb-2 text-sm md:text-base">💰 Fees</h3>
        <div class="h-48 md:h-56">
            <canvas id="feesChart"></canvas>
        </div>
    </div>

</div>

<!-- QUICK ACTION -->
<div class="bg-white p-4 rounded-xl shadow">

    <h3 class="font-semibold mb-3 text-sm md:text-base">⚡ Quick Access</h3>

    <div class="flex flex-wrap gap-2 md:gap-3">

        <a href="{{ route('student.subjects') }}"
           class="bg-indigo-500 text-white px-3 py-2 rounded text-xs md:text-sm">
           📚 Subjects
        </a>

        <a href="{{ route('student.attendance') }}"
           class="bg-green-500 text-white px-3 py-2 rounded text-xs md:text-sm">
           📝 Attendance
        </a>

        <a href="{{ route('student.results') }}"
           class="bg-purple-500 text-white px-3 py-2 rounded text-xs md:text-sm">
           📊 Results
        </a>

    </div>

</div>

</div>

<!-- CHART JS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

const present = {{ $present ?? 0 }};
const total = {{ $totalAttendance ?? 0 }};
const absent = total - present;

const paid = {{ $paid ?? 0 }};
const due  = {{ $due ?? 0 }};

// Attendance Chart
new Chart(document.getElementById('attendanceChart'), {
    type: 'pie',
    data: {
        labels: ['Present', 'Absent'],
        datasets: [{
            data: [present, absent],
            backgroundColor: ['#22c55e', '#ef4444']
        }]
    },
    options: {
        maintainAspectRatio: false,
        plugins: {
            legend: { position: 'bottom' }
        }
    }
});

// Fees Chart
new Chart(document.getElementById('feesChart'), {
    type: 'pie',
    data: {
        labels: ['Paid', 'Due'],
        datasets: [{
            data: [paid, due],
            backgroundColor: ['#3b82f6', '#f59e0b']
        }]
    },
    options: {
        maintainAspectRatio: false,
        plugins: {
            legend: { position: 'bottom' }
        }
    }
});

</script>

@endsection