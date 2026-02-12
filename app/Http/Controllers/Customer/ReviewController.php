<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function index()
    {
        $customer = Auth::guard('customer')->user();
        
        $reviews = $customer->reviews()
            ->with(['booking', 'service', 'instructor'])
            ->latest()
            ->paginate(10);
        
        return view('customer.reviews.index', compact('reviews'));
    }

    public function create(Booking $booking)
    {
        $customer = Auth::guard('customer')->user();
        
        if ($booking->customer_id !== $customer->id) {
            abort(403);
        }
        
        if (!$booking->canBeReviewed()) {
            return back()->with('error', 'You cannot leave a review for this booking.');
        }
        
        $booking->load(['service', 'package', 'instructor']);
        
        return view('customer.reviews.create', compact('booking'));
    }

    public function store(Request $request, Booking $booking)
    {
        $customer = Auth::guard('customer')->user();
        
        if ($booking->customer_id !== $customer->id) {
            abort(403);
        }
        
        if (!$booking->canBeReviewed()) {
            return back()->with('error', 'You cannot leave a review for this booking.');
        }
        
        $validated = $request->validate([
            'overall_rating' => 'required|integer|min:1|max:5',
            'instructor_rating' => 'nullable|integer|min:1|max:5',
            'vehicle_rating' => 'nullable|integer|min:1|max:5',
            'value_rating' => 'nullable|integer|min:1|max:5',
            'title' => 'nullable|string|max:100',
            'content' => 'required|string|min:10|max:2000',
        ]);
        
        Review::create([
            'booking_id' => $booking->id,
            'customer_id' => $customer->id,
            'service_id' => $booking->service_id,
            'package_id' => $booking->package_id,
            'instructor_id' => $booking->instructor_id,
            'customer_name' => $customer->name,
            'customer_email' => $customer->email,
            'customer_location' => $customer->suburb,
            'overall_rating' => $validated['overall_rating'],
            'instructor_rating' => $validated['instructor_rating'] ?? null,
            'vehicle_rating' => $validated['vehicle_rating'] ?? null,
            'value_rating' => $validated['value_rating'] ?? null,
            'title' => $validated['title'] ?? null,
            'content' => $validated['content'],
            'status' => 'pending',
        ]);
        
        return redirect()->route('customer.bookings.show', $booking)
            ->with('success', 'Thank you for your review! It will be published after moderation.');
    }
}
