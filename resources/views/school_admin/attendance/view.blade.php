@extends('layouts.school_admin')

@section('content')

<div class="p-6">

    <!-- HEADER -->
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">📊 Attendance Report</h2>

        <a href="{{ route('school_admin.attendance.export', request()->all()) }}"
           class="bg-green-600 text-white px-4 py-2 rounded-lg shadow hover:bg-green-700">
            📥 Export
        </a>
    </div>

    <!-- FILTER -->
    <div class="bg-white p-4 rounded-xl shadow mb-6">

        <form method="GET" class="grid md:grid-cols-4 gap-4">

            <select name="class_id" id="class" class="input">
                <option value="">Select Class</option>
                @foreach($classes as $class)
                    <option value="{{ $class->id }}" 
                        {{ request('class_id') == $class->id ? 'selected' : '' }}>
                        {{ $class->name }}
                    </option>
                @endforeach
            </select>

            <select name="section_id" id="section" class="input">
                <option value="">Select Section</option>
            </select>

            <input type="date" name="date" class="input"
                   value="{{ request('date') }}">

            <button class="bg-indigo-600 text-white rounded-lg">
                🔍 View
            </button>

        </form>
    </div>

    <!-- GRID -->
    <div class="grid md:grid-cols-3 gap-6">

        <!-- CHART -->
        <div class="bg-white p-4 rounded-xl shadow">
            <h3 class="font-semibold mb-3">📊 Summary</h3>
            <canvas id="attendanceChart" height="200"></canvas>
        </div>

        <!-- TABLE -->
        <div class="bg-white rounded-xl shadow col-span-2 overflow-hidden">

            <table class="w-full">

                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-3 text-left">Roll</th>
                        <th class="p-3 text-left">Name</th>
                        <th class="p-3 text-left">Status</th>
                    </tr>
                </thead>

                <tbody>

                @forelse($students as $s)

                    <tr class="border-t hover:bg-gray-50">

                        <td class="p-3 font-semibold">
                            {{ $s->roll ?? '-' }}
                        </td>

                        <td class="p-3">
                            {{ $s->name }}
                        </td>

                        <td class="p-3">
                            @if($s->status == 'present')
                                <span class="px-3 py-1 text-sm bg-green-100 text-green-700 rounded-full">
                                    ✅ Present
                                </span>
                            @else
                                <span class="px-3 py-1 text-sm bg-red-100 text-red-700 rounded-full">
                                    ❌ Absent
                                </span>
                            @endif
                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="3" class="text-center p-6 text-gray-500">
                            No students found
                        </td>
                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

<style>
.input {
    width:100%;
    padding:10px;
    border-radius:8px;
    border:1px solid #ddd;
}
</style>

<!-- SECTION LOAD -->
<script>
document.getElementById('class').addEventListener('change', function () {

    let classId = this.value;
    let section = document.getElementById('section');

    fetch(`/school-admin/get-sections/${classId}`)
        .then(res => res.json())
        .then(data => {

            section.innerHTML = '<option value="">Select Section</option>';

            data.forEach(sec => {
                section.innerHTML += `<option value="${sec.id}">${sec.name}</option>`;
            });

        });

});
</script>

<!-- CHART -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
let classId = "{{ request('class_id') }}";
let sectionId = "{{ request('section_id') }}";
let date = "{{ request('date') }}";

if(classId && date){

fetch(`/school-admin/attendance/chart?class_id=${classId}&section_id=${sectionId}&date=${date}`)
.then(res => res.json())
.then(data => {

    new Chart(document.getElementById('attendanceChart'), {
        type: 'doughnut',
        data: {
            labels: ['Present','Absent'],
            datasets: [{
                data: [data.present, data.absent],
                backgroundColor: ['#22c55e','#ef4444']
            }]
        }
    });

});
}
</script>

@endsection