@extends('layouts.school_admin')

@section('content')

<div class="p-6 max-w-2xl mx-auto">

    <h2 class="text-xl font-bold mb-4">
        👨‍🏫 Assign Teacher - {{ $subject->name }}
    </h2>

    <div class="bg-white p-6 rounded-2xl shadow">

        <form method="POST"
              action="{{ route('school_admin.subjects.assign.store',$subject->id) }}">
            @csrf

            <label class="block mb-2 font-medium">Select Teachers</label>

            <select name="teacher_ids[]" multiple class="input h-40">

                @foreach($teachers as $t)
                    <option value="{{ $t->id }}"
                        {{ $subject->teachers->contains($t->id) ? 'selected' : '' }}>
                        {{ $t->name }}
                    </option>
                @endforeach

            </select>

            <button class="mt-4 bg-indigo-600 text-white px-4 py-2 rounded">
                Save Assignment
            </button>

        </form>

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

@endsection