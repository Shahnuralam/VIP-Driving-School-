<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
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
            'locations',
            'testimonials',
            'infoCards'
        ));
    }
}
