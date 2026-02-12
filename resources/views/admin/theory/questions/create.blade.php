@extends('adminlte::page')

@section('title', 'Add Question')

@section('content_header')
    <h1>Add Question: {{ $theoryCategory->name }}</h1>
@stop

@section('content')
<div class="card">
    <form action="{{ route('admin.theory.questions.store', $theoryCategory) }}" method="POST">
        @csrf
        <div class="card-body">
            <div class="form-group"><label>Question *</label><textarea name="question" class="form-control" rows="3" required>{{ old('question') }}</textarea></div>
            <div class="form-group"><label>Type *</label><select name="question_type" class="form-control" required><option value="single">Single Choice</option><option value="multiple">Multiple Choice</option><option value="true_false">True/False</option></select></div>
            <div class="form-group"><label>Options (key = letter, value = text)</label>
                <div class="row">
                    <div class="col"><input type="text" name="options[key][]" class="form-control" placeholder="A"><input type="text" name="options[value][]" class="form-control" placeholder="Option A text"></div>
                    <div class="col"><input type="text" name="options[key][]" class="form-control" placeholder="B"><input type="text" name="options[value][]" class="form-control" placeholder="Option B text"></div>
                    <div class="col"><input type="text" name="options[key][]" class="form-control" placeholder="C"><input type="text" name="options[value][]" class="form-control" placeholder="Option C text"></div>
                    <div class="col"><input type="text" name="options[key][]" class="form-control" placeholder="D"><input type="text" name="options[value][]" class="form-control" placeholder="Option D text"></div>
                </div>
            </div>
            <div class="form-group"><label>Correct Answer(s) *</label><input type="text" name="correct_answers[]" class="form-control" placeholder="A or A,B for multiple" required value="{{ old('correct_answers.0') }}"></div>
            <div class="form-group"><label>Explanation</label><textarea name="explanation" class="form-control" rows="2">{{ old('explanation') }}</textarea></div>
            <div class="form-group"><label>Difficulty</label><select name="difficulty" class="form-control"><option value="easy">Easy</option><option value="medium" selected>Medium</option><option value="hard">Hard</option></select></div>
            <div class="form-check"><input type="checkbox" name="is_active" value="1" class="form-check-input" {{ old('is_active', true) ? 'checked' : '' }}><label class="form-check-label">Active</label></div>
        </div>
        <div class="card-footer"><button type="submit" class="btn btn-primary">Add Question</button><a href="{{ route('admin.theory.questions.index', $theoryCategory) }}" class="btn btn-secondary">Cancel</a></div>
    </form>
</div>
@stop
