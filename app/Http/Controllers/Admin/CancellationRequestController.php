<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CancellationRequest;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class CancellationRequestController extends Controller
{
    public function index(Request $request)
    {
        $query = CancellationRequest::with(['booking', 'customer']);
        if ($request->status) {
            $query->where('status', $request->status);
        }
        $requests = $query->latest()->paginate(20);
        $pendingCount = CancellationRequest::pending()->count();
        return view('admin.cancellation-requests.index', compact('requests', 'pendingCount'));
    }

    public function show(CancellationRequest $cancellationRequest)
    {
        $cancellationRequest->load(['booking.service', 'booking.package', 'customer']);
        return view('admin.cancellation-requests.show', compact('cancellationRequest'));
    }

    public function process(Request $request, CancellationRequest $cancellationRequest)
    {
        $request->validate([
            'action' => 'required|in:approve_refund,approve_no_refund,reject',
            'refund_amount' => 'nullable|numeric|min:0',
            'admin_notes' => 'nullable|string|max:500',
        ]);

        $booking = $cancellationRequest->booking;

        if ($request->action === 'reject') {
            $cancellationRequest->reject(Auth::id(), $request->admin_notes);
            return back()->with('success', 'Cancellation request rejected.');
        }

        $refundType = $request->action === 'approve_refund' ? ($request->refund_amount > 0 ? 'partial' : 'full') : 'none';
        $refundAmount = $request->refund_amount ?? ($request->action === 'approve_refund' ? $booking->amount : 0);

        $cancellationRequest->approve(Auth::id(), $refundType, $refundAmount, $request->admin_notes);

        $booking->cancel($cancellationRequest->reason);
        if ($booking->availabilitySlot) {
            $booking->availabilitySlot->decrementBookings();
        }

        if ($refundType !== 'none' && $refundAmount > 0 && $booking->stripe_charge_id) {
            try {
                $stripe = new \Stripe\StripeClient(config('services.stripe.secret'));
                $refund = $stripe->refunds->create([
                    'charge' => $booking->stripe_charge_id,
                    'amount' => (int) round($refundAmount * 100),
                    'reason' => 'requested_by_customer',
                ]);
                $cancellationRequest->markRefunded($refund->id);
            } catch (\Exception $e) {
                return back()->with('warning', 'Cancellation approved but refund failed: ' . $e->getMessage());
            }
        }

        return back()->with('success', 'Cancellation processed successfully.');
    }
}
