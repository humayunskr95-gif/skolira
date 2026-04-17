@extends('layouts.student')

@section('content')

<div class="p-4 md:p-6">

    <h2 class="text-xl md:text-2xl font-bold mb-4">
        📚 Homework List
    </h2>

    @if($homeworks->count() > 0)

    <div class="bg-white shadow rounded-xl overflow-hidden">

        <table class="w-full text-sm">

            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3 text-left">#</th>
                    <th class="p-3 text-left">Subject</th>
                    <th class="p-3 text-left">Title</th>
                    <th class="p-3 text-left">Description</th>
                    <th class="p-3 text-left">Due Date</th>
                </tr>
            </thead>

            <tbody>

                @foreach($homeworks as $key => $hw)
                <tr class="border-b hover:bg-gray-50">

                    <td class="p-3">{{ $key + 1 }}</td>

                    <td class="p-3">
                        {{ $hw->subject->name ?? '-' }}
                    </td>

                    <td class="p-3">
                        {{ $hw->title }}
                    </td>

                    <td class="p-3">
                        {{ $hw->description }}
                    </td>

                    <td class="p-3">
                        <span class="bg-red-100 text-red-600 px-2 py-1 rounded text-xs">
                            {{ $hw->due_date }}
                        </span>
                    </td>

                </tr>
                @endforeach

            </tbody>

        </table>

    </div>

    @else

    <div class="bg-yellow-100 text-yellow-700 p-4 rounded">
        ❌ No Homework Found
    </div>

    @endif

</div>

@endsection