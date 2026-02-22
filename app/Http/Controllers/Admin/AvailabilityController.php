<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AvailabilitySlot;
use App\Models\Service;
use App\Models\Location;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

use App\Models\Inventory; // This line seems unused in original, check if needed or just remove
use App\Models\Instructor;

class AvailabilityController extends Controller
{
    public function index(Request $request)
    {
        $query = AvailabilitySlot::with(['service', 'location', 'instructor']);

        if ($request->filled('service_id')) {
            $query->where('service_id', $request->service_id);
        }

        if ($request->filled('location_id')) {
            $query->where('location_id', $request->location_id);
        }

        if ($request->filled('instructor_id')) {
            $query->where('instructor_id', $request->instructor_id);
        }

        if ($request->filled('date_from')) {
            $query->where('date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->where('date', '<=', $request->date_to);
        }

        // We want to group by all fields except instructor to show "grouped" slots in the UI
        // However, standard groupBy in Eloquent can be tricky with pagination.
        // For a more professional view, we'll fetch them normally and deal with grouping in the view OR use a raw query.
        // Let's use a raw selection to make it efficient.
        // Note: We use max(id) to get a representative ID for editing.
        $slots = $query->selectRaw('
                MIN(id) as id,
                service_id,
                location_id,
                date,
                start_time,
                end_time,
                SUM(max_bookings) as max_bookings,
                SUM(current_bookings) as current_bookings,
                MAX(is_available) as is_available,
                MAX(is_blocked) as is_blocked,
                GROUP_CONCAT(instructor_id) as instructor_ids
            ')
            ->groupBy('date', 'start_time', 'end_time', 'service_id', 'location_id')
            ->orderBy('date')
            ->orderBy('start_time')
            ->paginate(50);

        // Map instructor names into the collection
        $allInstructors = Instructor::all()->pluck('name', 'id');
        $slots->getCollection()->transform(function($slot) use ($allInstructors) {
            $ids = array_filter(explode(',', $slot->instructor_ids));
            $slot->instructor_names = array_map(function($id) use ($allInstructors) {
                return $allInstructors[$id] ?? 'Unkown';
            }, $ids);
            return $slot;
        });

        $services = Service::active()->ordered()->get();
        $locations = Location::active()->ordered()->get();
        $instructors = Instructor::active()->ordered()->get();

        return view('admin.availability.index', compact('slots', 'services', 'locations', 'instructors'));
    }

    public function calendarEvents(Request $request)
    {
        $start = $request->input('start');
        $end = $request->input('end');

        // Group slots similar to index but within the date range
        $slots = AvailabilitySlot::selectRaw('
                MIN(id) as id,
                service_id,
                location_id,
                date,
                start_time,
                end_time,
                SUM(max_bookings) as max_bookings,
                SUM(current_bookings) as current_bookings,
                MAX(is_available) as is_available,
                MAX(is_blocked) as is_blocked,
                GROUP_CONCAT(instructor_id) as instructor_ids
            ')
            ->whereBetween('date', [
                Carbon::parse($start)->format('Y-m-d'),
                Carbon::parse($end)->format('Y-m-d')
            ]);

        // Apply Filters
        if ($request->filled('service_id')) {
            $slots->where('service_id', $request->service_id);
        }
        if ($request->filled('location_id')) {
            $slots->where('location_id', $request->location_id);
        }
        if ($request->filled('instructor_id')) {
            $slots->where('instructor_id', $request->instructor_id);
        }

        $slots = $slots->groupBy('date', 'start_time', 'end_time', 'service_id', 'location_id')
            ->get();

        // Get pattern types for the slots
        $slotPatternTypes = AvailabilitySlot::selectRaw('date, start_time, end_time, service_id, location_id, MAX(pattern_type) as pattern_type')
            ->whereBetween('date', [
                Carbon::parse($start)->format('Y-m-d'),
                Carbon::parse($end)->format('Y-m-d')
            ])
            ->groupBy('date', 'start_time', 'end_time', 'service_id', 'location_id')
            ->get()
            ->keyBy(function($item) {
                return $item->date . '_' . $item->start_time . '_' . $item->end_time . '_' . $item->service_id . '_' . $item->location_id;
            });

        // Pre-fetch related models to avoid N+1 inside the loop
        $allServices = Service::pluck('name', 'id');
        $allLocations = Location::pluck('name', 'id');
        $allInstructors = Instructor::pluck('name', 'id');

        $events = [];

        foreach ($slots as $slot) {
            $color = '#28a745'; // Green for available
            if ($slot->is_blocked) {
                $color = '#dc3545'; // Red for blocked
            } elseif (!$slot->is_available) {
                $color = '#ffc107'; // Yellow for unavailable
            } elseif ($slot->current_bookings >= $slot->max_bookings) {
                $color = '#6c757d'; // Grey for full
            }

            // Robustly handle start_time/end_time converting to H:i format
            // This handles strings (H:i:s) or Carbon objects
            try {
                $startTime = \Carbon\Carbon::parse($slot->start_time)->format('H:i');
                $endTime = \Carbon\Carbon::parse($slot->end_time)->format('H:i');
            } catch (\Exception $e) {
                // Fallback or log if parsing fails, though unlikely with DB data
                continue;
            }

            // Build Title: Service Name - Instructor Names
            $serviceName = $allServices[$slot->service_id] ?? 'All Services';
            
            $instructorNames = [];
            $instructorIds = array_filter(explode(',', $slot->instructor_ids));
            if (empty($instructorIds)) {
                $instructorNames[] = 'Global (All)';
            } else {
                foreach ($instructorIds as $id) {
                    if (isset($allInstructors[$id])) {
                        $instructorNames[] = $allInstructors[$id];
                    }
                }
            }
            $instructorStr = implode(', ', $instructorNames);

            // Get pattern type for this slot group
            $key = $slot->date . '_' . $startTime . ':00_' . $endTime . ':00_' . $slot->service_id . '_' . $slot->location_id;
            $patternType = $slotPatternTypes[$key]->pattern_type ?? null;
            
            // Add pattern indicator to title
            $patternIcon = '';
            if ($patternType === 'daily') {
                $patternIcon = '🔄 '; // Daily recurring
            } elseif ($patternType === 'weekly') {
                $patternIcon = '📅 '; // Weekly recurring
            } elseif ($patternType === 'monthly') {
                $patternIcon = '🗓️ '; // Monthly recurring
            } elseif ($patternType === 'onetime') {
                $patternIcon = '📦 '; // One-time pattern
            }

            // Concise title for the calendar view
            $shortTitle = $patternIcon . $serviceName;
            if ($instructorStr !== 'Global (All)') {
                // If specific instructor(s), maybe append initials or just keep it simple?
                // For "professional" look in month view, arguably less is more.
                // But user wants to see "Service and Instructor".
                // Let's try: "Service (Instructor)"
                $shortTitle .= ' (' . $instructorStr . ')';
            }

            // Full details for tooltip
            $tooltip = "Time: $startTime - $endTime\nService: $serviceName\nInstructor: $instructorStr\nLocation: " . ($allLocations[$slot->location_id] ?? 'All Locations');
            if ($slot->current_bookings > 0) {
                $tooltip .= "\nBookings: {$slot->current_bookings}/{$slot->max_bookings}";
            }

            $events[] = [
                'id' => $slot->id,
                'title' => $shortTitle,
                'start' => $slot->date->format('Y-m-d') . 'T' . $startTime . ':00',
                'end' => $slot->date->format('Y-m-d') . 'T' . $endTime . ':00',
                'backgroundColor' => $color,
                'borderColor' => $color,
                'extendedProps' => [
                    'tooltip' => $tooltip, // Pass formatted tooltip text
                    'service_name' => $serviceName,
                    'instructor_name' => $instructorStr,
                    'time_range' => $startTime . ' - ' . $endTime,
                    'location_id' => $slot->location_id,
                    'current_bookings' => $slot->current_bookings,
                    'max_bookings' => $slot->max_bookings,
                    'is_blocked' => $slot->is_blocked,
                ]
            ];
        }

        return response()->json($events);
    }

    public function create()
    {
        $services = Service::active()->ordered()->get();
        $locations = Location::active()->ordered()->get();
        $instructors = Instructor::active()->ordered()->get();

        return view('admin.availability.create', compact('services', 'locations', 'instructors'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_id' => 'nullable|exists:services,id',
            'location_id' => 'nullable|exists:locations,id',
            'instructor_ids' => 'nullable|array',
            'instructor_ids.*' => 'exists:instructors,id',
            'pattern_type' => 'nullable|in:onetime,daily,weekly,monthly',
            'date' => 'required|date|after_or_equal:today',
            'duration_value' => 'nullable|integer|min:1|max:52',
            'duration_unit' => 'nullable|in:weeks,months',
            'days' => 'nullable|array',
            'days.*' => 'integer|between:0,6',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'max_bookings' => 'required|integer|min:1',
            'is_available' => 'boolean',
            'notes' => 'nullable|string',
        ]);

        $validated['is_available'] = $request->has('is_available');
        $patternType = $request->input('pattern_type', 'manual');
        $instructorIds = $request->input('instructor_ids', []);
        $targetInstructors = empty($instructorIds) ? [null] : $instructorIds;

        $startDate = Carbon::parse($validated['date']);
        $targetDates = [$startDate->copy()];

        if (in_array($patternType, ['daily', 'weekly', 'monthly'], true)) {
            $durationValue = (int) ($validated['duration_value'] ?? 0);
            $durationUnit = $validated['duration_unit'] ?? null;

            if ($durationValue < 1 || !in_array($durationUnit, ['weeks', 'months'], true)) {
                return redirect()->back()
                    ->withErrors(['duration_value' => 'Please select a valid recurring duration.'])
                    ->withInput();
            }

            if ($durationUnit === 'months' && $durationValue > 3) {
                return redirect()->back()
                    ->withErrors(['duration_value' => 'Monthly recurring slots can be created for up to 3 months only.'])
                    ->withInput();
            }

            if ($patternType === 'monthly' && $durationUnit !== 'months') {
                return redirect()->back()
                    ->withErrors(['duration_unit' => 'Monthly recurring pattern requires duration unit as months.'])
                    ->withInput();
            }

            $endDate = $durationUnit === 'months'
                ? $startDate->copy()->addMonthsNoOverflow($durationValue)
                : $startDate->copy()->addWeeks($durationValue);

            $targetDates = [];
            if ($patternType === 'daily') {
                foreach (CarbonPeriod::create($startDate->copy(), $endDate->copy()) as $date) {
                    $targetDates[] = $date->copy();
                }
            } elseif ($patternType === 'weekly') {
                $targetDays = array_map('intval', $validated['days'] ?? []);
                if (empty($targetDays)) {
                    return redirect()->back()
                        ->withErrors(['days' => 'Please select at least one day for weekly recurring pattern.'])
                        ->withInput();
                }

                foreach (CarbonPeriod::create($startDate->copy(), $endDate->copy()) as $date) {
                    if (in_array($date->dayOfWeek, $targetDays, true)) {
                        $targetDates[] = $date->copy();
                    }
                }
            } else {
                for ($i = 0; ; $i++) {
                    $candidate = $startDate->copy()->addMonthsNoOverflow($i);
                    if ($candidate->gt($endDate)) {
                        break;
                    }
                    $targetDates[] = $candidate;
                }
            }

            if (empty($targetDates)) {
                return redirect()->back()
                    ->withErrors(['date' => 'No slot dates matched the selected recurring settings.'])
                    ->withInput();
            }
        }

        $createdCount = 0;
        foreach ($targetDates as $slotDate) {
            foreach ($targetInstructors as $instructorId) {
                $exists = AvailabilitySlot::where('service_id', $validated['service_id'])
                    ->where('location_id', $validated['location_id'])
                    ->where('instructor_id', $instructorId)
                    ->where('date', $slotDate->format('Y-m-d'))
                    ->where('start_time', $validated['start_time'])
                    ->where('end_time', $validated['end_time'])
                    ->exists();

                if (!$exists) {
                    AvailabilitySlot::create([
                        'service_id' => $validated['service_id'],
                        'location_id' => $validated['location_id'],
                        'instructor_id' => $instructorId,
                        'date' => $slotDate->format('Y-m-d'),
                        'start_time' => $validated['start_time'],
                        'end_time' => $validated['end_time'],
                        'max_bookings' => $validated['max_bookings'],
                        'is_available' => $validated['is_available'],
                        'notes' => $validated['notes'] ?? null,
                        'pattern_type' => $patternType,
                    ]);
                    $createdCount++;
                }
            }
        }

        $message = $createdCount > 0
            ? "{$createdCount} availability slot(s) created successfully."
            : 'No new slots were created because matching slots already exist.';

        return redirect()->route('admin.availability.index')
            ->with('success', $message);
    }

    public function bulkCreate()
    {
        $services = Service::active()->ordered()->get();
        $locations = Location::active()->ordered()->get();
        $instructors = Instructor::active()->ordered()->get();

        return view('admin.availability.bulk-create', compact('services', 'locations', 'instructors'));
    }

    public function bulkStore(Request $request)
    {
        $validated = $request->validate([
            'service_id' => 'nullable|exists:services,id',
            'location_id' => 'nullable|exists:locations,id',
            'instructor_ids' => 'nullable|array',
            'instructor_ids.*' => 'exists:instructors,id',
            'pattern_type' => 'required|in:onetime,daily,weekly',
            'date_from' => 'required|date|after_or_equal:today',
            'date_to' => 'nullable|date|after_or_equal:date_from',
            'duration_value' => 'nullable|integer|min:1|max:52',
            'duration_unit' => 'nullable|in:weeks,months',
            'days' => 'nullable|array',
            'days.*' => 'integer|between:0,6',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'max_bookings' => 'required|integer|min:1',
        ]);

        $patternType = $validated['pattern_type'];
        $instructorIds = $request->input('instructor_ids', []);
        $targetInstructors = empty($instructorIds) ? [null] : $instructorIds;

        if ($patternType === 'onetime' && empty($validated['date_to'])) {
            return redirect()->back()
                ->withErrors(['date_to' => 'Please select an end date for one-time pattern.'])
                ->withInput();
        }

        if ($patternType !== 'onetime') {
            $durationValue = (int) ($validated['duration_value'] ?? 0);
            $durationUnit = $validated['duration_unit'] ?? null;

            if ($durationValue < 1 || !in_array($durationUnit, ['weeks', 'months'], true)) {
                return redirect()->back()
                    ->withErrors(['duration_value' => 'Please select a valid recurring duration.'])
                    ->withInput();
            }

            if ($durationUnit === 'months' && $durationValue > 3) {
                return redirect()->back()
                    ->withErrors(['duration_value' => 'Monthly recurring slots can be created for up to 3 months only.'])
                    ->withInput();
            }

            $startDate = Carbon::parse($validated['date_from']);
            $endDate = $durationUnit === 'months'
                ? $startDate->copy()->addMonthsNoOverflow($durationValue)
                : $startDate->copy()->addWeeks($durationValue);

            $validated['date_to'] = $endDate->format('Y-m-d');
        }
        
        // Determine which days to create slots for
        $targetDays = [];
        if ($patternType === 'daily') {
            // Daily: all days of the week
            $targetDays = [0, 1, 2, 3, 4, 5, 6];
        } elseif ($patternType === 'weekly') {
            // Weekly: only selected days
            $targetDays = $validated['days'] ?? [];
            if (empty($targetDays)) {
                return redirect()->back()
                    ->withErrors(['days' => 'Please select at least one day for weekly recurring pattern.'])
                    ->withInput();
            }
        } else {
            // One-time: use selected days
            $targetDays = $validated['days'] ?? [];
            if (empty($targetDays)) {
                return redirect()->back()
                    ->withErrors(['days' => 'Please select at least one day.'])
                    ->withInput();
            }
        }

        $period = CarbonPeriod::create($validated['date_from'], $validated['date_to']);
        $createdCount = 0;

        foreach ($period as $date) {
            if (in_array($date->dayOfWeek, $targetDays)) {
                foreach ($targetInstructors as $instructorId) {
                    $exists = AvailabilitySlot::where('service_id', $validated['service_id'])
                        ->where('location_id', $validated['location_id'])
                        ->where('instructor_id', $instructorId)
                        ->where('date', $date->format('Y-m-d'))
                        ->where('start_time', $validated['start_time'])
                        ->exists();

                    if (!$exists) {
                        AvailabilitySlot::create([
                            'service_id' => $validated['service_id'],
                            'location_id' => $validated['location_id'],
                            'instructor_id' => $instructorId,
                            'date' => $date->format('Y-m-d'),
                            'start_time' => $validated['start_time'],
                            'end_time' => $validated['end_time'],
                            'max_bookings' => $validated['max_bookings'],
                            'is_available' => true,
                            'pattern_type' => $patternType, // Save the pattern type
                        ]);
                        $createdCount++;
                    }
                }
            }
        }

        $patternLabel = [
            'onetime' => 'one-time',
            'daily' => 'daily recurring',
            'weekly' => 'weekly recurring'
        ][$patternType];

        return redirect()->route('admin.availability.index')
            ->with('success', "{$createdCount} availability slots created successfully ({$patternLabel} pattern).");
    }

    public function edit(AvailabilitySlot $availabilitySlot)
    {
        $services = Service::active()->ordered()->get();
        $locations = Location::active()->ordered()->get();
        $instructors = Instructor::active()->ordered()->get();

        // Find all instructors assigned to this same slot (siblings)
        $siblingInstructorIds = AvailabilitySlot::where('date', $availabilitySlot->date->format('Y-m-d'))
            ->where('start_time', $availabilitySlot->start_time)
            ->where('end_time', $availabilitySlot->end_time)
            ->where('service_id', $availabilitySlot->service_id)
            ->where('location_id', $availabilitySlot->location_id)
            ->pluck('instructor_id')
            ->toArray();

        // Ensure current slot's instructor is in the list
        $availabilitySlot->instructor_ids = array_values(array_unique($siblingInstructorIds));

        return view('admin.availability.edit', compact('availabilitySlot', 'services', 'locations', 'instructors'));
    }

    public function update(Request $request, AvailabilitySlot $availabilitySlot)
    {
        $validated = $request->validate([
            'service_id' => 'nullable|exists:services,id',
            'location_id' => 'nullable|exists:locations,id',
            'instructor_ids' => 'nullable|array',
            'instructor_ids.*' => 'exists:instructors,id',
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

        $instructorIds = $request->input('instructor_ids', []);
        if (empty($instructorIds)) {
            $instructorIds = [null]; // Global
        }

        // Find existing slots for this configuration (to sync)
        $existingSlots = AvailabilitySlot::where('date', $availabilitySlot->date->format('Y-m-d'))
            ->where('start_time', $availabilitySlot->start_time)
            ->where('end_time', $availabilitySlot->end_time)
            ->where('service_id', $availabilitySlot->service_id)
            ->where('location_id', $availabilitySlot->location_id)
            ->get();

        $existingInstructorIds = $existingSlots->pluck('instructor_id')->toArray();

        // 1. Delete slots for instructors no longer selected (that don't have bookings)
        foreach ($existingSlots as $oldSlot) {
            if (!in_array($oldSlot->instructor_id, $instructorIds)) {
                if ($oldSlot->current_bookings == 0) {
                    $oldSlot->delete();
                } else {
                    // Keep it but maybe mark it somehow? For now just keep it to avoid data loss
                }
            }
        }

        // 2. Update/Create slots for selected instructors
        foreach ($instructorIds as $instructorId) {
            $slot = $existingSlots->where('instructor_id', $instructorId)->first();
            
            if ($slot) {
                // Update existing
                $slot->update(array_merge($validated, ['instructor_id' => $instructorId]));
            } else {
                // Create new
                AvailabilitySlot::create(array_merge($validated, ['instructor_id' => $instructorId]));
            }
        }

        return redirect()->route('admin.availability.index')
            ->with('success', 'Availability slots updated and synchronized successfully.');
    }

    public function destroy(AvailabilitySlot $availabilitySlot)
    {
        // Find all siblings in the group
        $startTime = \Carbon\Carbon::parse($availabilitySlot->start_time)->format('H:i:s');
        $endTime = \Carbon\Carbon::parse($availabilitySlot->end_time)->format('H:i:s');

        $groupQuery = AvailabilitySlot::where('date', $availabilitySlot->date->format('Y-m-d'))
            ->where('start_time', $startTime)
            ->where('end_time', $endTime)
            ->where('service_id', $availabilitySlot->service_id)
            ->where('location_id', $availabilitySlot->location_id);

        if ($groupQuery->sum('current_bookings') > 0) {
            return redirect()->route('admin.availability.index')
                ->with('error', 'Cannot delete group. One or more slots have existing bookings.');
        }

        $groupQuery->delete();

        return redirect()->route('admin.availability.index')
            ->with('success', 'Availability slot group deleted successfully.');
    }

    public function bulkDestroy(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:availability_slots,id',
        ]);

        $ids = $request->ids;
        $count = 0;
        $skipped = 0;

        foreach ($ids as $id) {
            $slot = AvailabilitySlot::find($id);
            if ($slot) {
                if ($slot->current_bookings > 0) {
                    $skipped++;
                    continue;
                }
                $slot->delete();
                $count++;
            }
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "{$count} slots deleted successfully." . ($skipped > 0 ? " ({$skipped} skipped due to existing bookings)" : "")
            ]);
        }

        return redirect()->back()
            ->with('success', "{$count} slots deleted successfully." . ($skipped > 0 ? " ({$skipped} skipped due to existing bookings)" : ""));
    }

    public function blocked()
    {
        $blockedSlots = AvailabilitySlot::where('is_blocked', true)
            ->orWhere('is_available', false)
            ->orderBy('date')
            ->paginate(50);

        if (request()->ajax()) {
            return view('admin.availability.partials.blocked-table', compact('blockedSlots'))->render();
        }

        return view('admin.availability.blocked', compact('blockedSlots'));
    }

    public function toggleBlock(AvailabilitySlot $availabilitySlot)
    {
        // Toggle for the whole group
        $newStatus = !$availabilitySlot->is_blocked;

        $startTime = \Carbon\Carbon::parse($availabilitySlot->start_time)->format('H:i:s');
        $endTime = \Carbon\Carbon::parse($availabilitySlot->end_time)->format('H:i:s');

        AvailabilitySlot::where('date', $availabilitySlot->date->format('Y-m-d'))
            ->where('start_time', $startTime)
            ->where('end_time', $endTime)
            ->where('service_id', $availabilitySlot->service_id)
            ->where('location_id', $availabilitySlot->location_id)
            ->update(['is_blocked' => $newStatus]);

        $status = $newStatus ? 'blocked' : 'unblocked';

        if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => "Slot group has been {$status}."]);
        }

        return redirect()->back()
            ->with('success', "Slot group has been {$status}.");
    }

    public function blockDate(Request $request)
    {
        $request->validate([
            'date_from' => 'required|date',
            'date_to' => 'required|date|after_or_equal:date_from',
            'instructor_id' => 'nullable|exists:instructors,id',
            'notes' => 'nullable|string',
        ]);

        $query = AvailabilitySlot::whereBetween('date', [$request->date_from, $request->date_to]);

        if ($request->filled('instructor_id')) {
            $query->where('instructor_id', $request->instructor_id);
        }

        // Update existing slots to be blocked
        $count = $query->update([
            'is_blocked' => true,
            'is_available' => false,
            'notes' => $request->notes // This might overwrite existing notes, but acceptable for bulk block
        ]);

        return redirect()->route('admin.availability.index')
            ->with('success', "{$count} slots have been blocked in the selected range.");
    }
}
