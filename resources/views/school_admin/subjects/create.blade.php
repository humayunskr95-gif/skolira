@extends('layouts.school_admin')

@section('content')

<div class="p-6 max-w-2xl mx-auto">

    <!-- 🔥 HEADER -->
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">📘 Add Subject</h2>

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

    <!-- 🎯 FORM CARD -->
    <div class="bg-white shadow-xl rounded-2xl p-6 md:p-8">

        <form method="POST" action="{{ route('school_admin.subjects.store') }}">
            @csrf

            <!-- 🎓 CLASS -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-600 mb-1">
                    Select Class
                </label>

                <select name="class_id" class="input" required>
                    <option value="">Choose Class</option>
                    @foreach($classes as $c)
                        <option value="{{ $c->id }}">
                            {{ $c->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- 📘 SUBJECT -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-600 mb-1">
                    Subject Name
                </label>

                <input name="name"
                       placeholder="Enter subject name"
                       class="input"
                       required>
            </div>

            <!-- 🚀 SUBMIT -->
            <div class="flex justify-end mt-6">
                <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg shadow">
                    💾 Save Subject
                </button>
            </div>

        </form>

    </div>

</div>

<!-- 🎨 INPUT STYLE -->
<style>
.input {
    width: 100%;
    padding: 12px;
    border-radius: 10px;
    border: 1px solid #ddd;
    transition: 0.2s;
}
.input:focus {
    outline: none;
    border-color: #6366f1;
    box-shadow: 0 0 0 2px rgba(99,102,241,0.2);
}
</style>

@endsection