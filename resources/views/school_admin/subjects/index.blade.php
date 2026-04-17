@extends('layouts.school_admin')

@section('content')

<div class="p-6">

    <!-- 🔥 HEADER -->
    <div class="flex justify-between items-center mb-6">

        <h2 class="text-2xl font-bold text-gray-800">
            📚 Subjects Management
        </h2>

        <a href="{{ route('school_admin.subjects.create') }}"
           class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-lg shadow">
            ➕ Add Subject
        </a>
    </div>

    <!-- 📊 CARD -->
    <div class="bg-white shadow-lg rounded-2xl overflow-hidden">

        <table class="w-full text-sm">

            <!-- HEADER -->
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="p-3 text-left">#</th>
                    <th class="p-3 text-left">Class</th>
                    <th class="p-3 text-left">Subject</th>
                    <th class="p-3 text-left">Teachers</th>
                    <th class="p-3 text-center">Action</th>
                </tr>
            </thead>

            <!-- BODY -->
            <tbody>

            @forelse($subjects as $index => $s)

                <tr class="border-t hover:bg-gray-50 transition">

                    <!-- Serial -->
                    <td class="p-3 font-medium">{{ $index + 1 }}</td>

                    <!-- Class -->
                    <td class="p-3">
                        <span class="bg-indigo-100 text-indigo-700 px-2 py-1 rounded text-xs font-semibold">
                            {{ $s->class->name }}
                        </span>
                    </td>

                    <!-- Subject -->
                    <td class="p-3 font-semibold text-gray-800">
                        {{ $s->name }}
                    </td>

                    <!-- Teachers -->
                    <td class="p-3">
                        @if($s->teachers->count())
                            @foreach($s->teachers as $t)
                                <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs mr-1">
                                    {{ $t->name }}
                                </span>
                            @endforeach
                        @else
                            <span class="text-gray-400 text-xs">Not Assigned</span>
                        @endif
                    </td>

                    <!-- ACTION -->
                    <td class="p-3 text-center space-x-2">

                        <!-- Assign -->
                        <a href="{{ route('school_admin.subjects.assign',$s->id) }}"
                           class="bg-green-100 text-green-700 px-3 py-1 rounded-lg hover:bg-green-200">
                            👨‍🏫 Assign
                        </a>

                        <!-- Edit -->
                        <a href="{{ route('school_admin.subjects.edit',$s->id) }}"
                           class="bg-blue-100 text-blue-700 px-3 py-1 rounded-lg hover:bg-blue-200">
                            ✏️ Edit
                        </a>

                        <!-- Delete -->
                        <form action="{{ route('school_admin.subjects.destroy',$s->id) }}"
                              method="POST"
                              class="inline">
                            @csrf
                            @method('DELETE')

                            <button onclick="return confirm('Delete this subject?')"
                                    class="bg-red-100 text-red-700 px-3 py-1 rounded-lg hover:bg-red-200">
                                🗑 Delete
                            </button>
                        </form>

                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="5" class="text-center p-6 text-gray-500">
                        🚫 No subjects found
                    </td>
                </tr>

            @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection