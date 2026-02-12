@extends('adminlte::page')

@section('title', 'Blog Posts')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Blog Posts</h1>
        <a href="{{ route('admin.blog.posts.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Add Post</a>
    </div>
@stop

@section('content')
<div class="card">
    <div class="card-body table-responsive p-0">
        <table class="table table-hover">
            <thead>
                <tr><th>Title</th><th>Category</th><th>Status</th><th>Published</th><th>Views</th><th>Actions</th></tr>
            </thead>
            <tbody>
                @forelse($posts as $p)
                <tr>
                    <td>{{ $p->title }}</td>
                    <td>{{ $p->category->name ?? '-' }}</td>
                    <td><span class="badge badge-{{ $p->getStatusBadgeClass() }}">{{ $p->status }}</span></td>
                    <td>{{ $p->published_at ? $p->published_at->format('M j, Y') : '-' }}</td>
                    <td>{{ $p->views_count }}</td>
                    <td>
                        <a href="{{ route('admin.blog.posts.edit', $p) }}" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('admin.blog.posts.destroy', $p) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this post?');">@csrf @method('DELETE')<button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button></form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted">No posts yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($posts->hasPages())
    <div class="card-footer">{{ $posts->links('pagination::bootstrap-4') }}</div>
    @endif
</div>
@stop
