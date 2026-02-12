<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = Customer::withCount('bookings');
        if ($request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }
        if ($request->status === 'active') {
            $query->where('is_active', true);
        } elseif ($request->status === 'inactive') {
            $query->where('is_active', false);
        }
        $customers = $query->latest()->paginate(20);
        return view('admin.customers.index', compact('customers'));
    }

    public function show(Customer $customer)
    {
        $customer->loadCount('bookings');
        $bookings = $customer->bookings()->with(['service', 'package', 'location'])->latest()->limit(15)->get();
        return view('admin.customers.show', compact('customer', 'bookings'));
    }

    public function edit(Customer $customer)
    {
        return view('admin.customers.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'suburb' => 'nullable|string|max:100',
            'postcode' => 'nullable|string|max:10',
            'license_number' => 'nullable|string|max:50',
            'preferred_transmission' => 'required|in:auto,manual',
            'is_active' => 'boolean',
            'email_notifications' => 'boolean',
            'sms_notifications' => 'boolean',
        ]);
        $validated['is_active'] = $request->boolean('is_active');
        $validated['email_notifications'] = $request->boolean('email_notifications');
        $validated['sms_notifications'] = $request->boolean('sms_notifications');
        if ($request->filled('password')) {
            $request->validate(['password' => 'min:8|confirmed']);
            $validated['password'] = Hash::make($request->password);
        }
        $customer->update($validated);
        return redirect()->route('admin.customers.show', $customer)->with('success', 'Customer updated.');
    }
}
