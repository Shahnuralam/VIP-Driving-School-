<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Instructor;
use App\Models\InstructorUnavailability;
use App\Models\Suburb;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class InstructorController extends Controller
{
    public function index(Request $request)
    {
        $query = Instructor::withCount(['bookings', 'reviews']);

        if ($request->status === 'active') {
            $query->where('is_active', true);
        } elseif ($request->status === 'inactive') {
            $query->where('is_active', false);
        }

        if ($request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $instructors = $query->ordered()->paginate(15);
        
        return view('admin.instructors.index', compact('instructors'));
    }

    public function create()
    {
        $suburbs = Suburb::active()->ordered()->get();
        return view('admin.instructors.create', compact('suburbs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:instructors,email',
            'phone' => 'required|string|max:20',
            'bio' => 'nullable|string',
            'qualifications' => 'nullable|string',
            'years_experience' => 'nullable|integer|min:0',
            'photo' => 'nullable|image|max:2048',
            'license_number' => 'nullable|string|max:50',
            'license_expiry' => 'nullable|date',
            'specializations' => 'nullable|array',
            'available_days' => 'nullable|array',
            'available_from' => 'nullable|date_format:H:i',
            'available_to' => 'nullable|date_format:H:i',
            'suburbs' => 'nullable|array',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['slug'] = Str::slug($validated['name']);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('instructors', 'public');
        }

        $instructor = Instructor::create($validated);

        if (!empty($validated['suburbs'])) {
            $instructor->suburbs()->sync($validated['suburbs']);
        }

        return redirect()->route('admin.instructors.index')
            ->with('success', 'Instructor added successfully.');
    }

    public function show(Instructor $instructor)
    {
        $instructor->load(['bookings' => fn($q) => $q->latest()->limit(10), 'reviews' => fn($q) => $q->latest()->limit(5), 'suburbs']);
        return view('admin.instructors.show', compact('instructor'));
    }

    public function edit(Instructor $instructor)
    {
        $suburbs = Suburb::active()->ordered()->get();
        $instructor->load('suburbs');
        return view('admin.instructors.edit', compact('instructor', 'suburbs'));
    }

    public function update(Request $request, Instructor $instructor)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:instructors,email,' . $instructor->id,
            'phone' => 'required|string|max:20',
            'bio' => 'nullable|string',
            'qualifications' => 'nullable|string',
            'years_experience' => 'nullable|integer|min:0',
            'photo' => 'nullable|image|max:2048',
            'license_number' => 'nullable|string|max:50',
            'license_expiry' => 'nullable|date',
            'specializations' => 'nullable|array',
            'available_days' => 'nullable|array',
            'available_from' => 'nullable|date_format:H:i',
            'available_to' => 'nullable|date_format:H:i',
            'suburbs' => 'nullable|array',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('photo')) {
            if ($instructor->photo) {
                Storage::disk('public')->delete($instructor->photo);
            }
            $validated['photo'] = $request->file('photo')->store('instructors', 'public');
        }

        $instructor->update($validated);

        if (isset($validated['suburbs'])) {
            $instructor->suburbs()->sync($validated['suburbs']);
        }

        return redirect()->route('admin.instructors.index')
            ->with('success', 'Instructor updated successfully.');
    }

    public function destroy(Instructor $instructor)
    {
        if ($instructor->photo) {
            Storage::disk('public')->delete($instructor->photo);
        }
        $instructor->delete();
        return redirect()->route('admin.instructors.index')
            ->with('success', 'Instructor deleted successfully.');
    }

    public function availability(Instructor $instructor)
    {
        $unavailabilities = $instructor->unavailabilities()
            ->where('date', '>=', now()->toDateString())
            ->orderBy('date')
            ->get();
        
        return view('admin.instructors.availability', compact('instructor', 'unavailabilities'));
    }

    public function storeUnavailability(Request $request, Instructor $instructor)
    {
        $validated = $request->validate([
            'date' => 'required|date|after_or_equal:today',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after:start_time',
            'reason' => 'nullable|string|max:255',
        ]);

        $instructor->unavailabilities()->create($validated);

        return back()->with('success', 'Unavailability added.');
    }

    public function destroyUnavailability(Instructor $instructor, InstructorUnavailability $unavailability)
    {
        $unavailability->delete();
        return back()->with('success', 'Unavailability removed.');
    }
}
