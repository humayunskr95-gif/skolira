@extends('layouts.school_admin')

@section('content')

<div class="p-6 max-w-2xl mx-auto">

    <!-- 🔥 HEADER -->
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">✏️ Edit Subject</h2>

        <a href="{{ route('school_admin.subjects.index') }}"
           class="bg-gray-200 hover:bg-gray-300 px-4 py-2 rounded-lg">
            ← Back
        </a>
    </div>

    <!-- ❌ ERROR -->
    @if($errors->any())
        <div class="mb-4 bg-red-100 text-red-700 p-3 rounded-lg">
            @foreach($errors->all() as $error)
                <div>• {{ $error }}</div>
            @endforeach
        </div>
    @endif

    <!-- 🎯 FORM -->
    <div class="bg-white shadow-xl rounded-2xl p-6">

        <form method="POST" action="{{ route('school_admin.subjects.update', $subject->id) }}">
            @csrf
            @method('PUT')

            <!-- CLASS -->
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Class</label>

                <select name="class_id" class="input">
                    @foreach($classes as $c)
                        <option value="{{ $c->id }}"
                            {{ $subject->class_id == $c->id ? 'selected' : '' }}>
                            {{ $c->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- SUBJECT -->
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Subject Name</label>

                <input name="name"
                       value="{{ $subject->name }}"
                       class="input">
            </div>

            <!-- BUTTON -->
            <div class="flex justify-end mt-6">
                <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg">
                    💾 Update
                </button>
            </div>

        </form>

    </div>

</div>

<style>
.input {
    width:100%;
    padding:10px;
    border-radius:10px;
    border:1px solid #ddd;
}
.input:focus {
    outline:none;
    border-color:#6366f1;
}
</style>

@endsection