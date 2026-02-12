@extends('adminlte::page')

@section('title', 'Blog Categories')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Blog Categories</h1>
        <a href="{{ route('admin.blog.categories.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Add Category</a>
    </div>
@stop

@section('content')
<div class="card">
    <div class="card-body table-responsive p-0">
        <table class="table table-hover">
            <thead>
                <tr><th>Name</th><th>Slug</th><th>Posts</th><th>Status</th><th>Actions</th></tr>
            </thead>
            <tbody>
                @forelse($categories as $c)
                <tr>
                    <td>{{ $c->name }}</td>
                    <td><code>{{ $c->slug }}</code></td>
                    <td>{{ $c->posts_count ?? 0 }}</td>
                    <td><span class="badge badge-{{ $c->is_active ? 'success' : 'secondary' }}">{{ $c->is_active ? 'Active' : 'Inactive' }}</span></td>
                    <td>
                        <a href="{{ route('admin.blog.categories.edit', $c) }}" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('admin.blog.categories.destroy', $c) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this category?');">@csrf @method('DELETE')<button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button></form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-muted">No categories yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($categories->hasPages())
    <div class="card-footer">{{ $categories->links('pagination::bootstrap-4') }}</div>
    @endif
</div>
@stop
