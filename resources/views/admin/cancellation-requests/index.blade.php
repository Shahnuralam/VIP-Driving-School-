@extends('adminlte::page')

@section('title', 'Cancellation Requests')

@section('content_header')
    <h1>Cancellation / Refund Requests @if($pendingCount)<span class="badge badge-warning">{{ $pendingCount }} pending</span>@endif</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body table-responsive p-0">
        <table class="table table-hover">
            <thead>
                <tr><th>Booking</th><th>Customer</th><th>Reason</th><th>Status</th><th>Actions</th></tr>
            </thead>
            <tbody>
                @forelse($requests as $r)
                <tr>
                    <td>{{ $r->booking->booking_reference ?? '-' }}</td>
                    <td>{{ $r->booking->customer_name ?? $r->customer->name ?? '-' }}</td>
                    <td>{{ Str::limit($r->reason, 50) }}</td>
                    <td><span class="badge badge-{{ $r->getStatusBadgeClass() }}">{{ $r->status }}</span></td>
                    <td><a href="{{ route('admin.cancellation-requests.show', $r) }}" class="btn btn-sm btn-info">View / Process</a></td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-muted">No cancellation requests.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($requests->hasPages())
    <div class="card-footer">{{ $requests->links('pagination::bootstrap-4') }}</div>
    @endif
</div>
@stop
