<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display settings page.
     */
    public function index()
    {
        return view('admin.settings');
    }

    /**
     * Update settings in the database.
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'tagline' => 'required|string|max:255',
            'whatsapp_number' => 'required|string|max:50',
            'phone' => 'required|string|max:50',
            'email' => 'required|email|max:255',
            'address' => 'required|string',
            'gst_number' => 'required|string|max:50',
            'site_logo' => 'nullable|image|max:2048',
        ]);

        foreach ($validated as $key => $value) {
            if ($key === 'site_logo') continue;
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        if ($request->hasFile('site_logo')) {
            $oldLogo = Setting::get('site_logo');
            if ($oldLogo && !str_starts_with($oldLogo, 'http')) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($oldLogo);
            }
            $logoPath = $request->file('site_logo')->store('settings', 'public');
            @chmod(storage_path('app/public/' . $logoPath), 0644);
            Setting::updateOrCreate(
                ['key' => 'site_logo'],
                ['value' => $logoPath]
            );
        }

        return redirect()->route('admin.settings')->with('success', 'Settings updated successfully!');
    }
}
