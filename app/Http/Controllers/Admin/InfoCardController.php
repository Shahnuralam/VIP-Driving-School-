<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InfoCard;
use Illuminate\Http\Request;

class InfoCardController extends Controller
{
    public function index()
    {
        $infoCards = InfoCard::ordered()->paginate(20);

        return view('admin.info-cards.index', compact('infoCards'));
    }

    public function create()
    {
        return view('admin.info-cards.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:191',
            'content' => 'required|string',
            'icon' => 'nullable|string|max:191',
            'icon_type' => 'required|in:fontawesome,image',
            'icon_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'page' => 'required|string|max:50',
            'section' => 'nullable|string|max:50',
            'link_url' => 'nullable|url|max:255',
            'link_text' => 'nullable|string|max:100',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
        ]);

        if ($request->hasFile('icon_image') && $validated['icon_type'] === 'image') {
            $validated['icon'] = $request->file('icon_image')->store('info-cards', 'public');
        }

        $validated['is_active'] = $request->has('is_active');
        unset($validated['icon_image']);

        InfoCard::create($validated);

        return redirect()->route('admin.info-cards.index')
            ->with('success', 'Info card created successfully.');
    }

    public function edit(InfoCard $infoCard)
    {
        return view('admin.info-cards.edit', compact('infoCard'));
    }

    public function update(Request $request, InfoCard $infoCard)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:191',
            'content' => 'required|string',
            'icon' => 'nullable|string|max:191',
            'icon_type' => 'required|in:fontawesome,image',
            'icon_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'page' => 'required|string|max:50',
            'section' => 'nullable|string|max:50',
            'link_url' => 'nullable|url|max:255',
            'link_text' => 'nullable|string|max:100',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
        ]);

        if ($request->hasFile('icon_image') && $validated['icon_type'] === 'image') {
            $validated['icon'] = $request->file('icon_image')->store('info-cards', 'public');
        }

        $validated['is_active'] = $request->has('is_active');
        unset($validated['icon_image']);

        $infoCard->update($validated);

        return redirect()->route('admin.info-cards.index')
            ->with('success', 'Info card updated successfully.');
    }

    public function destroy(InfoCard $infoCard)
    {
        $infoCard->delete();

        return redirect()->route('admin.info-cards.index')
            ->with('success', 'Info card deleted successfully.');
    }
}
