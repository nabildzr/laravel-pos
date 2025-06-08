<?php

namespace App\Http\Controllers;

use App\Models\BusinessSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BusinessSettingController extends Controller
{
    public function index()
    {
        $business = BusinessSetting::first();

        if (!$business) {
            $business = BusinessSetting::create([
                'name' =>  'Mini Cafe/Restaurant',
                'email' => 'info@example.com',
                'phone' => '123456789',
                'website' => 'https://example.com',
                'address' => 'Alamat Perusahaan',
                'receipt_footer' => 'Terima kasih atas kunjungan Anda',
            ]);
        }

        return view('settings.business', compact('business'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'website' => 'nullable|url|max:255',
            'address' => 'nullable|string',
            'receipt_footer' => 'nullable|string',
            'tax_number' => 'nullable|string|max:50',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $business = BusinessSetting::first();
        if (!$business) {
            $business = new BusinessSetting();
        }

        if ($request->hasFile('logo')) {
            if ($business->logo) {
                Storage::disk('public')->delete($business->logo);
            }
            $path = $request->file('logo')->store('business_logo', 'public');
            $business->logo = $path;
        }

        $business->name = $request->name;
        $business->email = $request->email;
        $business->phone = $request->phone;
        $business->website = $request->website;
        $business->address = $request->address;
        $business->receipt_footer = $request->receipt_footer;
        $business->tax_number = $request->tax_number;
        $business->save();

        return redirect()->route('business.settings')->with('success', 'Business information updated successfully');
    }
}
