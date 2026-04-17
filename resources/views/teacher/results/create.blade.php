@extends('layouts.teacher')

@section('content')

<div class="p-4 md:p-6 max-w-full">

    <h2 class="text-xl md:text-2xl font-bold mb-4">📝 Enter Marks</h2>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('teacher.results.store') }}">
    @csrf

    <input type="hidden" name="subject_id" value="{{ $subject_id }}">

    <div class="bg-white shadow rounded-xl overflow-hidden">

        <div class="overflow-x-auto">

            <table class="min-w-full text-sm">

                <!-- HEADER -->
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-3 text-left w-12">#</th>
                        <th class="p-3 text-left">Student Name</th>
                        <th class="p-3 text-center w-40">Marks (0-100)</th>
                    </tr>
                </thead>

                <!-- BODY -->
                <tbody>
                    @forelse($students as $s)
                    <tr class="border-t hover:bg-gray-50">

                        <td class="p-3">{{ $loop->iteration }}</td>

                        <td class="p-3 whitespace-nowrap font-medium">
                            {{ $s->name }}
                        </td>

                        <td class="p-3">
                            <input type="number"
                                   name="marks[{{ $s->id }}]"
                                   class="border p-2 rounded w-full text-center focus:ring-2 focus:ring-indigo-400"
                                   placeholder="0-100"
                                   min="0"
                                   max="100"
                                   required>
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="p-4 text-center text-gray-500">
                            No Students Found ❌
                        </td>
                    </tr>
                    @endforelse
                </tbody>

            </table>

        </div>

    </div>

    <!-- BUTTON -->
    <div class="mt-5 flex justify-end">
        <button class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 shadow">
            💾 Save Marks
        </button>
    </div>

    </form>

</div>

@endsection