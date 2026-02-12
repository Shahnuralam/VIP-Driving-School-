<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RescheduleRequest;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RescheduleRequestController extends Controller
{
    public function index(Request $request)
    {
        $query = RescheduleRequest::with(['booking', 'customer', 'newSlot']);
        if ($request->status) {
            $query->where('status', $request->status);
        }
        $requests = $query->latest()->paginate(20);
        $pendingCount = RescheduleRequest::pending()->count();
        return view('admin.reschedule-requests.index', compact('requests', 'pendingCount'));
    }

    public function show(RescheduleRequest $rescheduleRequest)
    {
        $rescheduleRequest->load(['booking.service', 'booking.package', 'booking.location', 'customer', 'newSlot']);
        return view('admin.reschedule-requests.show', compact('rescheduleRequest'));
    }

    public function approve(Request $request, RescheduleRequest $rescheduleRequest)
    {
        $request->validate(['admin_notes' => 'nullable|string|max:500']);
        $booking = $rescheduleRequest->booking;
        if ($rescheduleRequest->new_slot_id) {
            $slot = $rescheduleRequest->newSlot;
            $booking->availabilitySlot?->decrementBookings();
            $booking->update([
                'booking_date' => $slot->date,
                'booking_time' => $slot->start_time,
                'availability_slot_id' => $slot->id,
            ]);
            $slot->increment('current_bookings');
        } else {
            $booking->update([
                'booking_date' => $rescheduleRequest->requested_date,
                'booking_time' => $rescheduleRequest->requested_time,
            ]);
        }
        $rescheduleRequest->approve(Auth::id(), $request->admin_notes);
        return back()->with('success', 'Reschedule approved and booking updated.');
    }

    public function reject(Request $request, RescheduleRequest $rescheduleRequest)
    {
        $request->validate(['admin_notes' => 'nullable|string|max:500']);
        $rescheduleRequest->reject(Auth::id(), $request->admin_notes);
        return back()->with('success', 'Reschedule request rejected.');
    }
}
