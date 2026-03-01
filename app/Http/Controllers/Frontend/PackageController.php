<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\InfoCard;
use App\Models\Faq;
use App\Models\Booking;
use App\Models\Setting;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use App\Mail\BookingConfirmation;
use App\Mail\AdminBookingNotification;
use Illuminate\Support\Facades\Mail;

class PackageController extends Controller
{
    public function index()
    {
        $packages = Package::active()
            ->ordered()
            ->get();

        $infoCards = InfoCard::active()
            ->forPage('lesson-packages')
            ->ordered()
            ->get();

        $faqs = Faq::active()
            ->where('category', 'packages')
            ->orWhere('category', 'general')
            ->ordered()
            ->limit(6)
            ->get();

        return view('frontend.packages.index', compact('packages', 'infoCards', 'faqs'));
    }

    public function checkout(Request $request)
    {
        $packageId = $request->get('package_id');
        $package = Package::findOrFail($packageId);
        $customer = auth('customer')->user();

        return view('frontend.packages.checkout', compact('package', 'customer'))->render();
    }

    public function purchase(Request $request)
    {
        $validated = $request->validate([
            'package_id' => 'required|exists:packages,id',
            'payment_method' => 'required|string',
        ]);

        $package = Package::findOrFail($validated['package_id']);
        $customer = auth('customer')->user();

        // Process Stripe payment
        try {
            Stripe::setApiKey(config('services.stripe.secret'));

            $paymentIntent = PaymentIntent::create([
                'amount' => (int)($package->price * 100), // Convert to cents
                'currency' => 'aud',
                'payment_method' => $validated['payment_method'],
                'confirm' => true,
                'return_url' => route('lesson-packages'),
                'description' => "Package Purchase: {$package->name} - {$customer->name}",
                'receipt_email' => $customer->email,
                'metadata' => [
                    'customer_id' => $customer->id,
                    'customer_name' => $customer->name,
                    'customer_email' => $customer->email,
                    'package_id' => $package->id,
                    'package_name' => $package->name,
                ],
            ]);

            if ($paymentIntent->status !== 'succeeded') {
                return response()->json([
                    'success' => false,
                    'message' => 'Payment failed. Please try again.'
                ], 400);
            }

            // Create booking record
            $booking = Booking::create([
                'customer_id' => $customer->id,
                'package_id' => $package->id,
                'customer_name' => $customer->name,
                'customer_email' => $customer->email,
                'customer_phone' => $customer->phone ?? '',
                'status' => 'confirmed',
                'amount' => $package->price,
                'payment_status' => 'paid',
                'stripe_payment_intent_id' => $paymentIntent->id,
                'paid_at' => now(),
                'booking_date' => now()->format('Y-m-d'),
                'booking_time' => now()->format('H:i:s'),
            ]);

            // Send confirmation email to customer
            try {
                Mail::to($booking->customer_email)->send(new BookingConfirmation($booking));
            } catch (\Exception $e) {
                \Log::error('Failed to send package purchase confirmation email: ' . $e->getMessage());
            }

            // Send notification email to admin
            try {
                $adminEmail = Setting::where('key', 'admin_email')->value('value') ?? config('mail.from.address');
                if ($adminEmail) {
                    Mail::to($adminEmail)->send(new AdminBookingNotification($booking, 'new'));
                }
            } catch (\Exception $e) {
                \Log::error('Failed to send admin package purchase notification: ' . $e->getMessage());
            }

            return response()->json([
                'success' => true,
                'message' => 'Package purchased successfully!',
                'redirect' => route('booking.confirmation', $booking->booking_reference)
            ]);

        } catch (\Stripe\Exception\CardException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Card declined: ' . $e->getMessage()
            ], 400);
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid payment request. Please try again.'
            ], 400);
        } catch (\Exception $e) {
            \Log::error('Package purchase error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Payment error occurred. Please try again.'
            ], 500);
        }
    }
}
