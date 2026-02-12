<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function edit()
    {
        $customer = Auth::guard('customer')->user();
        return view('customer.profile.edit', compact('customer'));
    }

    public function update(Request $request)
    {
        $customer = Auth::guard('customer')->user();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'suburb' => 'nullable|string|max:100',
            'postcode' => 'nullable|string|max:10',
            'date_of_birth' => 'nullable|date|before:today',
            'license_number' => 'nullable|string|max:50',
            'preferred_transmission' => 'required|in:auto,manual',
            'email_notifications' => 'boolean',
            'sms_notifications' => 'boolean',
        ]);
        
        $validated['email_notifications'] = $request->boolean('email_notifications');
        $validated['sms_notifications'] = $request->boolean('sms_notifications');
        
        $customer->update($validated);
        
        return back()->with('success', 'Profile updated successfully.');
    }

    public function updatePhoto(Request $request)
    {
        $request->validate([
            'profile_photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        
        $customer = Auth::guard('customer')->user();
        
        // Delete old photo
        if ($customer->profile_photo) {
            Storage::disk('public')->delete($customer->profile_photo);
        }
        
        // Store new photo
        $path = $request->file('profile_photo')->store('customer-photos', 'public');
        $customer->update(['profile_photo' => $path]);
        
        return back()->with('success', 'Profile photo updated successfully.');
    }

    public function showChangePasswordForm()
    {
        return view('customer.profile.change-password');
    }

    public function changePassword(Request $request)
    {
        $customer = Auth::guard('customer')->user();
        
        $validated = $request->validate([
            'current_password' => 'required',
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);
        
        if (!Hash::check($validated['current_password'], $customer->password)) {
            return back()->withErrors(['current_password' => 'The current password is incorrect.']);
        }
        
        $customer->update([
            'password' => Hash::make($validated['password']),
        ]);
        
        return back()->with('success', 'Password changed successfully.');
    }
}
