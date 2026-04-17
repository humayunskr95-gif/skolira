@extends('layouts.school_admin')

@section('content')

<div class="flex justify-between mb-6">
    <h1 class="text-xl font-bold">📢 Notices</h1>

    <a href="{{ route('school_admin.notices.create') }}"
       class="bg-indigo-600 text-white px-4 py-2 rounded">
        + Add Notice
    </a>
</div>

<div class="bg-white rounded shadow">

    <table class="w-full text-sm">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-3">Title</th>
                <th class="p-3">Date</th>
                <th class="p-3">Action</th>
            </tr>
        </thead>

        <tbody>
            @foreach($notices as $notice)
            <tr class="border-t">
                <td class="p-3">{{ $notice->title }}</td>
                <td class="p-3">{{ $notice->date }}</td>

                <td class="p-3">
                    <form method="POST" action="{{ route('school_admin.notices.delete',$notice->id) }}">
                        @csrf
                        @method('DELETE')

                        <button class="text-red-600">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>

@endsection