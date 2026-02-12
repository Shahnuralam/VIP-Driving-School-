@extends('adminlte::page')

@section('title', 'Pages')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Pages</h1>
        <a href="{{ route('admin.pages.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add Page
        </a>
    </div>
@stop

@section('content')
<div class="card">
    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Slug</th>
                    <th>Menu Display</th>
                    <th>Status</th>
                    <th>Order</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pages as $page)
                <tr>
                    <td>{{ $page->id }}</td>
                    <td>
                        <strong>{{ $page->title }}</strong>
                        @if($page->featured_image)
                            <i class="fas fa-image text-muted ml-2" title="Has image"></i>
                        @endif
                    </td>
                    <td><code>/{{ $page->slug }}</code></td>
                    <td>
                        @if($page->show_in_navbar)
                            <span class="badge badge-primary" title="Navbar Order: {{ $page->navbar_order }}">
                                <i class="fas fa-bars"></i> Navbar
                            </span>
                        @endif
                        @if($page->show_in_footer)
                            <span class="badge badge-info" title="Footer Order: {{ $page->footer_order }}">
                                <i class="fas fa-shoe-prints"></i> Footer
                            </span>
                        @endif
                        @if(!$page->show_in_navbar && !$page->show_in_footer)
                            <span class="badge badge-secondary">None</span>
                        @endif
                    </td>
                    <td>
                        <span class="badge badge-{{ $page->is_active ? 'success' : 'secondary' }}">
                            {{ $page->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td>{{ $page->sort_order }}</td>
                    <td>
                        <a href="{{ url('/' . $page->slug) }}" class="btn btn-sm btn-outline-info" target="_blank" title="View Page">
                            <i class="fas fa-external-link-alt"></i>
                        </a>
                        <a href="{{ route('admin.pages.edit', $page) }}" class="btn btn-sm btn-info">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.pages.destroy', $page) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this page?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted">No pages found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($pages->hasPages())
    <div class="card-footer">
        {{ $pages->links('pagination::bootstrap-4') }}
    </div>
    @endif
</div>
@stop
