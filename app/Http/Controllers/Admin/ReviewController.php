<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $query = Review::with(['customer', 'service', 'instructor', 'booking']);

        if ($request->status) {
            $query->where('status', $request->status);
        }
        if ($request->rating) {
            $query->where('overall_rating', $request->rating);
        }
        if ($request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('customer_name', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%")
                  ->orWhere('title', 'like', "%{$search}%");
            });
        }

        $reviews = $query->latest()->paginate(15);
        $pendingCount = Review::pending()->count();
        
        return view('admin.reviews.index', compact('reviews', 'pendingCount'));
    }

    public function show(Review $review)
    {
        $review->load(['customer', 'service', 'instructor', 'booking', 'moderator']);
        return view('admin.reviews.show', compact('review'));
    }

    public function approve(Review $review)
    {
        $review->approve(Auth::id());
        return back()->with('success', 'Review approved and published.');
    }

    public function reject(Request $request, Review $review)
    {
        $request->validate([
            'rejection_reason' => 'nullable|string|max:500',
        ]);

        $review->reject(Auth::id(), $request->rejection_reason);
        return back()->with('success', 'Review rejected.');
    }

    public function respond(Request $request, Review $review)
    {
        $request->validate([
            'admin_response' => 'required|string|max:1000',
        ]);

        $review->addResponse($request->admin_response);
        return back()->with('success', 'Response added to review.');
    }

    public function toggleFeatured(Review $review)
    {
        $review->update(['is_featured' => !$review->is_featured]);
        return back()->with('success', 'Review featured status updated.');
    }

    public function toggleHomepage(Review $review)
    {
        $review->update(['show_on_homepage' => !$review->show_on_homepage]);
        return back()->with('success', 'Review homepage display updated.');
    }

    public function destroy(Review $review)
    {
        $review->delete();
        return redirect()->route('admin.reviews.index')
            ->with('success', 'Review deleted.');
    }
}
