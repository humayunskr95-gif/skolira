@extends('layouts.school_admin')

@section('content')

<div class="max-w-5xl mx-auto p-4 md:p-6">

    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">✏️ Edit Student</h1>

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

    <div class="bg-white rounded-2xl shadow-lg p-6 md:p-8">

        <form method="POST"
              action="{{ route('school_admin.students.update',$student->id) }}"
              enctype="multipart/form-data">

            @csrf
            @method('PUT')

            <!-- 👤 BASIC -->
            <h2 class="font-semibold mb-4 text-lg">👤 Basic Information</h2>

            <div class="grid md:grid-cols-3 gap-4">

                <input type="text" name="name"
                       value="{{ old('name',$student->name) }}"
                       placeholder="Student Name"
                       class="input">

                <input type="text" name="father_name"
                       value="{{ old('father_name',$student->father_name) }}"
                       placeholder="Father Name"
                       class="input">

                <input type="text" name="mother_name"
                       value="{{ old('mother_name',$student->mother_name) }}"
                       placeholder="Mother Name"
                       class="input">

                <select name="gender" class="input">
                    <option value="">Select Gender</option>
                    <option value="male" {{ $student->gender=='male'?'selected':'' }}>Male</option>
                    <option value="female" {{ $student->gender=='female'?'selected':'' }}>Female</option>
                </select>

                <input type="date" name="dob"
                       value="{{ $student->dob }}"
                       class="input">

                <input type="text" name="mobile"
                       value="{{ old('mobile',$student->mobile) }}"
                       placeholder="Mobile"
                       class="input">

            </div>

            <!-- 🎓 ACADEMIC -->
            <h2 class="font-semibold mt-6 mb-4 text-lg">🎓 Academic Info</h2>

            <div class="grid md:grid-cols-3 gap-4">

                <!-- Class -->
                <select name="class_id" id="class" class="input" required>
                    <option value="">Select Class</option>

                    @foreach($classes as $class)
                        <option value="{{ $class->id }}"
                            {{ $student->class_id == $class->id ? 'selected' : '' }}>
                            {{ $class->name }}
                        </option>
                    @endforeach
                </select>

                <!-- Section -->
                <select name="section_id" id="section" class="input" required>
                    <option value="">Select Section</option>

                    @foreach($classes as $class)
                        @foreach($class->sections as $sec)
                            <option value="{{ $sec->id }}"
                                {{ $student->section_id == $sec->id ? 'selected' : '' }}>
                                {{ $sec->name }}
                            </option>
                        @endforeach
                    @endforeach
                </select>

            </div>

            <!-- 🚐 TRANSPORT -->
            <h2 class="font-semibold mt-6 mb-4">🚐 Transport Info</h2>

            <div class="grid md:grid-cols-3 gap-4">

                <select name="route_id" class="input" required>
                    <option value="">Select Route</option>

                    @foreach($routes as $route)
                        <option value="{{ $route->id }}"
                            {{ $student->route_id == $route->id ? 'selected' : '' }}>
                            {{ $route->name }} ({{ $route->start_point }} → {{ $route->end_point }})
                        </option>
                    @endforeach

                </select>

            </div>

            <!-- 📍 ADDRESS -->
            <h2 class="font-semibold mt-6 mb-4 text-lg">📍 Address</h2>

            <div class="grid md:grid-cols-3 gap-4">

                <input type="text" name="address1"
                       value="{{ old('address1',$student->address1) }}"
                       placeholder="Address Line 1" class="input">

                <input type="text" name="address2"
                       value="{{ old('address2',$student->address2) }}"
                       placeholder="Address Line 2" class="input">

                <input type="text" name="state"
                       value="{{ old('state',$student->state) }}"
                       placeholder="State" class="input">

                <input type="text" name="district"
                       value="{{ old('district',$student->district) }}"
                       placeholder="District" class="input">

                <input type="text" name="block"
                       value="{{ old('block',$student->block) }}"
                       placeholder="Block" class="input">

                <input type="text" name="city"
                       value="{{ old('city',$student->city) }}"
                       placeholder="City" class="input">

                <input type="text" name="pin"
                       value="{{ old('pin',$student->pin) }}"
                       placeholder="PIN Code" class="input">

            </div>

            <!-- 🔐 LOGIN -->
            <h2 class="font-semibold mt-6 mb-4 text-lg">🔐 Login Info</h2>

            <div class="grid md:grid-cols-2 gap-4">

                <input type="email" name="email"
                       value="{{ old('email',$student->email) }}"
                       placeholder="Email"
                       class="input">

                <input type="password" name="password"
                       placeholder="New Password (optional)"
                       class="input">

            </div>

            <!-- 📸 PHOTO -->
            <h2 class="font-semibold mt-6 mb-4 text-lg">📸 Photo</h2>

            <input type="file" name="photo" id="photoInput" class="input">

            @if($student->photo)
                <img src="{{ asset('storage/'.$student->photo) }}"
                     class="mt-3 w-32 h-32 object-cover rounded">
            @endif

            <img id="preview" class="mt-3 w-32 h-32 object-cover rounded hidden">

            <!-- SUBMIT -->
            <div class="mt-8 text-right">
                <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg shadow">
                    🔄 Update Student
                </button>
            </div>

        </form>

    </div>

</div>

<style>
.input {
    width: 100%;
    padding: 10px;
    border-radius: 8px;
    border: 1px solid #ddd;
}
.input:focus {
    outline: none;
    border-color: #6366f1;
    box-shadow: 0 0 0 1px #6366f1;
}
</style>

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