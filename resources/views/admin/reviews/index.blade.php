@extends('adminlte::page')

@section('title', 'Reviews')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Customer Reviews @if($pendingCount)<span class="badge badge-warning">{{ $pendingCount }} pending</span>@endif</h1>
    </div>
@stop

@section('content')
<div class="card">
    <div class="card-body table-responsive p-0">
        <table class="table table-hover">
            <thead>
                <tr><th>Customer</th><th>Rating</th><th>Content</th><th>Status</th><th>Date</th><th>Actions</th></tr>
            </thead>
            <tbody>
                @forelse($reviews as $r)
                <tr>
                    <td>{{ $r->customer_name }}</td>
                    <td>{{ $r->overall_rating }}/5 <i class="fas fa-star text-warning"></i></td>
                    <td>{{ Str::limit($r->content, 50) }}</td>
                    <td><span class="badge badge-{{ $r->getStatusBadgeClass() }}">{{ ucfirst($r->status) }}</span></td>
                    <td>{{ $r->created_at->format('M j, Y') }}</td>
                    <td>
                        <a href="{{ route('admin.reviews.show', $r) }}" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>
                        @if($r->status === 'pending')
                        <form action="{{ route('admin.reviews.approve', $r) }}" method="POST" class="d-inline">@csrf<button type="submit" class="btn btn-sm btn-success">Approve</button></form>
                        <form action="{{ route('admin.reviews.reject', $r) }}" method="POST" class="d-inline">@csrf<button type="submit" class="btn btn-sm btn-danger">Reject</button></form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted">No reviews yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($reviews->hasPages())
    <div class="card-footer">{{ $reviews->links('pagination::bootstrap-4') }}</div>
    @endif
</div>
@stop
