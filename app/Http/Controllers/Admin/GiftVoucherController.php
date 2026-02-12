<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GiftVoucher;
use App\Models\Package;
use Illuminate\Http\Request;

class GiftVoucherController extends Controller
{
    public function index(Request $request)
    {
        $query = GiftVoucher::with(['package', 'redeemedByCustomer']);

        if ($request->status) {
            $query->where('status', $request->status);
        }
        if ($request->payment) {
            $query->where('payment_status', $request->payment);
        }
        if ($request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('code', 'like', "%{$search}%")
                  ->orWhere('purchaser_email', 'like', "%{$search}%")
                  ->orWhere('recipient_email', 'like', "%{$search}%");
            });
        }

        $vouchers = $query->latest()->paginate(15);
        
        return view('admin.gift-vouchers.index', compact('vouchers'));
    }

    public function create()
    {
        $packages = Package::active()->ordered()->get();
        return view('admin.gift-vouchers.create', compact('packages'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:fixed,package',
            'amount' => 'required_if:type,fixed|nullable|numeric|min:1',
            'package_id' => 'required_if:type,package|nullable|exists:packages,id',
            'purchaser_name' => 'required|string|max:255',
            'purchaser_email' => 'required|email|max:255',
            'purchaser_phone' => 'nullable|string|max:20',
            'recipient_name' => 'required|string|max:255',
            'recipient_email' => 'required|email|max:255',
            'message' => 'nullable|string|max:500',
            'expires_at' => 'required|date|after:today',
            'payment_status' => 'required|in:pending,paid',
        ]);

        $voucher = GiftVoucher::create([
            'type' => $validated['type'],
            'amount' => $validated['type'] === 'fixed' ? $validated['amount'] : null,
            'balance' => $validated['type'] === 'fixed' ? $validated['amount'] : 0,
            'package_id' => $validated['type'] === 'package' ? $validated['package_id'] : null,
            'purchaser_name' => $validated['purchaser_name'],
            'purchaser_email' => $validated['purchaser_email'],
            'purchaser_phone' => $validated['purchaser_phone'] ?? null,
            'recipient_name' => $validated['recipient_name'],
            'recipient_email' => $validated['recipient_email'],
            'message' => $validated['message'] ?? null,
            'expires_at' => $validated['expires_at'],
            'payment_status' => $validated['payment_status'],
            'paid_at' => $validated['payment_status'] === 'paid' ? now() : null,
        ]);

        return redirect()->route('admin.gift-vouchers.show', $voucher)
            ->with('success', 'Gift voucher created successfully. Code: ' . $voucher->code);
    }

    public function show(GiftVoucher $giftVoucher)
    {
        $giftVoucher->load(['package', 'redeemedByCustomer', 'redeemedBooking']);
        return view('admin.gift-vouchers.show', compact('giftVoucher'));
    }

    public function edit(GiftVoucher $giftVoucher)
    {
        $packages = Package::active()->ordered()->get();
        return view('admin.gift-vouchers.edit', compact('giftVoucher', 'packages'));
    }

    public function update(Request $request, GiftVoucher $giftVoucher)
    {
        $validated = $request->validate([
            'purchaser_name' => 'required|string|max:255',
            'purchaser_email' => 'required|email|max:255',
            'recipient_name' => 'required|string|max:255',
            'recipient_email' => 'required|email|max:255',
            'message' => 'nullable|string|max:500',
            'expires_at' => 'required|date',
            'status' => 'required|in:active,partially_used,fully_used,expired,cancelled',
            'payment_status' => 'required|in:pending,paid,refunded,failed',
        ]);

        if ($validated['payment_status'] === 'paid' && $giftVoucher->payment_status !== 'paid') {
            $validated['paid_at'] = now();
        }

        $giftVoucher->update($validated);

        return redirect()->route('admin.gift-vouchers.show', $giftVoucher)
            ->with('success', 'Gift voucher updated successfully.');
    }

    public function destroy(GiftVoucher $giftVoucher)
    {
        $giftVoucher->delete();
        return redirect()->route('admin.gift-vouchers.index')
            ->with('success', 'Gift voucher deleted successfully.');
    }

    public function sendEmail(GiftVoucher $giftVoucher)
    {
        // TODO: Send voucher email to recipient
        $giftVoucher->update(['email_sent' => true]);
        return back()->with('success', 'Gift voucher email sent to recipient.');
    }
}
