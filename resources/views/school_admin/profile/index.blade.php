@extends('layouts.school_admin')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">

    <div class="flex flex-col gap-2 md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="flex items-center gap-3 text-2xl font-bold text-gray-900">
                <span class="flex h-10 w-10 items-center justify-center rounded-2xl bg-indigo-100 text-indigo-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6.75a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                    </svg>
                </span>
                <span>My Profile</span>
            </h1>
            <p class="text-sm text-gray-500">School admin account information, contact details, and school summary.</p>
        </div>
        <div class="text-sm text-gray-500">
            Last login area: School Admin Panel
        </div>
    </div>

    @if(session('success'))
        <div class="rounded-2xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">

        <div class="space-y-6 xl:col-span-1">
            <div class="overflow-hidden rounded-3xl bg-gradient-to-br from-indigo-600 via-indigo-700 to-slate-900 p-6 text-white shadow-lg">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-sm text-indigo-100">School Administrator</p>
                        <h2 class="mt-2 text-2xl font-bold">{{ $user->name }}</h2>
                        <p class="mt-1 text-sm text-indigo-100">{{ $user->email }}</p>
                    </div>
                    <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-white/15">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6.75a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                        </svg>
                    </div>
                </div>

                <div class="mt-6 grid grid-cols-1 gap-3 text-sm">
                    <div class="rounded-2xl bg-white/10 px-4 py-3">
                        <p class="text-indigo-100">Phone</p>
                        <p class="mt-1 font-medium text-white">{{ $user->mobile ?: 'Not added yet' }}</p>
                    </div>
                    <div class="rounded-2xl bg-white/10 px-4 py-3">
                        <p class="text-indigo-100">Role</p>
                        <p class="mt-1 font-medium text-white">School Admin</p>
                    </div>
                </div>
            </div>

            <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-gray-100">
                <h3 class="text-lg font-semibold text-gray-900">School Information</h3>
                <div class="mt-4 space-y-4 text-sm">
                    <div>
                        <p class="text-gray-500">School Name</p>
                        <p class="font-medium text-gray-900">{{ optional($user->school)->name ?: 'Not available' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">School Code</p>
                        <p class="font-medium text-gray-900">{{ optional($user->school)->code ?: 'Not available' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Owner Name</p>
                        <p class="font-medium text-gray-900">{{ optional($user->school)->owner_name ?: 'Not available' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">School Address</p>
                        <p class="font-medium text-gray-900">
                            {{ collect([optional($user->school)->address1, optional($user->school)->city, optional($user->school)->state, optional($user->school)->pin])->filter()->join(', ') ?: 'Not available' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="xl:col-span-2">
            <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-gray-100 md:p-8">
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">Update Profile</h3>
                    <p class="mt-1 text-sm text-gray-500">Keep your account details up to date for smooth school operations.</p>
                </div>

                <form method="POST" action="{{ route('school_admin.profile.update') }}" class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                        <div>
                            <label class="mb-2 block text-sm font-medium text-gray-700">Full Name</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                   class="w-full rounded-2xl border border-gray-200 px-4 py-3 text-sm outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100">
                            @error('name')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-medium text-gray-700">Email Address</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                   class="w-full rounded-2xl border border-gray-200 px-4 py-3 text-sm outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100">
                            @error('email')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-medium text-gray-700">Mobile Number</label>
                            <input type="text" name="mobile" value="{{ old('mobile', $user->mobile) }}"
                                   class="w-full rounded-2xl border border-gray-200 px-4 py-3 text-sm outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100">
                            @error('mobile')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-medium text-gray-700">PIN Code</label>
                            <input type="text" name="pin" value="{{ old('pin', optional($user->school)->pin ?? $user->pin) }}"
                                   class="w-full rounded-2xl border border-gray-200 px-4 py-3 text-sm outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100">
                            @error('pin')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label class="mb-2 block text-sm font-medium text-gray-700">Address</label>
                            <input type="text" name="address1" value="{{ old('address1', optional($user->school)->address1 ?? $user->address1) }}"
                                   class="w-full rounded-2xl border border-gray-200 px-4 py-3 text-sm outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100">
                            @error('address1')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-medium text-gray-700">City</label>
                            <input type="text" name="city" value="{{ old('city', optional($user->school)->city ?? $user->city) }}"
                                   class="w-full rounded-2xl border border-gray-200 px-4 py-3 text-sm outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100">
                            @error('city')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-medium text-gray-700">State</label>
                            <input type="text" name="state" value="{{ old('state', optional($user->school)->state ?? $user->state) }}"
                                   class="w-full rounded-2xl border border-gray-200 px-4 py-3 text-sm outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100">
                            @error('state')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="rounded-2xl border border-dashed border-gray-200 p-5">
                        <h4 class="text-sm font-semibold text-gray-900">Change Password</h4>
                        <p class="mt-1 text-sm text-gray-500">Leave these fields empty if you do not want to change the password.</p>

                        <div class="mt-4 grid grid-cols-1 gap-5 md:grid-cols-2">
                            <div>
                                <label class="mb-2 block text-sm font-medium text-gray-700">New Password</label>
                                <input type="password" name="password"
                                       class="w-full rounded-2xl border border-gray-200 px-4 py-3 text-sm outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100">
                                @error('password')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="mb-2 block text-sm font-medium text-gray-700">Confirm Password</label>
                                <input type="password" name="password_confirmation"
                                       class="w-full rounded-2xl border border-gray-200 px-4 py-3 text-sm outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100">
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                        <p class="text-sm text-gray-500">Changes are applied immediately to your school admin account.</p>
                        <button type="submit"
                                class="inline-flex items-center justify-center rounded-2xl bg-indigo-600 px-6 py-3 text-sm font-semibold text-white transition hover:bg-indigo-700">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection
