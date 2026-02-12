@extends('adminlte::page')

@section('title', 'FAQs')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Frequently Asked Questions</h1>
        <a href="{{ route('admin.faqs.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add FAQ
        </a>
    </div>
@stop

@section('content')
<div class="card">
    <div class="card-body table-responsive p-0">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th style="width: 40%;">Question</th>
                    <th>Category</th>
                    <th>Page</th>
                    <th>Status</th>
                    <th>Order</th>
                    <th style="width: 100px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($faqs as $faq)
                <tr>
                    <td>
                        <strong>{{ Str::limit($faq->question, 80) }}</strong>
                        <br>
                        <small class="text-muted">{{ Str::limit(strip_tags($faq->answer), 60) }}</small>
                    </td>
                    <td>
                        @if($faq->category)
                            <span class="badge badge-primary">{{ ucfirst($faq->category) }}</span>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td>
                        @if($faq->page)
                            <span class="badge badge-info">{{ ucfirst(str_replace('-', ' ', $faq->page)) }}</span>
                        @else
                            <span class="badge badge-secondary">All Pages</span>
                        @endif
                    </td>
                    <td>
                        <span class="badge badge-{{ $faq->is_active ? 'success' : 'secondary' }}">
                            {{ $faq->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td>{{ $faq->sort_order }}</td>
                    <td>
                        <a href="{{ route('admin.faqs.edit', $faq) }}" class="btn btn-sm btn-info">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.faqs.destroy', $faq) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this FAQ?')">
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
                    <td colspan="6" class="text-center text-muted">No FAQs found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($faqs->hasPages())
    <div class="card-footer">
        {{ $faqs->links('pagination::bootstrap-4') }}
    </div>
    @endif
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card card-outline card-info">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-tags mr-2"></i>Categories</h3>
            </div>
            <div class="card-body">
                <p class="text-muted mb-2">Common FAQ categories:</p>
                <span class="badge badge-primary mr-1">general</span>
                <span class="badge badge-primary mr-1">packages</span>
                <span class="badge badge-primary mr-1">booking</span>
                <span class="badge badge-primary mr-1">payment</span>
                <span class="badge badge-primary mr-1">lessons</span>
                <span class="badge badge-primary mr-1">assessments</span>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card card-outline card-info">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-file-alt mr-2"></i>Available Pages</h3>
            </div>
            <div class="card-body">
                <p class="text-muted mb-2">FAQs can be displayed on:</p>
                <span class="badge badge-info mr-1">home</span>
                <span class="badge badge-info mr-1">lesson-packages</span>
                <span class="badge badge-info mr-1">book-online</span>
                <span class="badge badge-info mr-1">p1-assessments</span>
                <span class="badge badge-info mr-1">contact</span>
            </div>
        </div>
    </div>
</div>
@stop
