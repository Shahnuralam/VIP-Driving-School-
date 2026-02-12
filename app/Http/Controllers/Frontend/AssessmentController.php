<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Location;
use App\Models\InfoCard;
use App\Models\Document;
use App\Models\ServiceCategory;

class AssessmentController extends Controller
{
    public function index()
    {
        // Get P1 Assessment category and services
        $assessmentCategory = ServiceCategory::where('slug', 'p1-assessments')
            ->orWhere('name', 'like', '%P1%')
            ->orWhere('name', 'like', '%Assessment%')
            ->first();

        $assessmentServices = collect([]);
        if ($assessmentCategory) {
            $assessmentServices = Service::active()
                ->where('category_id', $assessmentCategory->id)
                ->with('location')
                ->ordered()
                ->get();
        }

        $locations = Location::active()
            ->ordered()
            ->get();

        $thingsToKnow = InfoCard::active()
            ->forPage('p1-assessments')
            ->forSection('things-to-know')
            ->ordered()
            ->get();

        $thingsToBring = InfoCard::active()
            ->forPage('p1-assessments')
            ->forSection('things-to-bring')
            ->ordered()
            ->get();

        $documents = Document::active()
            ->where('category', 'p1-assessment')
            ->ordered()
            ->get();

        return view('frontend.assessments.index', compact(
            'assessmentServices',
            'locations',
            'thingsToKnow',
            'thingsToBring',
            'documents'
        ));
    }
}
