@extends('layouts.school_admin')

@section('content')

<div class="p-6">

    <!-- 🔥 Header -->
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">📊 Student Results</h2>
    </div>

    <!-- 🎯 FILTER CARD -->
    <div class="bg-white shadow-lg rounded-2xl p-5 mb-6">

        <form method="GET" class="grid md:grid-cols-4 gap-4">

            <!-- Class -->
            <select name="class_id" id="class" class="input">
                <option value="">🎓 Select Class</option>
                @foreach($classes as $class)
                    <option value="{{ $class->id }}"
                        {{ request('class_id') == $class->id ? 'selected' : '' }}>
                        {{ $class->name }}
                    </option>
                @endforeach
            </select>

            <!-- Section -->
            <select name="section_id" id="section" class="input">
                <option value="">📚 Select Section</option>
            </select>

            <!-- Button -->
            <button class="bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg px-4 py-2">
                🔍 View Students
            </button>

        </form>

    </div>

    <!-- 📋 STUDENT TABLE -->
    <div class="bg-white shadow-lg rounded-2xl overflow-hidden">

        <table class="w-full text-sm">

            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="p-3 text-left">#</th>
                    <th class="p-3 text-left">Roll</th>
                    <th class="p-3 text-left">Name</th>
                    <th class="p-3 text-center">Action</th>
                </tr>
            </thead>

            <tbody>

            @forelse($students as $index => $s)
                <tr class="border-t hover:bg-gray-50 transition">

                    <td class="p-3">{{ $index + 1 }}</td>

                    <td class="p-3 font-semibold text-indigo-600">
                        {{ $s->roll }}
                    </td>

                    <td class="p-3">
                        {{ $s->name }}
                    </td>

                    <td class="p-3 text-center">
                        <a href="{{ route('school_admin.results.show',$s->id) }}"
                           class="bg-indigo-100 text-indigo-700 px-3 py-1 rounded-lg hover:bg-indigo-200">
                            📄 View
                        </a>
                    </td>

                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center p-6 text-gray-500">
                        🚫 No students found
                    </td>
                </tr>
            @endforelse

            </tbody>

        </table>

    </div>

</div>

<!-- 🎨 INPUT STYLE -->
<style>
.input {
    width: 100%;
    padding: 10px;
    border-radius: 10px;
    border: 1px solid #ddd;
}
.input:focus {
    outline: none;
    border-color: #6366f1;
    box-shadow: 0 0 0 1px #6366f1;
}
</style>

<!-- ⚡ DYNAMIC SECTION LOAD -->
<script>
document.getElementById('class').addEventListener('change', function () {

    let classId = this.value;
    let section = document.getElementById('section');

    if(!classId){
        section.innerHTML = '<option value="">📚 Select Section</option>';
        return;
    }

    fetch("{{ route('school_admin.get.sections', ':id') }}".replace(':id', classId))
        .then(res => res.json())
        .then(data => {

            section.innerHTML = '<option value="">📚 Select Section</option>';

            data.forEach(sec => {
                section.innerHTML += `<option value="${sec.id}">
                                        ${sec.name}
                                      </option>`;
            });

        });

});
</script>

@endsection