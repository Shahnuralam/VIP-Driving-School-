@extends('adminlte::page')

@section('title', 'Appointments')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Appointments</h1>
        <div>
            <a href="{{ route('admin.bookings.calendar') }}" class="btn btn-info">
                <i class="fas fa-calendar-alt"></i> Calendar View
            </a>
            <a href="{{ route('admin.bookings.export', request()->all()) }}" class="btn btn-success">
                <i class="fas fa-download"></i> Export CSV
            </a>
        </div>
    </div>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <form action="{{ route('admin.bookings.index') }}" method="GET" class="row">
            <div class="col-md-2">
                <input type="text" name="search" class="form-control" placeholder="Search..." value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <select name="status" class="form-control">
                    <option value="">All Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>
            <div class="col-md-2">
                <select name="payment_status" class="form-control">
                    <option value="">Payment Status</option>
                    <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Paid</option>
                    <option value="refunded" {{ request('payment_status') == 'refunded' ? 'selected' : '' }}>Refunded</option>
                </select>
            </div>
            <div class="col-md-2">
                <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}" placeholder="From">
            </div>
            <div class="col-md-2">
                <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}" placeholder="To">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-secondary">Filter</button>
                <a href="{{ route('admin.bookings.index') }}" class="btn btn-outline-secondary">Reset</a>
            </div>
        </form>
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
            <thead>
                <tr>
                    <th>Reference</th>
                    <th>Customer</th>
                    <th>Service</th>
                    <th>Date & Time</th>
                    <th>Amount</th>
                    <th>Status</th>
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
                        <small class="text-muted">{{ $booking->customer_email }}</small>
                    </td>
                    <td>{{ $booking->service?->name ?? 'Package Booking' }}</td>
                    <td>
                        {{ $booking->booking_date->format('M j, Y') }}<br>
                        <small>{{ \Carbon\Carbon::parse($booking->booking_time)->format('g:i A') }}</small>
                    </td>
                    <td>{{ $booking->formatted_amount }}</td>
                    <td><span class="badge badge-{{ $booking->status_badge }}">{{ ucfirst($booking->status) }}</span></td>
                    <td><span class="badge badge-{{ $booking->payment_badge }}">{{ ucfirst($booking->payment_status) }}</span></td>
                    <td>
                        <a href="{{ route('admin.bookings.show', $booking) }}" class="btn btn-sm btn-info">
                            <i class="fas fa-eye"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center text-muted">No appointments found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        {{ $bookings->withQueryString()->links('pagination::bootstrap-4') }}
    </div>
</div>
@stop
