<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Waitlist;
use Illuminate\Http\Request;

class WaitlistController extends Controller
{
    public function index(Request $request)
    {
        $query = Waitlist::with(['service', 'package', 'location', 'customer']);
        if ($request->status) {
            $query->where('status', $request->status);
        }
        if ($request->date) {
            $query->where('preferred_date', $request->date);
        }
        $waitlists = $query->latest()->paginate(20);
        return view('admin.waitlist.index', compact('waitlists'));
    }

    public function show(Waitlist $waitlist)
    {
        $waitlist->load(['service', 'package', 'location', 'customer']);
        return view('admin.waitlist.show', compact('waitlist'));
    }

    public function update(Request $request, Waitlist $waitlist)
    {
        $request->validate(['status' => 'required|in:waiting,notified,booked,expired,cancelled']);
        $waitlist->update(['status' => $request->status]);
        if ($request->status === 'notified') {
            $waitlist->notify();
        }
        return back()->with('success', 'Waitlist entry updated.');
    }

    public function destroy(Waitlist $waitlist)
    {
        $waitlist->delete();
        return redirect()->route('admin.waitlist.index')->with('success', 'Entry removed.');
    }
}
