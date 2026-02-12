@extends('adminlte::page')

@section('title', 'Edit Question')

@section('content_header')
    <h1>Edit Question</h1>
@stop

@section('content')
<div class="card">
    <form action="{{ route('admin.theory.questions.update', $theoryQuestion) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="form-group"><label>Question *</label><textarea name="question" class="form-control" rows="3" required>{{ old('question', $theoryQuestion->question) }}</textarea></div>
            <div class="form-group"><label>Type *</label><select name="question_type" class="form-control" required>@foreach(['single','multiple','true_false'] as $t)<option value="{{ $t }}" {{ old('question_type', $theoryQuestion->question_type) == $t ? 'selected' : '' }}>{{ $theoryQuestion->getTypeLabel() }}</option>@endforeach</select></div>
            <div class="form-group"><label>Correct Answer(s) *</label><input type="text" name="correct_answers[]" class="form-control" value="{{ old('correct_answers.0', is_array($theoryQuestion->correct_answers) ? implode(',', $theoryQuestion->correct_answers) : $theoryQuestion->correct_answers) }}" required></div>
            <div class="form-group"><label>Explanation</label><textarea name="explanation" class="form-control" rows="2">{{ old('explanation', $theoryQuestion->explanation) }}</textarea></div>
            <div class="form-group"><label>Difficulty</label><select name="difficulty" class="form-control">@foreach(['easy','medium','hard'] as $d)<option value="{{ $d }}" {{ old('difficulty', $theoryQuestion->difficulty) == $d ? 'selected' : '' }}>{{ ucfirst($d) }}</option>@endforeach</select></div>
            <div class="form-check"><input type="checkbox" name="is_active" value="1" class="form-check-input" {{ old('is_active', $theoryQuestion->is_active) ? 'checked' : '' }}><label class="form-check-label">Active</label></div>
        </div>
        <div class="card-footer"><button type="submit" class="btn btn-primary">Update</button><a href="{{ route('admin.theory.questions.index', $theoryQuestion->category) }}" class="btn btn-secondary">Cancel</a></div>
    </form>
</div>
@stop
