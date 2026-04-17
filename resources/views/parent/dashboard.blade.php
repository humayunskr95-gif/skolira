@extends('layouts.parent')

@section('content')

<div class="p-6">

<h2 class="text-2xl font-bold mb-6">👨‍👩‍👧 Parent Dashboard</h2>

<div class="grid md:grid-cols-2 lg:grid-cols-3 gap-5">

@forelse($children as $child)
<div class="bg-white p-5 rounded-xl shadow hover:shadow-lg transition">

    <!-- 👤 Name -->
    <h3 class="font-bold text-lg text-gray-800">
        {{ $child->name }}
    </h3>

    <!-- 📚 Class -->
    <p class="text-sm text-gray-500 mt-1">
        Class: {{ $child->class->name ?? '-' }}
    </p>

    <!-- 🎯 Buttons -->
    <div class="mt-4 flex gap-2 flex-wrap">

        <a href="{{ route('parent.attendance',$child->id) }}"
           class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-sm">
           📊 Attendance
        </a>

        <a href="{{ route('parent.results',$child->id) }}"
           class="bg-purple-500 hover:bg-purple-600 text-white px-3 py-1 rounded text-sm">
           📄 Results
        </a>

        <a href="{{ route('parent.homework',$child->id) }}"
           class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm">
           📚 Homework
        </a>

    </div>

</div>

@empty
<div class="col-span-full text-center text-gray-500 py-10">
    ❌ No children found
</div>
@endforelse

</div>

</div>

@endsection