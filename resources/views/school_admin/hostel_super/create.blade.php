@extends('layouts.school_admin')

@section('content')

<div class="p-6">

    <!-- Header -->
    <h2 class="text-xl font-semibold mb-4 flex items-center gap-2">
        🏨 Add Hostel Super
    </h2>

    <!-- Error -->
    @if ($errors->any())
        <div class="bg-red-100 text-red-600 p-3 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>⚠ {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST"
          action="{{ route('school_admin.hostel_super.store') }}"
          enctype="multipart/form-data"
          class="bg-white p-6 rounded shadow">

        @csrf

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

            <!-- Name -->
            <div>
                <label class="text-sm">Full Name *</label>
                <input type="text" name="name" required
                       value="{{ old('name') }}"
                       class="input">
            </div>

            <!-- Father Name -->
            <div>
                <label class="text-sm">Father Name *</label>
                <input type="text" name="father_name" required
                       value="{{ old('father_name') }}"
                       class="input">
            </div>

            <!-- DOB -->
            <div>
                <label class="text-sm">Date of Birth *</label>
                <input type="date" name="dob" required
                       value="{{ old('dob') }}"
                       class="input">
            </div>

            <!-- Gender -->
            <div>
                <label class="text-sm">Gender *</label>
                <select name="gender" required class="input">
                    <option value="">Select</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>
            </div>

            <!-- Mobile -->
            <div>
                <label class="text-sm">Mobile *</label>
                <input type="text" name="mobile" required
                       value="{{ old('mobile') }}"
                       class="input">
            </div>

            <!-- Email -->
            <div>
                <label class="text-sm">Email *</label>
                <input type="email" name="email" required
                       value="{{ old('email') }}"
                       class="input">
            </div>

            <!-- Address 1 -->
            <div>
                <label class="text-sm">Address Line 1 *</label>
                <input type="text" name="address1" required
                       value="{{ old('address1') }}"
                       class="input">
            </div>

            <!-- Address 2 -->
            <div>
                <label class="text-sm">Address Line 2 *</label>
                <input type="text" name="address2" required
                       value="{{ old('address2') }}"
                       class="input">
            </div>

            <!-- State -->
            <div>
                <label class="text-sm">State *</label>
                <input type="text" name="state" required
                       value="{{ old('state') }}"
                       class="input">
            </div>

            <!-- District -->
            <div>
                <label class="text-sm">District *</label>
                <input type="text" name="district" required
                       value="{{ old('district') }}"
                       class="input">
            </div>

            <!-- Block -->
            <div>
                <label class="text-sm">Block *</label>
                <input type="text" name="block" required
                       value="{{ old('block') }}"
                       class="input">
            </div>

            <!-- City -->
            <div>
                <label class="text-sm">City *</label>
                <input type="text" name="city" required
                       value="{{ old('city') }}"
                       class="input">
            </div>

            <!-- PIN -->
            <div>
                <label class="text-sm">PIN Code *</label>
                <input type="text" name="pin" required
                       value="{{ old('pin') }}"
                       class="input">
            </div>

            <!-- Photo -->
            <div>
                <label class="text-sm">Photo *</label>
                <input type="file" name="photo" required
                       class="input">
            </div>

        </div>

        <!-- Info -->
        <div class="mt-4 text-sm text-gray-500">
            🔐 Default Password: <b>123456</b><br>
            🆔 Code auto generate হবে
        </div>

        <!-- Buttons -->
        <div class="mt-6 flex gap-3">

            <button type="submit"
                    class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                💾 Save
            </button>

            <a href="{{ route('school_admin.hostel_super.index') }}"
               class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                ⬅ Back
            </a>

        </div>

    </form>

</div>

<style>
.input {
    width:100%;
    padding:10px;
    border-radius:8px;
    border:1px solid #ddd;
}
</style>

@endsection