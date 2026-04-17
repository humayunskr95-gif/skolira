@extends('layouts.teacher')

@section('content')

<div class="p-4 md:p-6">

    <!-- HEADER -->
    <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-6 gap-3">
        <h2 class="text-xl font-bold">📝 My Attendance</h2>

        <!-- TODAY STATUS -->
        @if($today)
            <span class="px-4 py-2 rounded-lg text-white text-sm 
                {{ $today->status == 'present' ? 'bg-green-500' : 'bg-red-500' }}">
                Today: {{ ucfirst($today->status) }}
            </span>
        @endif
    </div>

    <!-- ALERT -->
    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif


    <!-- ================= ACTION AREA ================= -->
    <div class="flex flex-wrap gap-3 mb-6">

        {{-- 🔥 IF NOT MARKED --}}
        @if(!$today)

            <form method="POST" action="{{ route('teacher.attendance.mark') }}">
                @csrf
                <input type="hidden" name="status" value="present">
                <button class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition">
                    ✅ Mark Present
                </button>
            </form>

            <form method="POST" action="{{ route('teacher.attendance.mark') }}">
                @csrf
                <input type="hidden" name="status" value="absent">
                <button class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition">
                    ❌ Mark Absent
                </button>
            </form>

        @else

            {{-- 🔥 CHECK OUT BUTTON --}}
            @if(!$today->check_out)
                <form method="POST" action="{{ route('teacher.attendance.checkout') }}">
                    @csrf
                    <button class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition">
                        🚪 Check Out
                    </button>
                </form>
            @else
                <span class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg">
                    ✅ Day Completed
                </span>
            @endif

        @endif

    </div>


    <!-- ================= TABLE ================= -->
    <div class="bg-white shadow rounded-lg overflow-hidden">

        <div class="overflow-x-auto">
            <table class="w-full text-sm">

                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="p-3 text-left">Date</th>
                        <th class="p-3 text-left">Status</th>
                        <th class="p-3 text-left">Check In</th>
                        <th class="p-3 text-left">Check Out</th>
                        <th class="p-3 text-left">Working Hours</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($attendances as $a)
                    <tr class="border-t hover:bg-gray-50">

                        <!-- DATE -->
                        <td class="p-3">
                            {{ \Carbon\Carbon::parse($a->date)->format('d M Y') }}
                        </td>

                        <!-- STATUS -->
                        <td class="p-3">
                            <span class="px-2 py-1 rounded text-white text-xs
                                {{ $a->status == 'present' ? 'bg-green-500' : 'bg-red-500' }}">
                                {{ ucfirst($a->status) }}
                            </span>
                        </td>

                        <!-- CHECK IN -->
                        <td class="p-3 text-gray-600">
                            {{ $a->check_in ?? '-' }}
                        </td>

                        <!-- CHECK OUT -->
                        <td class="p-3 text-gray-600">
                            {{ $a->check_out ?? '-' }}
                        </td>

                        <!-- WORK HOURS -->
                        <td class="p-3 text-gray-600">
                            @if($a->check_in && $a->check_out)
                                {{ \Carbon\Carbon::parse($a->check_in)->diffInHours($a->check_out) }} hrs
                            @else
                                -
                            @endif
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center p-4 text-gray-500">
                            No Attendance Found 😔
                        </td>
                    </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

    </div>

    <!-- PAGINATION -->
    <div class="mt-4">
        {{ $attendances->links() }}
    </div>

</div>

@endsection