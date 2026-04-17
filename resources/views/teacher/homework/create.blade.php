@extends('layouts.teacher')

@section('content')

<div class="p-4 md:p-6 max-w-xl mx-auto">

    <h2 class="text-xl font-bold mb-4">➕ Add Homework</h2>

    <form method="POST" action="{{ route('teacher.homework.store') }}">
    @csrf

    <!-- CLASS -->
    <div class="mb-3">
        <label>Class</label>
        <select id="class_id" name="class_id" class="w-full border p-2 rounded" required>
            <option value="">Select Class</option>
            @foreach($classes as $class)
                <option value="{{ $class->id }}">{{ $class->name }}</option>
            @endforeach
        </select>
    </div>

    <!-- SECTION -->
    <div class="mb-3">
        <label>Section</label>
        <select id="section_id" name="section_id" class="w-full border p-2 rounded" required>
            <option value="">Select Section</option>
        </select>
    </div>

    <!-- SUBJECT -->
    <div class="mb-3">
        <label>Subject</label>
        <select id="subject_id" name="subject_id" class="w-full border p-2 rounded" required>
            <option value="">Select Subject</option>
        </select>
    </div>

    <!-- TITLE -->
    <div class="mb-3">
        <label>Title</label>
        <input type="text" name="title" class="w-full border p-2 rounded" required>
    </div>

    <!-- DESCRIPTION -->
    <div class="mb-3">
        <label>Description</label>
        <textarea name="description" class="w-full border p-2 rounded" required></textarea>
    </div>

    <!-- DATE -->
    <div class="mb-3">
        <label>Due Date</label>
        <input type="date" name="due_date" class="w-full border p-2 rounded" required>
    </div>

    <button class="bg-green-500 text-white px-4 py-2 rounded">
        Save Homework
    </button>

    </form>
</div>

{{-- 🔥 DIRECT SCRIPT (NO SECTION) --}}
<script>

document.addEventListener('DOMContentLoaded', function(){

    console.log('JS WORKING ✅'); // debug

    const classSelect = document.getElementById('class_id');

    classSelect.addEventListener('change', function(){

        let classId = this.value;

        if(!classId) return;

        // SECTION LOAD
        fetch(`/teacher/get-sections/${classId}`)
        .then(res => res.json())
        .then(data => {

            console.log('Sections:', data);

            let section = document.getElementById('section_id');
            section.innerHTML = '<option value="">Select Section</option>';

            if(data.length === 0){
                section.innerHTML += `<option disabled>No Section Found</option>`;
            }

            data.forEach(item => {
                section.innerHTML += `<option value="${item.id}">${item.name}</option>`;
            });

        })
        .catch(err => console.error(err));


        // SUBJECT LOAD
        fetch(`/teacher/get-subjects/${classId}`)
        .then(res => res.json())
        .then(data => {

            console.log('Subjects:', data);

            let subject = document.getElementById('subject_id');
            subject.innerHTML = '<option value="">Select Subject</option>';

            data.forEach(item => {
                subject.innerHTML += `<option value="${item.id}">${item.name}</option>`;
            });

        })
        .catch(err => console.error(err));

    });

});
</script>

@endsection