@extends('customer.layouts.app')

@section('title', 'My Bookings')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0"><i class="fas fa-calendar-check me-2"></i>My Bookings</h4>
    <a href="{{ route('book-online') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>New Booking
    </a>
</div>

<!-- Filter Tabs -->
<ul class="nav nav-pills mb-4">
    <li class="nav-item">
        <a class="nav-link {{ !request('status') || request('status') === 'all' ? 'active' : '' }}" 
           href="{{ route('customer.bookings') }}">All</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request('status') === 'upcoming' ? 'active' : '' }}" 
           href="{{ route('customer.bookings', ['status' => 'upcoming']) }}">Upcoming</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request('status') === 'completed' ? 'active' : '' }}" 
           href="{{ route('customer.bookings', ['status' => 'completed']) }}">Completed</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request('status') === 'cancelled' ? 'active' : '' }}" 
           href="{{ route('customer.bookings', ['status' => 'cancelled']) }}">Cancelled</a>
    </li>
</ul>

<!-- Bookings List -->
<div class="row g-4">
    @forelse($bookings as $booking)
    <div class="col-md-6">
        <div class="booking-card card h-100 {{ $booking->status }}">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <h5 class="mb-1">{{ $booking->service->name ?? $booking->package->name ?? 'Driving Lesson' }}</h5>
                        <small class="text-muted">Ref: {{ $booking->booking_reference }}</small>
                    </div>
                    <span class="badge bg-{{ $booking->status_badge }}">{{ ucfirst($booking->status) }}</span>
                </div>

                <div class="mb-3">
                    <p class="mb-1">
                        <i class="fas fa-calendar text-primary me-2"></i>
                        {{ $booking->booking_date->format('l, F j, Y') }}
                    </p>
                    <p class="mb-1">
                        <i class="fas fa-clock text-primary me-2"></i>
                        {{ \Carbon\Carbon::parse($booking->booking_time)->format('g:i A') }}
                    </p>
                    <p class="mb-0">
                        <i class="fas fa-map-marker-alt text-primary me-2"></i>
                        {{ $booking->location->name ?? 'TBA' }}
                    </p>
                </div>

                @if($booking->instructor)
                <p class="mb-3">
                    <i class="fas fa-user-tie text-primary me-2"></i>
                    Instructor: {{ $booking->instructor->name }}
                </p>
                @endif

                <div class="d-flex justify-content-between align-items-center">
                    <span class="fw-bold text-primary">${{ number_format($booking->amount, 2) }}</span>
                    <div>
                        <a href="{{ route('customer.bookings.show', $booking) }}" class="btn btn-sm btn-outline-primary">
                            View Details
                        </a>
                        @if($booking->status === 'completed' && !$booking->review)
                        <a href="{{ route('customer.reviews.create', $booking) }}" class="btn btn-sm btn-warning">
                            <i class="fas fa-star"></i> Review
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="card">
            <div class="card-body text-center py-5">
                <i class="fas fa-calendar-times fa-4x text-muted mb-3"></i>
                <h5>No bookings found</h5>
                <p class="text-muted mb-4">You haven't made any bookings yet</p>
                <a href="{{ route('book-online') }}" class="btn btn-primary">Book Your First Lesson</a>
            </div>
        </div>
    </div>
    @endforelse
</div>

<!-- Pagination -->
@if($bookings->hasPages())
<div class="d-flex justify-content-center mt-4">
    {{ $bookings->withQueryString()->links() }}
</div>
@endif
@endsection
