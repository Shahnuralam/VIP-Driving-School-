<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AvailabilitySlot;
use App\Models\Service;
use App\Models\Location;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class AvailabilityController extends Controller
{
    public function index(Request $request)
    {
        $query = AvailabilitySlot::with(['service', 'location']);

        if ($request->filled('service_id')) {
            $query->where('service_id', $request->service_id);
        }

        if ($request->filled('location_id')) {
            $query->where('location_id', $request->location_id);
        }

        if ($request->filled('date_from')) {
            $query->where('date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->where('date', '<=', $request->date_to);
        }

        $slots = $query->orderBy('date')
            ->orderBy('start_time')
            ->paginate(50);

        $services = Service::active()->ordered()->get();
        $locations = Location::active()->ordered()->get();

        return view('admin.availability.index', compact('slots', 'services', 'locations'));
    }

    public function create()
    {
        $services = Service::active()->ordered()->get();
        $locations = Location::active()->ordered()->get();

        return view('admin.availability.create', compact('services', 'locations'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_id' => 'nullable|exists:services,id',
            'location_id' => 'nullable|exists:locations,id',
            'date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'max_bookings' => 'required|integer|min:1',
            'is_available' => 'boolean',
            'notes' => 'nullable|string',
        ]);

        $validated['is_available'] = $request->has('is_available');

        AvailabilitySlot::create($validated);

        return redirect()->route('admin.availability.index')
            ->with('success', 'Availability slot created successfully.');
    }

    public function bulkCreate()
    {
        $services = Service::active()->ordered()->get();
        $locations = Location::active()->ordered()->get();

        return view('admin.availability.bulk-create', compact('services', 'locations'));
    }

    public function bulkStore(Request $request)
    {
        $validated = $request->validate([
            'service_id' => 'nullable|exists:services,id',
            'location_id' => 'nullable|exists:locations,id',
            'date_from' => 'required|date|after_or_equal:today',
            'date_to' => 'required|date|after_or_equal:date_from',
            'days' => 'required|array|min:1',
            'days.*' => 'integer|between:0,6',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'max_bookings' => 'required|integer|min:1',
        ]);

        $period = CarbonPeriod::create($validated['date_from'], $validated['date_to']);
        $createdCount = 0;

        foreach ($period as $date) {
            if (in_array($date->dayOfWeek, $validated['days'])) {
                // Check if slot already exists
                $exists = AvailabilitySlot::where('service_id', $validated['service_id'])
                    ->where('location_id', $validated['location_id'])
                    ->where('date', $date->format('Y-m-d'))
                    ->where('start_time', $validated['start_time'])
                    ->exists();

                if (!$exists) {
                    AvailabilitySlot::create([
                        'service_id' => $validated['service_id'],
                        'location_id' => $validated['location_id'],
                        'date' => $date->format('Y-m-d'),
                        'start_time' => $validated['start_time'],
                        'end_time' => $validated['end_time'],
                        'max_bookings' => $validated['max_bookings'],
                        'is_available' => true,
                    ]);
                    $createdCount++;
                }
            }
        }

        return redirect()->route('admin.availability.index')
            ->with('success', "{$createdCount} availability slots created successfully.");
    }

    public function edit(AvailabilitySlot $availabilitySlot)
    {
        $services = Service::active()->ordered()->get();
        $locations = Location::active()->ordered()->get();

        return view('admin.availability.edit', compact('availabilitySlot', 'services', 'locations'));
    }

    public function update(Request $request, AvailabilitySlot $availabilitySlot)
    {
        $validated = $request->validate([
            'service_id' => 'nullable|exists:services,id',
            'location_id' => 'nullable|exists:locations,id',
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'max_bookings' => 'required|integer|min:1',
            'is_available' => 'boolean',
            'is_blocked' => 'boolean',
            'notes' => 'nullable|string',
        ]);

        $validated['is_available'] = $request->has('is_available');
        $validated['is_blocked'] = $request->has('is_blocked');

        $availabilitySlot->update($validated);

        return redirect()->route('admin.availability.index')
            ->with('success', 'Availability slot updated successfully.');
    }

    public function destroy(AvailabilitySlot $availabilitySlot)
    {
        if ($availabilitySlot->current_bookings > 0) {
            return redirect()->route('admin.availability.index')
                ->with('error', 'Cannot delete slot with existing bookings.');
        }

        $availabilitySlot->delete();

        return redirect()->route('admin.availability.index')
            ->with('success', 'Availability slot deleted successfully.');
    }

    public function blocked()
    {
        $blockedSlots = AvailabilitySlot::where('is_blocked', true)
            ->orWhere('is_available', false)
            ->orderBy('date')
            ->paginate(50);

        return view('admin.availability.blocked', compact('blockedSlots'));
    }

    public function toggleBlock(AvailabilitySlot $availabilitySlot)
    {
        $availabilitySlot->update([
            'is_blocked' => !$availabilitySlot->is_blocked,
        ]);

        $status = $availabilitySlot->is_blocked ? 'blocked' : 'unblocked';

        return redirect()->back()
            ->with('success', "Slot has been {$status}.");
    }
}
