@extends('layouts.teacher')

@section('content')

<div class="p-6">

    <h2 class="text-2xl font-bold mb-4">📚 My Subjects</h2>

    <div class="bg-white shadow rounded">

        <table class="w-full text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3">#</th>
                    <th>Name</th>
                    <th>Code</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
            @forelse($subjects as $s)
                <tr class="border-t">
                    <td class="p-3">{{ $loop->iteration }}</td>
                    <td>{{ $s->name }}</td>
                    <td>{{ $s->code ?? '-' }}</td>

                    <td>
                        <a href="{{ route('teacher.subjects.show',$s->id) }}"
                           class="text-blue-500">View</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center p-4">
                        No Subjects Found 😔
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>

    </div>

</div>

@endsection