@extends('layouts.school_admin')

@section('content')

<div class="p-6">

    <!-- Header -->
    <h2 class="text-xl font-semibold mb-4 flex items-center gap-2">
        ➕ Add Accountant
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
          action="{{ route('school_admin.accountants.store') }}"
          enctype="multipart/form-data"
          class="bg-white p-6 rounded shadow">

        @csrf

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

            <div>
                <label class="text-sm">Full Name *</label>
                <input type="text" name="name"
                       value="{{ old('name') }}"
                       class="w-full border px-3 py-2 rounded">
            </div>

            <div>
                <label class="text-sm">Father Name</label>
                <input type="text" name="father_name"
                       value="{{ old('father_name') }}"
                       class="w-full border px-3 py-2 rounded">
            </div>

            <div>
                <label class="text-sm">DOB</label>
                <input type="date" name="dob"
                       value="{{ old('dob') }}"
                       class="w-full border px-3 py-2 rounded">
            </div>

            <div>
                <label class="text-sm">Gender</label>
                <select name="gender" class="w-full border px-3 py-2 rounded">
                    <option value="">Select</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>
            </div>

            <div>
                <label class="text-sm">Mobile *</label>
                <input type="text" name="mobile"
                       value="{{ old('mobile') }}"
                       class="w-full border px-3 py-2 rounded">
            </div>

            <div>
                <label class="text-sm">Email *</label>
                <input type="email" name="email"
                       value="{{ old('email') }}"
                       class="w-full border px-3 py-2 rounded">
            </div>

            <div>
                <label class="text-sm">Password *</label>
                <input type="password" name="password"
                       class="w-full border px-3 py-2 rounded">
            </div>

            <div>
                <label class="text-sm">Address 1</label>
                <input type="text" name="address1"
                       class="w-full border px-3 py-2 rounded">
            </div>

            <div>
                <label class="text-sm">Address 2</label>
                <input type="text" name="address2"
                       class="w-full border px-3 py-2 rounded">
            </div>

            <div>
                <label class="text-sm">State</label>
                <input type="text" name="state"
                       class="w-full border px-3 py-2 rounded">
            </div>

            <div>
                <label class="text-sm">District</label>
                <input type="text" name="district"
                       class="w-full border px-3 py-2 rounded">
            </div>

            <div>
                <label class="text-sm">Block</label>
                <input type="text" name="block"
                       class="w-full border px-3 py-2 rounded">
            </div>

            <div>
                <label class="text-sm">City</label>
                <input type="text" name="city"
                       class="w-full border px-3 py-2 rounded">
            </div>

            <div>
                <label class="text-sm">PIN</label>
                <input type="text" name="pin"
                       class="w-full border px-3 py-2 rounded">
            </div>

            <div>
                <label class="text-sm">Photo</label>
                <input type="file" name="photo"
                       class="w-full border px-3 py-2 rounded">
            </div>

        </div>

        <!-- Buttons -->
        <div class="mt-6 flex gap-3">

            <button type="submit"
                    class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                💾 Save
            </button>

            <a href="{{ route('school_admin.accountants.index') }}"
               class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                ⬅ Back
            </a>

        </div>

    </form>

</div>

@endsection