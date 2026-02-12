<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Suburb;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SuburbController extends Controller
{
    public function index(Request $request)
    {
        $query = Suburb::withCount('instructors');
        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('postcode', 'like', '%' . $request->search . '%');
        }
        $suburbs = $query->ordered()->paginate(15);
        return view('admin.suburbs.index', compact('suburbs'));
    }

    public function create()
    {
        return view('admin.suburbs.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:suburbs,slug',
            'postcode' => 'nullable|string|max:20',
            'state' => 'nullable|string|max:10',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'hero_title' => 'nullable|string|max:255',
            'hero_description' => 'nullable|string',
            'hero_image' => 'nullable|image|max:2048',
            'content' => 'nullable|string',
            'local_routes_info' => 'nullable|string',
            'test_center_info' => 'nullable|string',
            'is_serviced' => 'boolean',
            'travel_fee' => 'nullable|numeric|min:0',
            'min_booking_hours' => 'nullable|integer|min:1',
            'show_on_map' => 'boolean',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);
        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['name']);
        $validated['is_serviced'] = $request->boolean('is_serviced', true);
        $validated['show_on_map'] = $request->boolean('show_on_map', true);
        $validated['is_active'] = $request->boolean('is_active', true);
        if ($request->hasFile('hero_image')) {
            $validated['hero_image'] = $request->file('hero_image')->store('suburbs', 'public');
        }
        if (!empty($request->features) && is_array($request->features)) {
            $validated['features'] = array_values(array_filter($request->features));
        }
        Suburb::create($validated);
        return redirect()->route('admin.suburbs.index')->with('success', 'Suburb created.');
    }

    public function show(Suburb $suburb)
    {
        $suburb->load('instructors');
        return view('admin.suburbs.show', compact('suburb'));
    }

    public function edit(Suburb $suburb)
    {
        return view('admin.suburbs.edit', compact('suburb'));
    }

    public function update(Request $request, Suburb $suburb)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:suburbs,slug,' . $suburb->id,
            'postcode' => 'nullable|string|max:20',
            'state' => 'nullable|string|max:10',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'hero_title' => 'nullable|string|max:255',
            'hero_description' => 'nullable|string',
            'hero_image' => 'nullable|image|max:2048',
            'content' => 'nullable|string',
            'local_routes_info' => 'nullable|string',
            'test_center_info' => 'nullable|string',
            'is_serviced' => 'boolean',
            'travel_fee' => 'nullable|numeric|min:0',
            'min_booking_hours' => 'nullable|integer|min:1',
            'show_on_map' => 'boolean',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);
        $validated['is_serviced'] = $request->boolean('is_serviced');
        $validated['show_on_map'] = $request->boolean('show_on_map');
        $validated['is_active'] = $request->boolean('is_active');
        if ($request->hasFile('hero_image')) {
            if ($suburb->hero_image) {
                Storage::disk('public')->delete($suburb->hero_image);
            }
            $validated['hero_image'] = $request->file('hero_image')->store('suburbs', 'public');
        }
        if (isset($request->features) && is_array($request->features)) {
            $validated['features'] = array_values(array_filter($request->features));
        }
        $suburb->update($validated);
        return redirect()->route('admin.suburbs.index')->with('success', 'Suburb updated.');
    }

    public function destroy(Suburb $suburb)
    {
        if ($suburb->hero_image) {
            Storage::disk('public')->delete($suburb->hero_image);
        }
        $suburb->delete();
        return redirect()->route('admin.suburbs.index')->with('success', 'Suburb deleted.');
    }
}
