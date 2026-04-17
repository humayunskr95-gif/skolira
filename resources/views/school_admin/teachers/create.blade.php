@extends('layouts.school_admin')

@section('content')

<div class="max-w-6xl mx-auto p-4 md:p-6">

    <!-- 🔥 HEADER -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">👨‍🏫 Add Teacher</h1>

        <a href="{{ route('school_admin.teachers.index') }}"
           class="bg-gray-200 px-4 py-2 rounded-lg hover:bg-gray-300">
            ← Back
        </a>
    </div>

    <!-- ❌ ERROR -->
    @if($errors->any())
        <div class="mb-4 bg-red-100 text-red-700 p-3 rounded-lg">
            @foreach($errors->all() as $error)
                <div>• {{ $error }}</div>
            @endforeach
        </div>
    @endif

    <!-- 🎯 FORM CARD -->
    <div class="bg-white rounded-2xl shadow-lg p-6 md:p-8">

        <form method="POST"
              action="{{ route('school_admin.teachers.store') }}"
              enctype="multipart/form-data">

            @csrf

            <!-- 👤 BASIC INFO -->
            <h2 class="font-semibold text-lg mb-4">👤 Basic Information</h2>

            <div class="grid md:grid-cols-3 gap-4">

                <input name="name" placeholder="Full Name" class="input" required>

                <input name="father_name" placeholder="Father Name" class="input">

                <input type="date" name="dob" class="input">

                <select name="gender" class="input">
                    <option value="">Select Gender</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>

                <input name="mobile" placeholder="Mobile Number" class="input" required>

                <input type="email" name="email" placeholder="Email" class="input">

            </div>

            <!-- 📍 ADDRESS -->
            <h2 class="font-semibold text-lg mt-6 mb-4">📍 Address</h2>

            <div class="grid md:grid-cols-3 gap-4">

                <input name="address1" placeholder="Address Line 1" class="input">
                <input name="address2" placeholder="Address Line 2" class="input">
                <input name="state" placeholder="State" class="input">

                <input name="district" placeholder="District" class="input">
                <input name="block" placeholder="Block" class="input">
                <input name="city" placeholder="City" class="input">

                <input name="pin" placeholder="PIN Code" class="input">

            </div>

            <!-- 📸 PHOTO -->
            <h2 class="font-semibold text-lg mt-6 mb-4">📸 Photo</h2>

            <input type="file" name="photo" id="photoInput" class="input">

            <img id="preview" class="mt-3 w-32 h-32 object-cover rounded hidden">

            <!-- 🚀 SUBMIT -->
            <div class="mt-8 text-right">
                <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg shadow">
                    💾 Save Teacher
                </button>
            </div>

        </form>

    </div>

</div>

<!-- 🎨 INPUT STYLE -->
<style>
.input {
    width: 100%;
    padding: 12px;
    border-radius: 10px;
    border: 1px solid #ddd;
    transition: 0.2s;
}
.input:focus {
    outline: none;
    border-color: #6366f1;
    box-shadow: 0 0 0 2px rgba(99,102,241,0.2);
}
</style>

<!-- 📸 IMAGE PREVIEW -->
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