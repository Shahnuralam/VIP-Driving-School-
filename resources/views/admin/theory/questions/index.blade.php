@extends('adminlte::page')

@section('title', 'Questions - ' . $theoryCategory->name)

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Questions: {{ $theoryCategory->name }}</h1>
        <div>
            <a href="{{ route('admin.theory.categories.index') }}" class="btn btn-secondary">Back to Categories</a>
            <a href="{{ route('admin.theory.questions.create', $theoryCategory) }}" class="btn btn-primary"><i class="fas fa-plus"></i> Add Question</a>
        </div>
    </div>
@stop

@section('content')
<div class="card">
    <div class="card-body table-responsive p-0">
        <table class="table table-hover">
            <thead>
                <tr><th>#</th><th>Question</th><th>Type</th><th>Difficulty</th><th>Answered</th><th>Actions</th></tr>
            </thead>
            <tbody>
                @forelse($questions as $q)
                <tr>
                    <td>{{ $q->id }}</td>
                    <td>{{ Str::limit(strip_tags($q->question), 60) }}</td>
                    <td><span class="badge badge-{{ $q->getTypeBadgeClass() }}">{{ $q->getTypeLabel() }}</span></td>
                    <td><span class="badge badge-{{ $q->getDifficultyBadgeClass() }}">{{ $q->difficulty }}</span></td>
                    <td>{{ $q->times_answered }}</td>
                    <td>
                        <a href="{{ route('admin.theory.questions.edit', $q) }}" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('admin.theory.questions.destroy', $q) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this question?');">@csrf @method('DELETE')<button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button></form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted">No questions yet. Add your first question.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($questions->hasPages())
    <div class="card-footer">{{ $questions->links('pagination::bootstrap-4') }}</div>
    @endif
</div>
@stop
