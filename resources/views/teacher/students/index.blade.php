@extends('layouts.teacher')

@section('content')

<div class="p-4 md:p-6">

    <!-- HEADER -->
    <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-4 gap-3">
        <h2 class="text-xl font-bold">👨‍🎓 My Students</h2>

        <!-- SEARCH -->
        <form method="GET" class="flex gap-2">
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Search student..."
                   class="border px-3 py-2 rounded w-full md:w-64 focus:ring focus:border-indigo-400">

            <button class="bg-indigo-500 text-white px-4 rounded">
                🔍
            </button>
        </form>
    </div>

    <!-- TABLE -->
    <div class="bg-white shadow rounded-lg overflow-hidden">

        <table class="w-full text-sm">
            <thead class="bg-gray-100 text-gray-600">
                <tr>
                    <th class="p-3 text-left">#</th>
                    <th class="p-3 text-left">Name</th>
                    <th class="p-3 text-left">Email</th>
                    <th class="p-3 text-left">Mobile</th>
                    <th class="p-3 text-center">⚙</th>
                </tr>
            </thead>

            <tbody>
                @forelse($students as $s)
                <tr class="border-t hover:bg-gray-50">

                    <td class="p-3">
                        {{ ($students->currentPage()-1)*$students->perPage() + $loop->iteration }}
                    </td>

                    <td class="p-3 font-semibold text-indigo-600">
                        {{ $s->name }}
                    </td>

                    <td class="p-3">{{ $s->email }}</td>

                    <td class="p-3">{{ $s->mobile }}</td>

                    <!-- ACTION -->
                    <td class="p-3 text-center">
                        <a href="{{ route('teacher.students.show', $s->id) }}"
                           class="bg-indigo-500 text-white px-3 py-1 rounded hover:bg-indigo-600">
                           👁 View
                        </a>
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center p-4 text-gray-500">
                        No Students Found 😔
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

    </div>

    <!-- PAGINATION -->
    <div class="mt-4">
        {{ $students->links() }}
    </div>

</div>

@endsection