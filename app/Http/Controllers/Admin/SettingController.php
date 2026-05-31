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
        ]);

        foreach ($validated as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        return redirect()->route('admin.settings')->with('success', 'Settings updated successfully!');
    }
}
