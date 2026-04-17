
@extends('layouts.school_admin')

@section('content')

<div class="p-4 md:p-6">

    <!-- 🔥 HEADER -->
    <div class="flex flex-col md:flex-row md:justify-between gap-4 mb-6">

        <h1 class="text-2xl font-bold text-gray-800">
            🎓 Students
        </h1>

        <div class="flex flex-wrap gap-2">

            <!-- Import -->
            <form action="{{ route('school_admin.students.import') }}"
                  method="POST" enctype="multipart/form-data"
                  class="flex items-center gap-2 bg-white p-2 rounded-xl shadow">
                @csrf
                <input type="file" name="file" class="text-xs w-32">
                <button class="bg-purple-600 hover:bg-purple-700 text-white px-3 py-2 rounded-lg text-sm">
                    ⬆
                </button>
            </form>

            <!-- Template -->
            <a href="{{ route('school_admin.students.template') }}"
               class="bg-gray-700 hover:bg-gray-800 text-white px-4 py-2 rounded-xl text-sm shadow">
                ⬇ Template
            </a>

            <!-- Export -->
            <a href="{{ route('school_admin.students.export') }}"
               class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-xl text-sm shadow">
                📥 Export
            </a>

            <!-- Add -->
            <a href="{{ route('school_admin.students.create') }}"
               class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-xl text-sm shadow">
                + Add
            </a>

        </div>

    </div>

    <!-- SUCCESS -->
    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 mb-4 rounded-xl">
            {{ session('success') }}
        </div>
    @endif

    <!-- 🔍 SEARCH -->
    <form method="GET" class="mb-5 flex gap-2">
        <input type="text" name="search"
               value="{{ request('search') }}"
               placeholder="Search student..."
               class="border p-3 rounded-xl w-full shadow-sm">

        <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 rounded-xl">
            🔍
        </button>
    </form>

    <!-- 🖥 DESKTOP TABLE -->
    <div class="hidden md:block bg-white rounded-2xl shadow">

        <table class="w-full text-sm">
            <thead class="bg-gray-100 text-gray-600">
                <tr>
                    <th class="p-4 text-left">Name</th>
                    <th class="p-4 text-left">Father</th>
                    <th class="p-4 text-left">Reg No</th>
                    <th class="p-4 text-left">Class</th>
                    <th class="p-4 text-center">⚙️</th>
                </tr>
            </thead>

            <tbody>
                @forelse($students as $student)
                <tr class="border-t hover:bg-gray-50 transition">

                    <td class="p-4 font-medium">{{ $student->name }}</td>
                    <td class="p-4">{{ $student->father_name }}</td>
                    <td class="p-4 text-indigo-600">{{ $student->student_id }}</td>

                    <!-- ✅ FIXED CLASS SHOW -->
                    <td class="p-4">
                    {{ $student->studentClass->name ?? '-' }}
                    ({{ $student->studentSection->name ?? '-' }})
                    </td>

                    <!-- ACTION -->
                    <td class="p-4 text-center relative">
                        <div x-data="{open:false}" class="inline-block">

                            <button @click="open=!open"
                                    class="p-2 rounded-full hover:bg-gray-200">
                                ⚙️
                            </button>

                            <div x-show="open"
                                 @click.away="open=false"
                                 class="absolute right-0 mt-2 w-36 bg-white border rounded-xl shadow-lg z-50">

                                <a href="{{ route('school_admin.students.view',$student->id) }}"
                                   class="block px-4 py-2 hover:bg-gray-100">👁 View</a>

                                <a href="{{ route('school_admin.students.edit',$student->id) }}"
                                   class="block px-4 py-2 hover:bg-gray-100">✏ Edit</a>

                                <form method="POST"
                                      action="{{ route('school_admin.students.delete',$student->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-50">
                                        🗑 Delete
                                    </button>
                                </form>

                            </div>

                        </div>
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center p-5 text-gray-500">
                        No Students Found 😔
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

    </div>

    <!-- 📱 MOBILE -->
    <div class="md:hidden space-y-4">

        @forelse($students as $student)

        <div class="bg-white p-4 rounded-xl shadow">

            <div class="flex justify-between items-center">

                <div>
                    <h2 class="font-semibold">{{ $student->name }}</h2>
                    <p class="text-xs text-gray-500">{{ $student->student_id }}</p>
                </div>

                <div x-data="{open:false}" class="relative">

                    <button @click="open=!open">⚙️</button>

                    <div x-show="open"
                         @click.away="open=false"
                         class="absolute right-0 mt-2 w-36 bg-white border rounded-xl shadow">

                        <a href="{{ route('school_admin.students.view',$student->id) }}"
                           class="block px-4 py-2 hover:bg-gray-100">👁 View</a>

                        <a href="{{ route('school_admin.students.edit',$student->id) }}"
                           class="block px-4 py-2 hover:bg-gray-100">✏ Edit</a>

                        <form method="POST"
                              action="{{ route('school_admin.students.delete',$student->id) }}">
                            @csrf
                            @method('DELETE')
                            <button class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-50">
                                🗑 Delete
                            </button>
                        </form>

                    </div>

                </div>

            </div>

            <div class="mt-3 text-sm text-gray-600">
                👨 {{ $student->father_name }} <br>

                <!-- ✅ FIXED -->
                🎓 {{ $student->studentClass->name ?? '-' }}
                   ({{ $student->studentSection->name ?? '-' }})
            </div>

        </div>

        @empty
        <p class="text-center text-gray-500">No Students Found 😔</p>
        @endforelse

    </div>

    <!-- PAGINATION -->
    <div class="mt-6">
        {{ $students->links() }}
    </div>

</div>

@endsection