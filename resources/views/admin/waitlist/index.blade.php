@extends('adminlte::page')

@section('title', 'Waitlist')

@section('content_header')
    <h1>Waitlist</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body table-responsive p-0">
        <table class="table table-hover">
            <thead>
                <tr><th>Customer</th><th>Service/Package</th><th>Location</th><th>Preferred Date</th><th>Status</th><th>Actions</th></tr>
            </thead>
            <tbody>
                @forelse($waitlists as $w)
                <tr>
                    <td>{{ $w->customer_name }}<br><small>{{ $w->customer_email }}</small></td>
                    <td>{{ $w->service->name ?? $w->package->name ?? '-' }}</td>
                    <td>{{ $w->location->name ?? '-' }}</td>
                    <td>{{ $w->preferred_date->format('M j, Y') }}</td>
                    <td><span class="badge badge-{{ $w->getStatusBadgeClass() }}">{{ $w->status }}</span></td>
                    <td><a href="{{ route('admin.waitlist.show', $w) }}" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a></td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted">No waitlist entries.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($waitlists->hasPages())
    <div class="card-footer">{{ $waitlists->links('pagination::bootstrap-4') }}</div>
    @endif
</div>
@stop
