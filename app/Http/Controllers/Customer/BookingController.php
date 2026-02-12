<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\RescheduleRequest;
use App\Models\CancellationRequest;
use App\Models\AvailabilitySlot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $customer = Auth::guard('customer')->user();
        
        $query = $customer->bookings()->with(['service', 'package', 'location', 'instructor']);
        
        // Filter by status
        if ($request->status && $request->status !== 'all') {
            if ($request->status === 'upcoming') {
                $query->whereIn('status', ['pending', 'confirmed'])
                      ->where('booking_date', '>=', now()->toDateString());
            } elseif ($request->status === 'past') {
                $query->where(function($q) {
                    $q->where('booking_date', '<', now()->toDateString())
                      ->orWhereIn('status', ['completed', 'cancelled', 'no_show']);
                });
            } else {
                $query->where('status', $request->status);
            }
        }
        
        $bookings = $query->orderByDesc('booking_date')
                         ->orderByDesc('booking_time')
                         ->paginate(10);
        
        return view('customer.bookings.index', compact('bookings'));
    }

    public function show(Booking $booking)
    {
        $customer = Auth::guard('customer')->user();
        
        if ($booking->customer_id !== $customer->id) {
            abort(403);
        }
        
        $booking->load(['service', 'package', 'location', 'instructor', 'review', 'rescheduleRequests', 'cancellationRequest']);
        
        return view('customer.bookings.show', compact('booking'));
    }

    public function showRescheduleForm(Booking $booking)
    {
        $customer = Auth::guard('customer')->user();
        
        if ($booking->customer_id !== $customer->id) {
            abort(403);
        }
        
        if (!$booking->canBeRescheduled()) {
            return back()->with('error', 'This booking cannot be rescheduled.');
        }
        
        // Get available slots for the next 30 days
        $availableSlots = AvailabilitySlot::where('location_id', $booking->location_id)
            ->where('date', '>', now()->toDateString())
            ->where('date', '<=', now()->addDays(30)->toDateString())
            ->where('is_available', true)
            ->where('is_blocked', false)
            ->whereRaw('current_bookings < max_bookings')
            ->orderBy('date')
            ->orderBy('start_time')
            ->get()
            ->groupBy(function($slot) {
                return $slot->date->format('Y-m-d');
            });
        
        return view('customer.bookings.reschedule', compact('booking', 'availableSlots'));
    }

    public function reschedule(Request $request, Booking $booking)
    {
        $customer = Auth::guard('customer')->user();
        
        if ($booking->customer_id !== $customer->id) {
            abort(403);
        }
        
        if (!$booking->canBeRescheduled()) {
            return back()->with('error', 'This booking cannot be rescheduled.');
        }
        
        $validated = $request->validate([
            'requested_date' => 'required|date|after:today',
            'slot_id' => 'nullable|exists:availability_slots,id',
            'reason' => 'nullable|string|max:500',
        ]);
        
        RescheduleRequest::create([
            'booking_id' => $booking->id,
            'customer_id' => $customer->id,
            'original_date' => $booking->booking_date,
            'original_time' => $booking->booking_time,
            'requested_date' => $validated['requested_date'],
            'new_slot_id' => $validated['slot_id'] ?? null,
            'reason' => $validated['reason'] ?? null,
        ]);
        
        return redirect()->route('customer.bookings.show', $booking)
            ->with('success', 'Reschedule request submitted. We will contact you shortly.');
    }

    public function showCancelForm(Booking $booking)
    {
        $customer = Auth::guard('customer')->user();
        
        if ($booking->customer_id !== $customer->id) {
            abort(403);
        }
        
        if (!$booking->canBeCancelled()) {
            return back()->with('error', 'This booking cannot be cancelled.');
        }
        
        // Check if there's already a pending cancellation request
        if ($booking->cancellationRequest && $booking->cancellationRequest->status === 'pending') {
            return back()->with('error', 'A cancellation request is already pending for this booking.');
        }
        
        return view('customer.bookings.cancel', compact('booking'));
    }

    public function cancel(Request $request, Booking $booking)
    {
        $customer = Auth::guard('customer')->user();
        
        if ($booking->customer_id !== $customer->id) {
            abort(403);
        }
        
        if (!$booking->canBeCancelled()) {
            return back()->with('error', 'This booking cannot be cancelled.');
        }
        
        $validated = $request->validate([
            'reason' => 'required|string|max:500',
        ]);
        
        CancellationRequest::create([
            'booking_id' => $booking->id,
            'customer_id' => $customer->id,
            'reason' => $validated['reason'],
        ]);
        
        return redirect()->route('customer.bookings.show', $booking)
            ->with('success', 'Cancellation request submitted. We will review and contact you shortly.');
    }

    public function rebook(Booking $booking)
    {
        $customer = Auth::guard('customer')->user();
        
        if ($booking->customer_id !== $customer->id) {
            abort(403);
        }
        
        // Redirect to booking page with pre-filled data
        $params = [];
        if ($booking->service_id) {
            $params['service'] = $booking->service_id;
        }
        if ($booking->package_id) {
            $params['package'] = $booking->package_id;
        }
        if ($booking->location_id) {
            $params['location'] = $booking->location_id;
        }
        
        return redirect()->route('book-online', $params);
    }
}
