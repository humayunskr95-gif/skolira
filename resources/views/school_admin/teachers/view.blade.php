@extends('layouts.school_admin')

@section('content')

<div class="p-4 md:p-6 max-w-5xl mx-auto">

    <!-- 🔙 BACK -->
    <div class="mb-4">
        <a href="{{ route('school_admin.teachers.index') }}"
           class="text-indigo-600 hover:underline">
            ← Back to Teachers
        </a>
    </div>

    <!-- 👨‍🏫 CARD -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">

        <!-- HEADER -->
        <div class="bg-indigo-600 text-white p-6 flex flex-col md:flex-row md:items-center gap-4">

            <!-- PHOTO -->
            <div>
                @if($teacher->photo)
                    <img src="{{ asset('storage/'.$teacher->photo) }}"
                         class="w-24 h-24 rounded-full object-cover border-4 border-white">
                @else
                    <div class="w-24 h-24 rounded-full bg-white text-indigo-600 flex items-center justify-center text-3xl font-bold">
                        {{ strtoupper(substr($teacher->name,0,1)) }}
                    </div>
                @endif
            </div>

            <!-- BASIC INFO -->
            <div>
                <h2 class="text-2xl font-bold">{{ $teacher->name }}</h2>
                <p class="text-sm opacity-90">{{ $teacher->email }}</p>

                <div class="mt-2 flex gap-2 flex-wrap">
                    <span class="bg-white text-indigo-600 px-3 py-1 rounded text-xs">
                        Code: {{ $teacher->teacher_code ?? 'N/A' }}
                    </span>

                    <span class="px-3 py-1 rounded text-xs
                        {{ $teacher->is_active ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800' }}">
                        {{ $teacher->is_active ? 'Active' : 'Blocked' }}
                    </span>
                </div>
            </div>

        </div>

        <!-- DETAILS -->
        <div class="p-6 grid md:grid-cols-2 gap-6">

            <!-- PERSONAL -->
            <div class="bg-gray-50 p-4 rounded-xl shadow-sm">
                <h3 class="font-semibold mb-3 text-gray-700">👤 Personal Info</h3>

                <div class="space-y-2 text-sm">
                    <p><strong>Father Name:</strong> {{ $teacher->father_name ?? '-' }}</p>
                    <p><strong>Gender:</strong> {{ ucfirst($teacher->gender) ?? '-' }}</p>
                    <p><strong>DOB:</strong> {{ $teacher->dob ?? '-' }}</p>
                </div>
            </div>

            <!-- CONTACT -->
            <div class="bg-gray-50 p-4 rounded-xl shadow-sm">
                <h3 class="font-semibold mb-3 text-gray-700">📞 Contact Info</h3>

                <div class="space-y-2 text-sm">
                    <p><strong>Mobile:</strong> {{ $teacher->mobile ?? '-' }}</p>
                    <p><strong>Email:</strong> {{ $teacher->email }}</p>
                </div>
            </div>

            <!-- ADDRESS -->
            <div class="bg-gray-50 p-4 rounded-xl shadow-sm md:col-span-2">
                <h3 class="font-semibold mb-3 text-gray-700">📍 Address</h3>

                <div class="grid md:grid-cols-2 gap-3 text-sm">

                    <p><strong>Address 1:</strong> {{ $teacher->address1 ?? '-' }}</p>
                    <p><strong>Address 2:</strong> {{ $teacher->address2 ?? '-' }}</p>

                    <p><strong>State:</strong> {{ $teacher->state ?? '-' }}</p>
                    <p><strong>District:</strong> {{ $teacher->district ?? '-' }}</p>

                    <p><strong>Block:</strong> {{ $teacher->block ?? '-' }}</p>
                    <p><strong>City:</strong> {{ $teacher->city ?? '-' }}</p>

                    <p><strong>PIN:</strong> {{ $teacher->pin ?? '-' }}</p>

                </div>
            </div>

        </div>

        <!-- ACTION -->
        <div class="p-6 border-t flex justify-end gap-3">

            <a href="{{ route('school_admin.teachers.edit',$teacher->id) }}"
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                ✏️ Edit
            </a>

            <form method="POST"
                  action="{{ route('school_admin.teachers.delete',$teacher->id) }}">
                @csrf
                @method('DELETE')

                <button onclick="return confirm('Delete this teacher?')"
                        class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg">
                    🗑 Delete
                </button>
            </form>

        </div>

    </div>

</div>

@endsection