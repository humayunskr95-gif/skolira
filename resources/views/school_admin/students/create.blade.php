@extends('layouts.school_admin')

@section('content')

<div class="max-w-5xl mx-auto p-4 md:p-6">

    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">➕ Add Student</h1>

        <a href="{{ route('school_admin.students.index') }}"
           class="bg-gray-200 px-4 py-2 rounded-lg hover:bg-gray-300">
            ← Back
        </a>
    </div>

    <!-- Errors -->
    @if($errors->any())
        <div class="mb-4 bg-red-100 text-red-700 p-3 rounded">
            @foreach($errors->all() as $error)
                <div>• {{ $error }}</div>
            @endforeach
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow p-6">

        <form method="POST"
              action="{{ route('school_admin.students.store') }}"
              enctype="multipart/form-data">

            @csrf

            <!-- 👤 BASIC -->
            <h2 class="font-semibold mb-4">👤 Basic Info</h2>

            <div class="grid md:grid-cols-3 gap-4">

                <input name="name" value="{{ old('name') }}" placeholder="Student Name" class="input" required>

                <input name="father_name" value="{{ old('father_name') }}" placeholder="Father Name" class="input">

                <input name="mother_name" value="{{ old('mother_name') }}" placeholder="Mother Name" class="input">

                <select name="gender" class="input">
                    <option value="">Gender</option>
                    <option value="male" {{ old('gender')=='male'?'selected':'' }}>Male</option>
                    <option value="female" {{ old('gender')=='female'?'selected':'' }}>Female</option>
                </select>

                <input type="date" name="dob" value="{{ old('dob') }}" class="input">

                <input name="mobile" value="{{ old('mobile') }}" placeholder="Mobile" class="input" required>

            </div>

            <!-- 🎓 ACADEMIC -->
            <h2 class="font-semibold mt-6 mb-4">🎓 Academic Info</h2>

            <div class="grid md:grid-cols-3 gap-4">

                <!-- Class -->
                <select name="class_id" id="class" class="input" required>
                    <option value="">Select Class</option>
                    @foreach($classes as $class)
                        <option value="{{ $class->id }}"
                            {{ old('class_id')==$class->id ? 'selected':'' }}>
                            {{ $class->name }}
                        </option>
                    @endforeach
                </select>

                <!-- Section -->
                <select name="section_id" id="section" class="input" required>
                    <option value="">Select Section</option>
                </select>

                <!-- Roll -->
                <select name="roll" class="input" required>
    <option value="">Select Roll</option>

    @for($i = 1; $i <= 100; $i++)
        <option value="{{ $i }}"
            {{ old('roll') == $i ? 'selected' : '' }}>
            Roll {{ $i }}
        </option>
    @endfor

</select>

            </div>
           
            <!-- 🚐 Transport Info -->
<h2 class="font-semibold mt-6 mb-4">🚐 Transport Info</h2>

<div class="grid md:grid-cols-3 gap-4">

    <select name="route_id" class="input" required>
        <option value="">Select Route</option>

        @foreach($routes as $route)
            <option value="{{ $route->id }}"
                {{ old('route_id') == $route->id ? 'selected' : '' }}>
                {{ $route->name }} ({{ $route->start_point }} → {{ $route->end_point }})
            </option>
        @endforeach

    </select>

</div>

            <!-- 📍 ADDRESS -->
            <h2 class="font-semibold mt-6 mb-4">📍 Address</h2>

            <div class="grid md:grid-cols-3 gap-4">

                <input name="address1" value="{{ old('address1') }}" placeholder="Address 1" class="input">
                <input name="address2" value="{{ old('address2') }}" placeholder="Address 2" class="input">
                <input name="state" value="{{ old('state') }}" placeholder="State" class="input">

                <input name="district" value="{{ old('district') }}" placeholder="District" class="input">
                <input name="block" value="{{ old('block') }}" placeholder="Block" class="input">
                <input name="city" value="{{ old('city') }}" placeholder="City" class="input">

                <input name="pin" value="{{ old('pin') }}" placeholder="PIN" class="input">

            </div>

            <!-- 📸 PHOTO -->
            <h2 class="font-semibold mt-6 mb-4">📸 Photo</h2>

            <input type="file" name="photo" id="photoInput" class="input">
            <img id="preview" class="mt-3 w-32 h-32 hidden rounded object-cover">

            <!-- SUBMIT -->
            <div class="mt-6 text-right">
                <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg shadow">
                    💾 Save Student
                </button>
            </div>

        </form>

    </div>

</div>

<style>
.input {
    width:100%;
    padding:10px;
    border-radius:8px;
    border:1px solid #ddd;
}
.input:focus {
    border-color:#6366f1;
    outline:none;
    box-shadow:0 0 0 1px #6366f1;
}
</style>

<!-- ✅ SECTION LOAD (SAFE VERSION) -->
<script>
document.getElementById('class').addEventListener('change', function () {

    let classId = this.value;
    let section = document.getElementById('section');

    if(!classId){
        section.innerHTML = '<option value="">Select Section</option>';
        return;
    }

    fetch("{{ url('school-admin/get-sections') }}/" + classId)
        .then(res => res.json())
        .then(data => {

            section.innerHTML = '<option value="">Select Section</option>';

            data.forEach(sec => {
                section.innerHTML += `<option value="${sec.id}">${sec.name}</option>`;
            });

        })
        .catch(error => {
            console.error('Error loading sections:', error);
        });

});
</script>

<!-- 📸 PHOTO PREVIEW -->
<script>
document.getElementById('photoInput').addEventListener('change', function(e){
    const file = e.target.files[0];
    if(file){
        const preview = document.getElementById('preview');
        preview.src = URL.createObjectURL(file);
        preview.classList.remove('hidden');
    }
});
</script>

@endsection