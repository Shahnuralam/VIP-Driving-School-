@extends('adminlte::page')

@section('title', 'Reschedule Requests')

@section('content_header')
    <h1>Reschedule Requests @if($pendingCount)<span class="badge badge-warning">{{ $pendingCount }} pending</span>@endif</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body table-responsive p-0">
        <table class="table table-hover">
            <thead>
                <tr><th>Booking</th><th>Customer</th><th>Original</th><th>Requested</th><th>Status</th><th>Actions</th></tr>
            </thead>
            <tbody>
                @forelse($requests as $r)
                <tr>
                    <td>{{ $r->booking->booking_reference ?? '-' }}</td>
                    <td>{{ $r->booking->customer_name ?? $r->customer->name ?? '-' }}</td>
                    <td>{{ $r->original_date->format('M j') }} {{ \Carbon\Carbon::parse($r->original_time)->format('g:i A') }}</td>
                    <td>{{ $r->requested_date->format('M j') }} @if($r->newSlot) {{ \Carbon\Carbon::parse($r->newSlot->start_time)->format('g:i A') }} @endif</td>
                    <td><span class="badge badge-{{ $r->getStatusBadgeClass() }}">{{ $r->status }}</span></td>
                    <td><a href="{{ route('admin.reschedule-requests.show', $r) }}" class="btn btn-sm btn-info">View</a></td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted">No reschedule requests.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($requests->hasPages())
    <div class="card-footer">{{ $requests->links('pagination::bootstrap-4') }}</div>
    @endif
</div>
@stop
