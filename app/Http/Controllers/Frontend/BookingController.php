<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Package;
use App\Models\Location;
use App\Models\AvailabilitySlot;
use App\Models\Booking;
use App\Models\InfoCard;
use App\Models\ServiceCategory;
use App\Models\Setting;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use App\Mail\BookingConfirmation;
use App\Mail\AdminBookingNotification;
use Illuminate\Support\Facades\Mail;

class BookingController extends Controller
{
    public function index()
    {
        $services = Service::active()
            ->with(['category', 'location'])
            ->ordered()
            ->get();

        $categories = ServiceCategory::active()
            ->ordered()
            ->get();

        $packages = Package::active()
            ->ordered()
            ->get();

        $locations = Location::active()
            ->ordered()
            ->get();

        $infoCards = InfoCard::active()
            ->forPage('book-online')
            ->ordered()
            ->get();

        $settings = Setting::pluck('value', 'key')->toArray();

        return view('frontend.booking.index', compact('services', 'categories', 'packages', 'locations', 'infoCards', 'settings'));
    }

    public function getSlots(Request $request)
    {
        $date = $request->get('date');
        $locationId = $request->get('location_id');
        $serviceId = $request->get('service_id');

        if (!$date) {
            return response()->json(['slots' => []]);
        }

        $query = AvailabilitySlot::where('date', $date)
            ->where('is_available', true)
            ->where(function($q) {
                $q->where('current_bookings', '<', \DB::raw('max_bookings'))
                  ->orWhereNull('max_bookings');
            });

        if ($locationId) {
            $query->where(function ($q) use ($locationId) {
                $q->where('location_id', $locationId)
                    ->orWhereNull('location_id');
            });
        }

        if ($serviceId) {
            $query->where(function ($q) use ($serviceId) {
                $q->where('service_id', $serviceId)
                    ->orWhereNull('service_id');
            });
        }

        $slots = $query->orderBy('start_time')->get();

        $formattedSlots = $slots->map(function ($slot) {
            return [
                'id' => $slot->id,
                'start_time' => Carbon::parse($slot->start_time)->format('g:i A'),
                'end_time' => Carbon::parse($slot->end_time)->format('g:i A'),
                'is_available' => $slot->hasAvailability(),
            ];
        });

        return response()->json(['slots' => $formattedSlots]);
    }

