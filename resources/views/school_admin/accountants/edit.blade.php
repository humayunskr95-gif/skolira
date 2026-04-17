@extends('layouts.school_admin')

@section('content')

<div class="p-6">

    <!-- Header -->
    <h2 class="text-xl font-semibold mb-4 flex items-center gap-2">
        ✏️ Edit Accountant
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
          action="{{ route('school_admin.accountants.update', $accountant->id) }}"
          enctype="multipart/form-data"
          class="bg-white p-6 rounded shadow">

        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

            <!-- Account Code -->
            <div>
                <label class="text-sm">Account Code</label>
                <input type="text"
                       value="{{ $accountant->account_code }}"
                       class="w-full border px-3 py-2 rounded bg-gray-100"
                       readonly>
            </div>

            <!-- Name -->
            <div>
                <label class="text-sm">Full Name *</label>
                <input type="text" name="name"
                       value="{{ old('name',$accountant->name) }}"
                       class="w-full border px-3 py-2 rounded">
            </div>

            <!-- Father -->
            <div>
                <label class="text-sm">Father Name</label>
                <input type="text" name="father_name"
                       value="{{ old('father_name',$accountant->father_name) }}"
                       class="w-full border px-3 py-2 rounded">
            </div>

            <!-- DOB -->
            <div>
                <label class="text-sm">DOB</label>
                <input type="date" name="dob"
                       value="{{ old('dob',$accountant->dob) }}"
                       class="w-full border px-3 py-2 rounded">
            </div>

            <!-- Gender -->
            <div>
                <label class="text-sm">Gender</label>
                <select name="gender" class="w-full border px-3 py-2 rounded">
                    <option value="">Select</option>
                    <option value="male" {{ old('gender',$accountant->gender)=='male'?'selected':'' }}>Male</option>
                    <option value="female" {{ old('gender',$accountant->gender)=='female'?'selected':'' }}>Female</option>
                </select>
            </div>

            <!-- Mobile -->
            <div>
                <label class="text-sm">Mobile *</label>
                <input type="text" name="mobile"
                       value="{{ old('mobile',$accountant->mobile) }}"
                       class="w-full border px-3 py-2 rounded">
            </div>

            <!-- Email -->
            <div>
                <label class="text-sm">Email *</label>
                <input type="email" name="email"
                       value="{{ old('email',$accountant->email) }}"
                       class="w-full border px-3 py-2 rounded">
            </div>

            <!-- Password -->
            <div>
                <label class="text-sm">New Password</label>
                <input type="password" name="password"
                       placeholder="Leave blank if not changing"
                       class="w-full border px-3 py-2 rounded">
            </div>

            <!-- Address -->
            <div>
                <label class="text-sm">Address 1</label>
                <input type="text" name="address1"
                       value="{{ old('address1',$accountant->address1) }}"
                       class="w-full border px-3 py-2 rounded">
            </div>

            <div>
                <label class="text-sm">Address 2</label>
                <input type="text" name="address2"
                       value="{{ old('address2',$accountant->address2) }}"
                       class="w-full border px-3 py-2 rounded">
            </div>

            <div>
                <label class="text-sm">State</label>
                <input type="text" name="state"
                       value="{{ old('state',$accountant->state) }}"
                       class="w-full border px-3 py-2 rounded">
            </div>

            <div>
                <label class="text-sm">District</label>
                <input type="text" name="district"
                       value="{{ old('district',$accountant->district) }}"
                       class="w-full border px-3 py-2 rounded">
            </div>

            <div>
                <label class="text-sm">Block</label>
                <input type="text" name="block"
                       value="{{ old('block',$accountant->block) }}"
                       class="w-full border px-3 py-2 rounded">
            </div>

            <div>
                <label class="text-sm">City</label>
                <input type="text" name="city"
                       value="{{ old('city',$accountant->city) }}"
                       class="w-full border px-3 py-2 rounded">
            </div>

            <div>
                <label class="text-sm">PIN</label>
                <input type="text" name="pin"
                       value="{{ old('pin',$accountant->pin) }}"
                       class="w-full border px-3 py-2 rounded">
            </div>

            <!-- Photo -->
            <div>
                <label class="text-sm">Photo</label>
                <input type="file" name="photo"
                       class="w-full border px-3 py-2 rounded">
            </div>

            <!-- Preview -->
            <div>
                <label class="text-sm">Current Photo</label><br>

                @if($accountant->photo)
                    <img src="{{ asset('storage/'.$accountant->photo) }}"
                         class="w-20 h-20 rounded object-cover mt-2">
                @else
                    <span class="text-gray-500 text-sm">No Image</span>
                @endif
            </div>

        </div>

        <!-- Buttons -->
        <div class="mt-6 flex gap-3">

            <button type="submit"
                    class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                🔄 Update
            </button>

            <a href="{{ route('school_admin.accountants.index') }}"
               class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                ⬅ Back
            </a>

        </div>

    </form>

</div>

@endsection