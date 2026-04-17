@extends('layouts.super_admin')

@section('content')

<div class="max-w-6xl mx-auto p-4 md:p-6">

    <!-- Header -->
    <h1 class="text-2xl font-bold text-gray-800 mb-6">⚙️ System Settings</h1>

    <!-- Success -->
    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    <!-- Card -->
    <div class="bg-white rounded-2xl shadow-lg p-6">

        <form method="POST" action="{{ route('super_admin.settings.update') }}" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- App Name -->
                <div>
                    <label class="text-sm text-gray-600">App Name</label>
                    <input type="text" name="app_name"
                        value="{{ $setting->app_name ?? '' }}"
                        class="input">
                </div>

                <!-- Default Role -->
                <div>
                    <label class="text-sm text-gray-600">Default Role</label>
                    <select name="default_role" class="input">
                        <option value="student" {{ ($setting->default_role ?? '')=='student'?'selected':'' }}>Student</option>
                        <option value="teacher" {{ ($setting->default_role ?? '')=='teacher'?'selected':'' }}>Teacher</option>
                        <option value="parent" {{ ($setting->default_role ?? '')=='parent'?'selected':'' }}>Parent</option>
                    </select>
                </div>

                <!-- Logo -->
                <div>
                    <label class="text-sm text-gray-600">App Logo</label>
                    <input type="file" name="logo" class="input">

                    @if(!empty($setting->logo))
                        <img src="{{ asset('storage/'.$setting->logo) }}"
                             class="h-12 mt-2 rounded">
                    @endif
                </div>

                <!-- Mail -->
                <div>
                    <label class="text-sm text-gray-600">Mail Host</label>
                    <input type="text" name="mail_host"
                        value="{{ $setting->mail_host ?? '' }}"
                        class="input">
                </div>

                <!-- SMS -->
                <div>
                    <label class="text-sm text-gray-600">SMS API Key</label>
                    <input type="text" name="sms_api"
                        value="{{ $setting->sms_api ?? '' }}"
                        class="input">
                </div>

                <!-- 🎨 Theme -->
                <div>
                    <label class="text-sm text-gray-600">Default Theme</label>
                    <select name="theme" class="input">
                        <option value="indigo" {{ ($setting->theme ?? '')=='indigo'?'selected':'' }}>Indigo</option>
                        <option value="blue" {{ ($setting->theme ?? '')=='blue'?'selected':'' }}>Blue</option>
                        <option value="green" {{ ($setting->theme ?? '')=='green'?'selected':'' }}>Green</option>
                        <option value="red" {{ ($setting->theme ?? '')=='red'?'selected':'' }}>Red</option>
                    </select>
                </div>

                <!-- 🏫 Branding Toggle -->
                <div class="flex items-center justify-between bg-gray-50 p-4 rounded-lg">
                    <div>
                        <h3 class="text-sm font-semibold">School Branding</h3>
                        <p class="text-xs text-gray-500">Allow schools to use their own branding</p>
                    </div>

                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="school_branding" value="1"
                               {{ ($setting->school_branding ?? false) ? 'checked' : '' }}
                               class="sr-only peer">

                        <div class="w-11 h-6 bg-gray-200 rounded-full peer 
                                    peer-checked:bg-indigo-600 
                                    after:content-[''] after:absolute after:top-[2px] after:left-[2px]
                                    after:bg-white after:border after:rounded-full after:h-5 after:w-5
                                    after:transition-all peer-checked:after:translate-x-full">
                        </div>
                    </label>
                </div>

            </div>

            <!-- Submit -->
            <div class="mt-8 text-right">
                <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg shadow">
                    💾 Save Settings
                </button>
            </div>

        </form>

    </div>

</div>

<style>
.input {
    width: 100%;
    margin-top: 5px;
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

@endsection