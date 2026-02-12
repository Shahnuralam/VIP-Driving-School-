<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Service;
use App\Models\Package;
use App\Models\Location;
use App\Models\ContactSubmission;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Today's stats
        $todayBookings = Booking::today()->count();
        $todayRevenue = Booking::today()->paid()->sum('amount');

        // This week stats
        $weekBookings = Booking::thisWeek()->count();
        $weekRevenue = Booking::thisWeek()->paid()->sum('amount');

        // This month stats
        $monthBookings = Booking::thisMonth()->count();
        $monthRevenue = Booking::thisMonth()->paid()->sum('amount');

        // Pending actions
        $pendingBookings = Booking::pending()->count();
        $newContacts = ContactSubmission::new()->count();

        // Recent bookings
        $recentBookings = Booking::with(['service', 'location'])
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();

        // Upcoming bookings
        $upcomingBookings = Booking::with(['service', 'location'])
            ->upcoming()
            ->orderBy('booking_date')
            ->orderBy('booking_time')
            ->limit(10)
            ->get();

        // Quick stats
        $totalServices = Service::active()->count();
        $totalPackages = Package::active()->count();
        $totalLocations = Location::active()->count();

        // Monthly revenue chart data (last 6 months)
        $chartData = $this->getMonthlyRevenueData();

        return view('admin.dashboard', compact(
            'todayBookings',
            'todayRevenue',
            'weekBookings',
            'weekRevenue',
            'monthBookings',
            'monthRevenue',
            'pendingBookings',
            'newContacts',
            'recentBookings',
            'upcomingBookings',
            'totalServices',
            'totalPackages',
            'totalLocations',
            'chartData'
        ));
    }

    private function getMonthlyRevenueData(): array
    {
        $data = [];
        $labels = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $labels[] = $date->format('M Y');
            $data[] = Booking::whereMonth('booking_date', $date->month)
                ->whereYear('booking_date', $date->year)
                ->paid()
                ->sum('amount');
        }

        return [
            'labels' => $labels,
            'data' => $data,
        ];
    }
}
