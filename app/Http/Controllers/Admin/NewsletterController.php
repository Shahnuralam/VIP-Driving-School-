<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class NewsletterController extends Controller
{
    public function index(Request $request)
    {
        $query = NewsletterSubscriber::query();
        if ($request->status) {
            $query->where('status', $request->status);
        }
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('email', 'like', '%' . $request->search . '%')
                  ->orWhere('name', 'like', '%' . $request->search . '%');
            });
        }
        $subscribers = $query->latest()->paginate(20);
        $stats = [
            'total' => NewsletterSubscriber::count(),
            'subscribed' => NewsletterSubscriber::subscribed()->count(),
            'pending' => NewsletterSubscriber::pending()->count(),
        ];
        return view('admin.newsletter.index', compact('subscribers', 'stats'));
    }

    public function export()
    {
        $subscribers = NewsletterSubscriber::subscribed()->get(['name', 'email', 'created_at']);
        $csv = "Name,Email,Subscribed At\n";
        foreach ($subscribers as $s) {
            $csv .= '"' . str_replace('"', '""', $s->name) . '","' . $s->email . '","' . $s->created_at->toDateTimeString() . "\"\n";
        }
        return Response::make($csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="newsletter-subscribers-' . date('Y-m-d') . '.csv"',
        ]);
    }

    public function subscribe(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        NewsletterSubscriber::firstOrCreate(
            ['email' => $request->email],
            ['status' => 'subscribed', 'confirmed_at' => now(), 'source' => 'admin']
        );
        return back()->with('success', 'Subscriber added.');
    }
}
