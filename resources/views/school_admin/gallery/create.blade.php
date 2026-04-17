@extends('layouts.school_admin')

@section('content')

<div class="p-4 md:p-6 max-w-3xl mx-auto">

    <!-- 🔥 Header -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-xl md:text-2xl font-bold text-gray-800">
            📤 Upload Gallery Image
        </h1>

        <a href="{{ route('school_admin.gallery.index') }}"
           class="bg-gray-200 px-3 py-2 rounded-lg text-sm hover:bg-gray-300">
            ← Back
        </a>
    </div>

    <!-- 🔥 Success Message -->
    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    <!-- 🔥 Error -->
    @if($errors->any())
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
            <ul class="text-sm">
                @foreach($errors->all() as $error)
                    <li>• {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- 🔥 Card -->
    <div class="bg-white p-6 md:p-8 rounded-2xl shadow">

        <form method="POST"
              action="{{ route('school_admin.gallery.store') }}"
              enctype="multipart/form-data"
              class="space-y-5">

            @csrf

            <!-- 📷 Image Upload -->
            <div>
                <label class="text-sm text-gray-600">Upload Image</label>

                <input type="file" name="image" id="imageInput"
                       class="w-full mt-2 p-2 border rounded-lg"
                       accept="image/*"
                       required>

                <!-- Preview -->
                <img id="preview"
                     class="mt-3 rounded-lg shadow hidden w-full max-h-64 object-cover"/>
            </div>

            <!-- 🏷 Title -->
            <div>
                <label class="text-sm text-gray-600">Title (Optional)</label>

                <input type="text" name="title"
                       value="{{ old('title') }}"
                       placeholder="Event / Image title"
                       class="w-full mt-2 p-2 border rounded-lg focus:ring-2 focus:ring-indigo-500">
            </div>

            <!-- 🚀 Submit -->
            <div class="text-right">
                <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-lg shadow">
                    🚀 Upload Image
                </button>
            </div>

        </form>

    </div>

</div>

<!-- 🔥 Image Preview Script -->
<script>
document.getElementById('imageInput').addEventListener('change', function(event) {
    const [file] = this.files;
    if (file) {
        const preview = document.getElementById('preview');
        preview.src = URL.createObjectURL(file);
        preview.classList.remove('hidden');
    }
});
</script>

@endsection