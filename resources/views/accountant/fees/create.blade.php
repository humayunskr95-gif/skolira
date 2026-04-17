@extends('layouts.accountant')

@section('content')

<div class="p-6 max-w-xl mx-auto bg-white shadow rounded">

    <h2 class="text-xl font-bold mb-4">➕ Add Fee</h2>

    <form method="POST" action="{{ route('accountant.fees.store') }}">
        @csrf

        <!-- STUDENT -->
        <div class="mb-4">
            <label class="block mb-1 font-medium">Student</label>
            <select name="student_id" id="studentSelect"
                class="w-full border p-2 rounded" required>

                <option value="">Select Student</option>

                @foreach($students as $student)
                    <option value="{{ $student->id }}" data-class="{{ $student->class_id }}">
                        {{ $student->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- 🔥 CLASS SHOW (USER SEE) -->
        <div class="mb-4">
            <label class="block mb-1 font-medium">Class</label>
            <input type="text" id="class_name"
                class="w-full border p-2 rounded bg-gray-100"
                placeholder="Auto filled"
                readonly>
        </div>

        <!-- 🔥 CLASS ID (HIDDEN - MUST) -->
        <input type="hidden" name="class_id" id="class_id" required>

        <!-- AMOUNT -->
        <div class="mb-4">
            <label class="block mb-1 font-medium">Amount</label>
            <input type="number" name="amount"
                class="w-full border p-2 rounded" required>
        </div>

        <!-- DATE -->
        <div class="mb-4">
            <label class="block mb-1 font-medium">Date</label>
            <input type="date" name="date"
                class="w-full border p-2 rounded" required>
        </div>

        <!-- METHOD -->
        <div class="mb-4">
            <label class="block mb-1 font-medium">Payment Method</label>
            <select name="method" class="w-full border p-2 rounded">
                <option value="Cash">Cash</option>
                <option value="Online">Online</option>
                <option value="UPI">UPI</option>
            </select>
        </div>

        <button class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded w-full">
            💾 Save Fee
        </button>

    </form>

</div>

<!-- 🔥 SAFE SCRIPT -->
<script>
document.getElementById('studentSelect').addEventListener('change', function () {
    let selected = this.options[this.selectedIndex];

    let classId = selected.getAttribute('data-class');
    let classText = selected.text;

    if(classId){
        document.getElementById('class_id').value = classId;
        document.getElementById('class_name').value = "Class ID: " + classId;
    } else {
        document.getElementById('class_id').value = "";
        document.getElementById('class_name').value = "";
    }
});
</script>

@endsection