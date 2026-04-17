<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Storage;

class SuperSettingController extends Controller
{
    public function index()
    {
        $setting = Setting::first();
        return view('super_admin.settings.index', compact('setting'));
    }

    public function update(Request $request)
    {
        // ✅ Validation
        $request->validate([
            'app_name' => 'nullable|string|max:255',
            'default_role' => 'nullable|in:student,teacher,parent',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $setting = Setting::first();

        if (!$setting) {
            $setting = new Setting();
        }

        /**
         * 🖼️ Logo Upload
         */
        if ($request->hasFile('logo')) {

            // Old delete
            if ($setting->logo && Storage::disk('public')->exists($setting->logo)) {
                Storage::disk('public')->delete($setting->logo);
            }

            $setting->logo = $request->file('logo')->store('settings', 'public');
        }

        /**
         * 🔥 Fill Data
         */
        $setting->app_name      = $request->app_name;
        $setting->default_role  = $request->default_role;
        $setting->mail_host     = $request->mail_host;
        $setting->mail_port     = $request->mail_port;
        $setting->mail_username = $request->mail_username;
        $setting->mail_password = $request->mail_password;

        $setting->sms_api       = $request->sms_api;
        $setting->sms_sender    = $request->sms_sender;

        // 🆕 NEW FEATURES
        $setting->theme = $request->theme ?? 'indigo';
        $setting->school_branding = $request->has('school_branding') ? 1 : 0;

        /**
         * 💾 Save
         */
        $setting->save();

        return back()->with('success', 'Settings Updated Successfully ✅');
    }
}