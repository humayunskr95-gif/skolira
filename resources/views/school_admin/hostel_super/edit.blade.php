@extends('layouts.school_admin')

@section('content')

<div class="p-6">

    <!-- Header -->
    <h2 class="text-xl font-semibold mb-4">
        ✏️ Edit Hostel Super
    </h2>

    <!-- Errors -->
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
          action="{{ route('school_admin.hostel_super.update',$user->id) }}"
          enctype="multipart/form-data"
          class="bg-white p-6 rounded shadow">

        @csrf
        @method('PUT')

        <div class="grid md:grid-cols-3 gap-4">

            <!-- Code -->
            <div>
                <label>Hostel Code</label>
                <input type="text"
                       value="{{ $user->hostel_super_code }}"
                       class="input bg-gray-100" readonly>
            </div>

            <!-- Name -->
            <div>
                <label>Full Name *</label>
                <input type="text" name="name" required
                       value="{{ old('name',$user->name) }}"
                       class="input">
            </div>

            <!-- Father Name -->
            <div>
                <label>Father Name *</label>
                <input type="text" name="father_name" required
                       value="{{ old('father_name',$user->father_name) }}"
                       class="input">
            </div>

            <!-- DOB -->
            <div>
                <label>DOB *</label>
                <input type="date" name="dob" required
                       value="{{ old('dob',$user->dob) }}"
                       class="input">
            </div>

            <!-- Gender -->
            <div>
                <label>Gender *</label>
                <select name="gender" class="input" required>
                    <option value="">Select</option>
                    <option value="male" {{ $user->gender=='male'?'selected':'' }}>Male</option>
                    <option value="female" {{ $user->gender=='female'?'selected':'' }}>Female</option>
                </select>
            </div>

            <!-- Mobile -->
            <div>
                <label>Mobile *</label>
                <input type="text" name="mobile" required
                       value="{{ old('mobile',$user->mobile) }}"
                       class="input">
            </div>

            <!-- Email -->
            <div>
                <label>Email *</label>
                <input type="email" name="email" required
                       value="{{ old('email',$user->email) }}"
                       class="input">
            </div>

            <!-- Password -->
            <div>
                <label>New Password</label>
                <input type="password" name="password"
                       class="input"
                       placeholder="Leave blank">
            </div>

            <!-- Address1 -->
            <div>
                <label>Address Line 1 *</label>
                <input type="text" name="address1" required
                       value="{{ old('address1',$user->address1) }}"
                       class="input">
            </div>

            <!-- Address2 -->
            <div>
                <label>Address Line 2 *</label>
                <input type="text" name="address2" required
                       value="{{ old('address2',$user->address2) }}"
                       class="input">
            </div>

            <!-- State -->
            <div>
                <label>State *</label>
                <input type="text" name="state" required
                       value="{{ old('state',$user->state) }}"
                       class="input">
            </div>

            <!-- District -->
            <div>
                <label>District *</label>
                <input type="text" name="district" required
                       value="{{ old('district',$user->district) }}"
                       class="input">
            </div>

            <!-- Block -->
            <div>
                <label>Block *</label>
                <input type="text" name="block" required
                       value="{{ old('block',$user->block) }}"
                       class="input">
            </div>

            <!-- City -->
            <div>
                <label>City *</label>
                <input type="text" name="city" required
                       value="{{ old('city',$user->city) }}"
                       class="input">
            </div>

            <!-- PIN -->
            <div>
                <label>PIN *</label>
                <input type="text" name="pin" required
                       value="{{ old('pin',$user->pin) }}"
                       class="input">
            </div>

            <!-- Photo -->
            <div>
                <label>Photo</label>
                <input type="file" name="photo" class="input">
            </div>

            <!-- Preview -->
            <div>
                <label>Current Photo</label><br>

                @if($user->photo)
                    <img src="{{ asset('storage/'.$user->photo) }}"
                         class="w-20 h-20 rounded mt-2">
                @else
                    <span class="text-gray-500">No Image</span>
                @endif
            </div>

        </div>

        <!-- Buttons -->
        <div class="mt-6 flex gap-3">

            <button class="bg-green-500 text-white px-4 py-2 rounded">
                🔄 Update
            </button>

            <a href="{{ route('school_admin.hostel_super.index') }}"
               class="bg-gray-500 text-white px-4 py-2 rounded">
                ⬅ Back
            </a>

        </div>

    </form>

</div>

<style>
.input{
    width:100%;
    padding:10px;
    border:1px solid #ddd;
    border-radius:8px;
}
</style>

@endsection