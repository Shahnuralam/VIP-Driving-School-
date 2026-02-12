<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TheoryCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TheoryCategoryController extends Controller
{
    public function index()
    {
        $categories = TheoryCategory::withCount('questions')->ordered()->paginate(15);
        return view('admin.theory.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.theory.categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:theory_categories,slug',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:100',
            'image' => 'nullable|image|max:2048',
            'pass_percentage' => 'required|integer|min:1|max:100',
            'time_limit_minutes' => 'required|integer|min:5|max:120',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);
        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['name']);
        $validated['is_active'] = $request->boolean('is_active', true);
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('theory', 'public');
        }
        $cat = TheoryCategory::create($validated);
        return redirect()->route('admin.theory.questions.index', $cat)->with('success', 'Category created.');
    }

    public function edit(TheoryCategory $theoryCategory)
    {
        return view('admin.theory.categories.edit', compact('theoryCategory'));
    }

    public function update(Request $request, TheoryCategory $theoryCategory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:theory_categories,slug,' . $theoryCategory->id,
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:100',
            'image' => 'nullable|image|max:2048',
            'pass_percentage' => 'required|integer|min:1|max:100',
            'time_limit_minutes' => 'required|integer|min:5|max:120',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);
        $validated['is_active'] = $request->boolean('is_active');
        if ($request->hasFile('image')) {
            if ($theoryCategory->image) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($theoryCategory->image);
            }
            $validated['image'] = $request->file('image')->store('theory', 'public');
        }
        $theoryCategory->update($validated);
        return redirect()->route('admin.theory.categories.index')->with('success', 'Category updated.');
    }

    public function destroy(TheoryCategory $theoryCategory)
    {
        $theoryCategory->delete();
        return redirect()->route('admin.theory.categories.index')->with('success', 'Category deleted.');
    }
}
