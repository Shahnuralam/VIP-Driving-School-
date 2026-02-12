<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\InfoCard;
use App\Models\Faq;

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
}
