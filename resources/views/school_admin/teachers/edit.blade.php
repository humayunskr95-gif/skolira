@extends('layouts.school_admin')

@section('content')

<div class="max-w-6xl mx-auto p-4 md:p-6">

    <!-- 🔥 HEADER -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">✏️ Edit Teacher</h1>

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
              action="{{ route('school_admin.teachers.update', $teacher->id) }}"
              enctype="multipart/form-data">

            @csrf
            @method('PUT')

            <!-- 👤 BASIC INFO -->
            <h2 class="font-semibold text-lg mb-4">👤 Basic Information</h2>

            <div class="grid md:grid-cols-3 gap-4">

                <input name="name"
                       value="{{ old('name', $teacher->name) }}"
                       class="input" placeholder="Full Name">

                <input name="father_name"
                       value="{{ old('father_name', $teacher->father_name) }}"
                       class="input" placeholder="Father Name">

                <input type="date" name="dob"
                       value="{{ old('dob', $teacher->dob) }}"
                       class="input">

                <select name="gender" class="input">
                    <option value="">Select Gender</option>
                    <option value="male" {{ $teacher->gender=='male'?'selected':'' }}>Male</option>
                    <option value="female" {{ $teacher->gender=='female'?'selected':'' }}>Female</option>
                </select>

                <input name="mobile"
                       value="{{ old('mobile', $teacher->mobile) }}"
                       class="input" placeholder="Mobile">

                <input type="email" name="email"
                       value="{{ old('email', $teacher->email) }}"
                       class="input" placeholder="Email">

            </div>

            <!-- 📍 ADDRESS -->
            <h2 class="font-semibold text-lg mt-6 mb-4">📍 Address</h2>

            <div class="grid md:grid-cols-3 gap-4">

                <input name="address1" value="{{ old('address1',$teacher->address1) }}" class="input" placeholder="Address 1">
                <input name="address2" value="{{ old('address2',$teacher->address2) }}" class="input" placeholder="Address 2">
                <input name="state" value="{{ old('state',$teacher->state) }}" class="input" placeholder="State">

                <input name="district" value="{{ old('district',$teacher->district) }}" class="input" placeholder="District">
                <input name="block" value="{{ old('block',$teacher->block) }}" class="input" placeholder="Block">
                <input name="city" value="{{ old('city',$teacher->city) }}" class="input" placeholder="City">

                <input name="pin" value="{{ old('pin',$teacher->pin) }}" class="input" placeholder="PIN">

            </div>

            <!-- 📸 PHOTO -->
            <h2 class="font-semibold text-lg mt-6 mb-4">📸 Photo</h2>

            <div class="flex items-center gap-6">

                <!-- OLD PHOTO -->
                @if($teacher->photo)
                    <img src="{{ asset('storage/'.$teacher->photo) }}"
                         class="w-24 h-24 object-cover rounded-lg border">
                @endif

                <!-- NEW UPLOAD -->
                <input type="file" name="photo" id="photoInput" class="input">

            </div>

            <!-- PREVIEW -->
            <img id="preview" class="mt-3 w-32 h-32 object-cover rounded hidden">

            <!-- 🚀 SUBMIT -->
            <div class="mt-8 text-right">
                <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg shadow">
                    💾 Update Teacher
                </button>
            </div>

        </form>

    </div>

</div>

<!-- 🎨 STYLE -->
<style>
.input {
    width:100%;
    padding:12px;
    border-radius:10px;
    border:1px solid #ddd;
}
.input:focus {
    outline:none;
    border-color:#6366f1;
    box-shadow:0 0 0 2px rgba(99,102,241,0.2);
}
</style>

<!-- 📸 PREVIEW -->
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