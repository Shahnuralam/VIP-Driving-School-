<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Service;
use App\Models\Location;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Mail\BookingStatusUpdate;
use App\Mail\AdminBookingNotification;
use Illuminate\Support\Facades\Mail;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with(['service', 'package', 'location']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by payment status
        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->where('booking_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->where('booking_date', '<=', $request->date_to);
        }

        // Filter by service
        if ($request->filled('service_id')) {
            $query->where('service_id', $request->service_id);
        }

        // Filter by location
        if ($request->filled('location_id')) {
            $query->where('location_id', $request->location_id);
        }

        // Search by customer name, email, or reference
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('customer_name', 'like', "%{$search}%")
                    ->orWhere('customer_email', 'like', "%{$search}%")
                    ->orWhere('booking_reference', 'like', "%{$search}%");
            });
        }

        $bookings = $query->orderByDesc('booking_date')
            ->orderByDesc('booking_time')
            ->paginate(20);

        $services = Service::active()->ordered()->get();
        $locations = Location::active()->ordered()->get();

        return view('admin.bookings.index', compact('bookings', 'services', 'locations'));
    }

    public function pending()
    {
        $bookings = Booking::with(['service', 'package', 'location'])
            ->pending()
            ->orderBy('booking_date')
            ->orderBy('booking_time')
            ->paginate(20);

        return view('admin.bookings.pending', compact('bookings'));
    }

    public function calendar()
    {
        return view('admin.bookings.calendar');
    }

    public function calendarEvents(Request $request)
    {
        $start = Carbon::parse($request->start);
        $end = Carbon::parse($request->end);

        $bookings = Booking::with(['service', 'location'])
            ->whereBetween('booking_date', [$start, $end])
            ->get();

        $events = $bookings->map(function ($booking) {
            $color = match ($booking->status) {
                'pending' => '#ffc107',
                'confirmed' => '#17a2b8',
                'completed' => '#28a745',
                'cancelled' => '#dc3545',
                'no_show' => '#6c757d',
                default => '#007bff',
            };

            return [
                'id' => $booking->id,
                'title' => $booking->customer_name . ' - ' . ($booking->service->name ?? 'Package'),
                'start' => $booking->booking_date->format('Y-m-d') . 'T' . Carbon::parse($booking->booking_time)->format('H:i:s'),
                'backgroundColor' => $color,
                'borderColor' => $color,
                'extendedProps' => [
                    'reference' => $booking->booking_reference,
                    'status' => $booking->status,
                    'customer_email' => $booking->customer_email,
                    'customer_phone' => $booking->customer_phone,
                    'amount' => $booking->formatted_amount,
                ],
            ];
        });

        return response()->json($events);
    }

    public function show(Booking $booking)
    {
        $booking->load(['service', 'package', 'location', 'availabilitySlot']);

        return view('admin.bookings.show', compact('booking'));
    }

    public function updateStatus(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,completed,cancelled,no_show',
            'admin_notes' => 'nullable|string',
            'cancellation_reason' => 'nullable|string|required_if:status,cancelled',
            'send_notification' => 'boolean',
        ]);

        $previousStatus = $booking->status;

        $updateData = [
            'status' => $validated['status'],
            'admin_notes' => $validated['admin_notes'] ?? $booking->admin_notes,
        ];

        if ($validated['status'] === 'cancelled') {
            $updateData['cancellation_reason'] = $validated['cancellation_reason'];
            $updateData['cancelled_at'] = now();

            // Decrement availability slot if applicable
            if ($booking->availabilitySlot) {
                $booking->availabilitySlot->decrementBookings();
            }
        }

        $booking->update($updateData);

        // Send email notification if requested and status actually changed
        if (($request->input('send_notification', true)) && $previousStatus !== $validated['status']) {
            try {
                Mail::to($booking->customer_email)->send(new BookingStatusUpdate($booking, $previousStatus));
            } catch (\Exception $e) {
                \Log::error('Failed to send booking status update email: ' . $e->getMessage());
            }
        }

        return redirect()->back()
            ->with('success', 'Booking status updated successfully.');
    }

    public function destroy(Booking $booking)
    {
        // Only allow deletion of cancelled bookings
        if ($booking->status !== 'cancelled') {
            return redirect()->back()
                ->with('error', 'Only cancelled bookings can be deleted.');
        }

        $booking->delete();

        return redirect()->route('admin.bookings.index')
            ->with('success', 'Booking deleted successfully.');
    }

    public function export(Request $request)
    {
        $query = Booking::with(['service', 'package', 'location']);

        // Apply same filters as index
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date_from')) {
            $query->where('booking_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->where('booking_date', '<=', $request->date_to);
        }

        $bookings = $query->orderByDesc('booking_date')->get();

        $filename = 'bookings_' . date('Y-m-d_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($bookings) {
            $file = fopen('php://output', 'w');

            // Header row
            fputcsv($file, [
                'Reference',
                'Customer Name',
                'Email',
                'Phone',
                'Service',
                'Location',
                'Date',
                'Time',
                'Status',
                'Amount',
                'Payment Status',
                'Created At',
            ]);

            foreach ($bookings as $booking) {
                fputcsv($file, [
                    $booking->booking_reference,
                    $booking->customer_name,
                    $booking->customer_email,
                    $booking->customer_phone,
                    $booking->service?->name ?? 'Package',
                    $booking->location?->name ?? 'N/A',
                    $booking->booking_date->format('Y-m-d'),
                    Carbon::parse($booking->booking_time)->format('H:i'),
                    ucfirst($booking->status),
                    $booking->amount,
                    ucfirst($booking->payment_status),
                    $booking->created_at->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
