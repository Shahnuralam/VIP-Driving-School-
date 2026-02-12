@extends('adminlte::page')

@section('title', 'Theory Test Categories')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Theory Test Categories</h1>
        <a href="{{ route('admin.theory.categories.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Add Category</a>
    </div>
@stop

@section('content')
<div class="card">
    <div class="card-body table-responsive p-0">
        <table class="table table-hover">
            <thead>
                <tr><th>Name</th><th>Questions</th><th>Pass %</th><th>Time (min)</th><th>Status</th><th>Actions</th></tr>
            </thead>
            <tbody>
                @forelse($categories as $c)
                <tr>
                    <td>{{ $c->name }}</td>
                    <td>{{ $c->questions_count }}</td>
                    <td>{{ $c->pass_percentage }}%</td>
                    <td>{{ $c->time_limit_minutes }}</td>
                    <td><span class="badge badge-{{ $c->is_active ? 'success' : 'secondary' }}">{{ $c->is_active ? 'Active' : 'Inactive' }}</span></td>
                    <td>
                        <a href="{{ route('admin.theory.questions.index', $c) }}" class="btn btn-sm btn-info">Questions</a>
                        <a href="{{ route('admin.theory.categories.edit', $c) }}" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted">No categories yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($categories->hasPages())
    <div class="card-footer">{{ $categories->links('pagination::bootstrap-4') }}</div>
    @endif
</div>
@stop
