<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $customer = Auth::guard('customer')->user();
        
        $upcomingBookings = $customer->getUpcomingBookings();
        $pastBookings = $customer->getPastBookings()->take(5);
        $totalLessons = $customer->getTotalLessons();
        $totalSpent = $customer->getTotalSpent();
        
        // Get reviews to complete
        $pendingReviews = $customer->bookings()
            ->where('status', 'completed')
            ->whereDoesntHave('review')
            ->latest('booking_date')
            ->take(3)
            ->get();

        return view('customer.dashboard', compact(
            'customer',
            'upcomingBookings',
            'pastBookings',
            'totalLessons',
            'totalSpent',
            'pendingReviews'
        ));
    }
}