    public function getAvailableSlots(Request $request)
    {
        $request->validate([
            'service_id' => 'nullable|exists:services,id',
            'location_id' => 'nullable|exists:locations,id',
            'month' => 'required|date_format:Y-m',
        ]);

        $startDate = Carbon::parse($request->month)->startOfMonth();
        $endDate = Carbon::parse($request->month)->endOfMonth();

        $query = AvailabilitySlot::available()
            ->whereBetween('date', [$startDate, $endDate]);

        if ($request->filled('service_id')) {
            $query->where(function ($q) use ($request) {
                $q->where('service_id', $request->service_id)
                    ->orWhereNull('service_id');
            });
        }

        if ($request->filled('location_id')) {
            $query->where(function ($q) use ($request) {
                $q->where('location_id', $request->location_id)
                    ->orWhereNull('location_id');
            });
        }

        $slots = $query->orderBy('date')
            ->orderBy('start_time')
            ->get()
            ->groupBy(function ($slot) {
                return $slot->date->format('Y-m-d');
            });

        $events = [];
        foreach ($slots as $date => $daySlots) {
            $events[] = [
                'date' => $date,
                'slots' => $daySlots->map(function ($slot) {
                    return [
                        'id' => $slot->id,
                        'time' => $slot->time_range,
                        'remaining' => $slot->remaining,
                    ];
                }),
            ];
        }

        return response()->json($events);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_id' => 'nullable|exists:services,id',
            'package_id' => 'nullable|exists:packages,id',
            'location_id' => 'nullable|exists:locations,id',
            'slot_id' => 'nullable|exists:availability_slots,id',
            'booking_date' => 'required|date',
            'booking_time' => 'required',
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|max:191',
            'phone' => 'required|string|max:50',
            'licence_number' => 'nullable|string|max:100',
            'pickup_address' => 'nullable|string|max:500',
            'transmission' => 'required|in:auto,manual',
            'notes' => 'nullable|string|max:1000',
            'payment_method' => 'required|string',
        ]);

        // Get the availability slot if provided
        $slot = null;
        if ($validated['slot_id']) {
            $slot = AvailabilitySlot::find($validated['slot_id']);
            if ($slot && !$slot->hasAvailability()) {
                return back()->withErrors(['slot_id' => 'This time slot is no longer available.']);
            }
        }

        // Calculate amount
        $amount = 0;
        $serviceName = 'Driving Lesson';
        if (!empty($validated['service_id'])) {
            $service = Service::find($validated['service_id']);
            $amount = $service->price;
            $serviceName = $service->name;
        } elseif (!empty($validated['package_id'])) {
            $package = Package::find($validated['package_id']);
            $amount = $package->price;
            $serviceName = $package->name;
        }

        // If amount is 0, show error
        if ($amount <= 0) {
            return back()->withErrors(['service_id' => 'Please select a valid service or package.']);
        }

        // Process Stripe payment
        try {
            Stripe::setApiKey(config('services.stripe.secret'));

            $customerName = $validated['first_name'] . ' ' . $validated['last_name'];

            $paymentIntent = PaymentIntent::create([
                'amount' => (int)($amount * 100), // Convert to cents
                'currency' => 'aud',
                'payment_method' => $validated['payment_method'],
                'confirm' => true,
                'automatic_payment_methods' => [
                    'enabled' => true,
                    'allow_redirects' => 'never',
                ],
                'description' => "Booking: {$serviceName} - {$customerName}",
                'receipt_email' => $validated['email'],
                'metadata' => [
                    'customer_name' => $customerName,
                    'customer_email' => $validated['email'],
                    'service' => $serviceName,
                    'booking_date' => $validated['booking_date'],
                    'booking_time' => $validated['booking_time'],
                ],
            ]);

            if ($paymentIntent->status !== 'succeeded') {
                return back()->withErrors(['payment' => 'Payment failed. Please try again.']);
            }

            // Create booking
            $booking = Booking::create([
                'service_id' => $validated['service_id'] ?? null,
                'package_id' => $validated['package_id'] ?? null,
                'location_id' => $validated['location_id'] ?? ($slot ? $slot->location_id : null),
                'availability_slot_id' => $slot ? $slot->id : null,
                'customer_name' => $customerName,
                'customer_email' => $validated['email'],
                'customer_phone' => $validated['phone'],
                'customer_license' => $validated['licence_number'] ?? null,
                'pickup_address' => $validated['pickup_address'] ?? null,
                'booking_date' => $validated['booking_date'],
                'booking_time' => $validated['booking_time'],
                'transmission_type' => $validated['transmission'],
                'status' => 'confirmed',
                'amount' => $amount,
                'payment_status' => 'paid',
                'stripe_payment_intent_id' => $paymentIntent->id,
                'paid_at' => now(),
                'notes' => $validated['notes'] ?? null,
            ]);

            // Increment slot bookings if slot exists
            if ($slot) {
                $slot->incrementBookings();
            }

            // Send confirmation email to customer
            try {
                Mail::to($booking->customer_email)->send(new BookingConfirmation($booking));
            } catch (\Exception $e) {
                \Log::error('Failed to send booking confirmation email: ' . $e->getMessage());
            }

            // Send notification email to admin
            try {
                $adminEmail = Setting::where('key', 'admin_email')->value('value') ?? config('mail.from.address');
                if ($adminEmail) {
                    Mail::to($adminEmail)->send(new AdminBookingNotification($booking, 'new'));
                }
            } catch (\Exception $e) {
                \Log::error('Failed to send admin booking notification: ' . $e->getMessage());
            }

            return redirect()->route('booking.confirmation', $booking->booking_reference);

        } catch (\Stripe\Exception\CardException $e) {
            return back()->withErrors(['payment' => 'Card declined: ' . $e->getMessage()]);
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            return back()->withErrors(['payment' => 'Invalid payment request. Please try again.']);
        } catch (\Exception $e) {
            \Log::error('Booking payment error: ' . $e->getMessage());
            return back()->withErrors(['payment' => 'Payment error occurred. Please try again.']);
        }
    }

    public function confirmation($reference)
    {
        $booking = Booking::where('booking_reference', $reference)
            ->with(['service', 'package', 'location'])
            ->firstOrFail();

        return view('frontend.booking.confirmation', compact('booking'));
    }
}
