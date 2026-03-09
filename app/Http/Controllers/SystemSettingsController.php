<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SystemSettingsController extends Controller
{
    public function index()
    {
        $settings = [
            'clinic_name' => Setting::getValue('clinic_name', 'ClinicEase'),
            'clinic_email' => Setting::getValue('clinic_email', 'contact@clinic.com'),
            'clinic_phone' => Setting::getValue('clinic_phone', '+263 77 123 456'),
            'clinic_address' => Setting::getValue('clinic_address', 'Harare, Zimbabwe'),
        ];
        return view('admin.settings', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'clinic_name' => 'required|string|max:255',
            'clinic_email' => 'required|email',
            'clinic_phone' => 'required|string',
            'clinic_address' => 'required|string',
        ]);

        foreach ($validated as $key => $value) {
            Setting::setValue($key, $value);
        }

        return back()->with('success', 'System settings updated successfully.');
    }
}
