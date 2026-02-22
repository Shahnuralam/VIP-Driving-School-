@extends('adminlte::page')

@section('title', 'Pending Appointments')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1><i class="fas fa-clock text-warning mr-2"></i>Pending Appointments</h1>
        <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary">
            <i class="fas fa-list"></i> All Appointments
        </a>
    </div>
@stop

@section('content')
<div class="card">
    <div class="card-body table-responsive p-0">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Reference</th>
                    <th>Customer</th>
                    <th>Service</th>
                    <th>Date & Time</th>
                    <th>Amount</th>
                    <th>Payment</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookings as $booking)
                <tr>
                    <td><a href="{{ route('admin.bookings.show', $booking) }}">{{ $booking->booking_reference }}</a></td>
                    <td>
                        <strong>{{ $booking->customer_name }}</strong><br>
                        <small class="text-muted">{{ $booking->customer_phone }}</small>
                    </td>
                    <td>{{ $booking->service?->name ?? 'Package' }}</td>
                    <td>
                        {{ $booking->booking_date->format('M j, Y') }}<br>
                        <small>{{ \Carbon\Carbon::parse($booking->booking_time)->format('g:i A') }}</small>
                    </td>
                    <td>{{ $booking->formatted_amount }}</td>
                    <td><span class="badge badge-{{ $booking->payment_badge }}">{{ ucfirst($booking->payment_status) }}</span></td>
                    <td>
                        <form action="{{ route('admin.bookings.update-status', $booking) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="confirmed">
                            <button type="submit" class="btn btn-sm btn-success" title="Confirm">
                                <i class="fas fa-check"></i> Confirm
                            </button>
                        </form>
                        <a href="{{ route('admin.bookings.show', $booking) }}" class="btn btn-sm btn-info" title="View">
                            <i class="fas fa-eye"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-4">
                        <i class="fas fa-check-circle fa-3x mb-3 text-success"></i>
                        <p>No pending appointments! All caught up.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        {{ $bookings->links('pagination::bootstrap-4') }}
    </div>
</div>
@stop
