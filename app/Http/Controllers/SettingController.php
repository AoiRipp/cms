<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function edit()
    {
        $settings = Setting::all()->pluck('value', 'key');
        return view('dashboard.settings.edit', compact('settings'));
    }

    public function update(Request $request)
    {
        // Banner upload
        if ($request->hasFile('banner')) {
            $paths = [];
            foreach ($request->file('banner') as $file) {
                $paths[] = $file->store('banners', 'public');
            }
            Setting::setValue('banner', $paths);
        }

        // Contact Info
        Setting::setValue('contact_phone', $request->contact_phone);
        Setting::setValue('contact_email', $request->contact_email);
        Setting::setValue('contact_address', $request->contact_address);

        return back()->with('success', 'Settings updated successfully.');
    }
}
