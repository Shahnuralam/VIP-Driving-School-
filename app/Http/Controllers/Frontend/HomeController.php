<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Service;
use App\Models\Package;
use App\Models\Location;
use App\Models\Testimonial;
use App\Models\InfoCard;
use App\Models\ServiceCategory;

class HomeController extends Controller
{
    public function index()
    {
        $featuredServices = Service::active()
            ->featured()
            ->with('category')
            ->ordered()
            ->limit(6)
            ->get();

        $categories = ServiceCategory::active()
            ->withCount('activeServices')
            ->ordered()
            ->get();

        // Determine most popular category by actual booking volume (excluding cancelled bookings).
        $bookingCountsByCategory = Booking::query()
            ->join('services', 'services.id', '=', 'bookings.service_id')
            ->whereNotNull('services.category_id')
            ->where('bookings.status', '!=', 'cancelled')
            ->groupBy('services.category_id')
            ->selectRaw('services.category_id, COUNT(bookings.id) as total_bookings')
            ->pluck('total_bookings', 'services.category_id');

        $mostPopularCategoryId = $categories
            ->sortByDesc(fn ($category) => (int) ($bookingCountsByCategory[$category->id] ?? 0))
            ->first(fn ($category) => (int) ($bookingCountsByCategory[$category->id] ?? 0) > 0)
            ?->id;

        $locations = Location::active()
            ->ordered()
            ->get();

        $testimonials = Testimonial::active()
            ->featured()
            ->ordered()
            ->limit(6)
            ->get();

        $infoCards = InfoCard::active()
            ->forPage('home')
            ->ordered()
            ->get();

        return view('frontend.home', compact(
            'featuredServices',
            'categories',
            'mostPopularCategoryId',
            'locations',
            'testimonials',
            'infoCards'
        ));
    }
}
