<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Service;
use App\Models\Package;
use App\Models\Location;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AnalyticsController extends Controller
{
    public function index(Request $request)
    {
        $period = $request->get('period', '30'); // days
        $from = Carbon::today()->subDays((int) $period);
        $to = Carbon::today();

        // Booking stats
        $bookingsQuery = Booking::whereBetween('booking_date', [$from, $to]);
        $totalBookings = (clone $bookingsQuery)->count();
        $totalRevenue = (clone $bookingsQuery)->where('payment_status', 'paid')->sum('amount');
        $completedBookings = (clone $bookingsQuery)->where('status', 'completed')->count();
        $cancelledBookings = (clone $bookingsQuery)->where('status', 'cancelled')->count();

        // Revenue by month (last 6 months)
        $revenueByMonth = Booking::where('payment_status', 'paid')
            ->where('created_at', '>=', Carbon::today()->subMonths(6))
            ->selectRaw('DATE_FORMAT(booking_date, "%Y-%m") as month, SUM(amount) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');

        // Top services
        $topServices = Booking::whereBetween('booking_date', [$from, $to])
            ->whereNotNull('service_id')
            ->select('service_id', DB::raw('COUNT(*) as count'), DB::raw('SUM(amount) as revenue'))
            ->groupBy('service_id')
            ->orderByDesc('count')
            ->limit(5)
            ->with('service')
            ->get();

        // Top packages
        $topPackages = Booking::whereBetween('booking_date', [$from, $to])
            ->whereNotNull('package_id')
            ->select('package_id', DB::raw('COUNT(*) as count'), DB::raw('SUM(amount) as revenue'))
            ->groupBy('package_id')
            ->orderByDesc('count')
            ->limit(5)
            ->with('package')
            ->get();

        // Top locations
        $topLocations = Booking::whereBetween('booking_date', [$from, $to])
            ->select('location_id', DB::raw('COUNT(*) as count'))
            ->groupBy('location_id')
            ->orderByDesc('count')
            ->limit(5)
            ->with('location')
            ->get();

        // New customers in period
        $newCustomers = Customer::whereBetween('created_at', [$from, $to])->count();

        // Conversion: bookings with payment
        $paidCount = Booking::whereBetween('booking_date', [$from, $to])->where('payment_status', 'paid')->count();
        $conversionRate = $totalBookings > 0 ? round(($paidCount / $totalBookings) * 100, 1) : 0;

        return view('admin.analytics.index', compact(
            'period',
            'totalBookings',
            'totalRevenue',
            'completedBookings',
            'cancelledBookings',
            'revenueByMonth',
            'topServices',
            'topPackages',
            'topLocations',
            'newCustomers',
            'conversionRate'
        ));
    }
}
