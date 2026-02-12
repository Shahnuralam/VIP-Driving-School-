<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Service;
use App\Models\Package;
use App\Models\Location;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index(Request $request)
    {
        $query = Coupon::withCount('usages');

        if ($request->status === 'active') {
            $query->where('is_active', true);
        } elseif ($request->status === 'inactive') {
            $query->where('is_active', false);
        } elseif ($request->status === 'expired') {
            $query->where('expires_at', '<', now());
        }

        if ($request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('code', 'like', "%{$search}%")
                  ->orWhere('name', 'like', "%{$search}%");
            });
        }

        $coupons = $query->latest()->paginate(15);
        
        return view('admin.coupons.index', compact('coupons'));
    }

    public function create()
    {
        $services = Service::active()->ordered()->get();
        $packages = Package::active()->ordered()->get();
        $locations = Location::active()->ordered()->get();
        return view('admin.coupons.create', compact('services', 'packages', 'locations'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:coupons,code',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0',
            'min_order_amount' => 'nullable|numeric|min:0',
            'max_discount_amount' => 'nullable|numeric|min:0',
            'applicable_services' => 'nullable|array',
            'applicable_packages' => 'nullable|array',
            'applicable_locations' => 'nullable|array',
            'first_booking_only' => 'boolean',
            'usage_limit' => 'nullable|integer|min:1',
            'usage_limit_per_customer' => 'required|integer|min:1',
            'starts_at' => 'nullable|date',
            'expires_at' => 'nullable|date|after:starts_at',
            'is_active' => 'boolean',
        ]);

        $validated['first_booking_only'] = $request->boolean('first_booking_only');
        $validated['is_active'] = $request->boolean('is_active', true);

        Coupon::create($validated);

        return redirect()->route('admin.coupons.index')
            ->with('success', 'Coupon created successfully.');
    }

    public function show(Coupon $coupon)
    {
        $coupon->load(['usages' => fn($q) => $q->with(['customer', 'booking'])->latest()->limit(20)]);
        return view('admin.coupons.show', compact('coupon'));
    }

    public function edit(Coupon $coupon)
    {
        $services = Service::active()->ordered()->get();
        $packages = Package::active()->ordered()->get();
        $locations = Location::active()->ordered()->get();
        return view('admin.coupons.edit', compact('coupon', 'services', 'packages', 'locations'));
    }

    public function update(Request $request, Coupon $coupon)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:coupons,code,' . $coupon->id,
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0',
            'min_order_amount' => 'nullable|numeric|min:0',
            'max_discount_amount' => 'nullable|numeric|min:0',
            'applicable_services' => 'nullable|array',
            'applicable_packages' => 'nullable|array',
            'applicable_locations' => 'nullable|array',
            'first_booking_only' => 'boolean',
            'usage_limit' => 'nullable|integer|min:1',
            'usage_limit_per_customer' => 'required|integer|min:1',
            'starts_at' => 'nullable|date',
            'expires_at' => 'nullable|date',
            'is_active' => 'boolean',
        ]);

        $validated['first_booking_only'] = $request->boolean('first_booking_only');
        $validated['is_active'] = $request->boolean('is_active');

        $coupon->update($validated);

        return redirect()->route('admin.coupons.index')
            ->with('success', 'Coupon updated successfully.');
    }

    public function destroy(Coupon $coupon)
    {
        $coupon->delete();
        return redirect()->route('admin.coupons.index')
            ->with('success', 'Coupon deleted successfully.');
    }
}
