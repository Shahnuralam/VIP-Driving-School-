<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TheoryCategory;
use App\Models\TheoryQuestion;
use Illuminate\Http\Request;

class TheoryQuestionController extends Controller
{
    public function index(TheoryCategory $theoryCategory)
    {
        $questions = $theoryCategory->questions()->ordered()->paginate(20);
        return view('admin.theory.questions.index', compact('theoryCategory', 'questions'));
    }

    public function create(TheoryCategory $theoryCategory)
    {
        return view('admin.theory.questions.create', compact('theoryCategory'));
    }

    public function store(Request $request, TheoryCategory $theoryCategory)
    {
        $validated = $request->validate([
            'question' => 'required|string',
            'question_type' => 'required|in:single,multiple,true_false',
            'options' => 'required|array',
            'options.key' => 'required_with:options',
            'options.value' => 'required_with:options',
            'correct_answers' => 'required|array',
            'correct_answers.*' => 'string',
            'explanation' => 'nullable|string',
            'difficulty' => 'required|in:easy,medium,hard',
            'points' => 'nullable|integer|min:1',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);
        $options = [];
        foreach ($request->options['key'] ?? [] as $i => $key) {
            if (!empty($key) && isset($request->options['value'][$i])) {
                $options[$key] = $request->options['value'][$i];
            }
        }
        $validated['options'] = $options;
        $validated['correct_answers'] = array_values(array_filter($request->correct_answers ?? []));
        $validated['theory_category_id'] = $theoryCategory->id;
        $validated['is_active'] = $request->boolean('is_active', true);
        TheoryQuestion::create($validated);
        $theoryCategory->updateQuestionsCount();
        return redirect()->route('admin.theory.questions.index', $theoryCategory)->with('success', 'Question added.');
    }

    public function edit(TheoryQuestion $theoryQuestion)
    {
        $theoryCategory = $theoryQuestion->category;
        return view('admin.theory.questions.edit', compact('theoryCategory', 'theoryQuestion'));
    }

    public function update(Request $request, TheoryQuestion $theoryQuestion)
    {
        $validated = $request->validate([
            'question' => 'required|string',
            'question_type' => 'required|in:single,multiple,true_false',
            'options' => 'required|array',
            'correct_answers' => 'required|array',
            'correct_answers.*' => 'string',
            'explanation' => 'nullable|string',
            'difficulty' => 'required|in:easy,medium,hard',
            'points' => 'nullable|integer|min:1',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);
        $options = [];
        foreach ($request->options['key'] ?? [] as $i => $key) {
            if (!empty($key) && isset($request->options['value'][$i])) {
                $options[$key] = $request->options['value'][$i];
            }
        }
        $validated['options'] = $options;
        $validated['correct_answers'] = array_values(array_filter($request->correct_answers ?? []));
        $validated['is_active'] = $request->boolean('is_active');
        $theoryQuestion->update($validated);
        $theoryQuestion->category->updateQuestionsCount();
        return redirect()->route('admin.theory.questions.index', $theoryQuestion->category)->with('success', 'Question updated.');
    }

    public function destroy(TheoryQuestion $theoryQuestion)
    {
        $category = $theoryQuestion->category;
        $theoryQuestion->delete();
        $category->updateQuestionsCount();
        return redirect()->route('admin.theory.questions.index', $category)->with('success', 'Question deleted.');
    }
}
