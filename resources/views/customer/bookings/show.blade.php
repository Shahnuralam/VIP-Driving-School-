@extends('customer.layouts.app')

@section('title', 'Booking Details')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <a href="{{ route('customer.bookings') }}" class="text-decoration-none">
            <i class="fas fa-arrow-left me-2"></i>Back to Bookings
        </a>
        <h4 class="mt-2 mb-0">Booking #{{ $booking->booking_reference }}</h4>
    </div>
    <span class="badge bg-{{ $booking->status_badge }} fs-6">{{ ucfirst($booking->status) }}</span>
</div>

<div class="row g-4">
    <!-- Main Details -->
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-info-circle me-2"></i>Booking Details
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small">Service/Package</label>
                        <p class="fw-bold mb-0">{{ $booking->service->name ?? $booking->package->name ?? 'Driving Lesson' }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small">Location</label>
                        <p class="fw-bold mb-0">{{ $booking->location->name ?? 'TBA' }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small">Date</label>
                        <p class="fw-bold mb-0">{{ $booking->booking_date->format('l, F j, Y') }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small">Time</label>
                        <p class="fw-bold mb-0">{{ \Carbon\Carbon::parse($booking->booking_time)->format('g:i A') }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small">Transmission</label>
                        <p class="fw-bold mb-0">{{ ucfirst($booking->transmission_type) }}</p>
                    </div>
                    @if($booking->instructor)
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small">Instructor</label>
                        <p class="fw-bold mb-0">{{ $booking->instructor->name }}</p>
                    </div>
                    @endif
                    @if($booking->pickup_address)
                    <div class="col-12 mb-3">
                        <label class="text-muted small">Pickup Address</label>
                        <p class="fw-bold mb-0">{{ $booking->pickup_address }}</p>
                    </div>
                    @endif
                    @if($booking->notes)
                    <div class="col-12">
                        <label class="text-muted small">Your Notes</label>
                        <p class="mb-0">{{ $booking->notes }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Payment Info -->
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-credit-card me-2"></i>Payment Information
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="text-muted small">Amount</label>
                        <p class="fw-bold mb-0 fs-5">${{ number_format($booking->amount, 2) }}</p>
                    </div>
                    @if($booking->discount_amount > 0)
                    <div class="col-md-4 mb-3">
                        <label class="text-muted small">Discount</label>
                        <p class="text-success fw-bold mb-0">-${{ number_format($booking->discount_amount, 2) }}</p>
                    </div>
                    @endif
                    @if($booking->voucher_amount_used > 0)
                    <div class="col-md-4 mb-3">
                        <label class="text-muted small">Voucher Applied</label>
                        <p class="text-success fw-bold mb-0">-${{ number_format($booking->voucher_amount_used, 2) }}</p>
                    </div>
                    @endif
                    <div class="col-md-4 mb-3">
                        <label class="text-muted small">Payment Status</label>
                        <p class="mb-0"><span class="badge bg-{{ $booking->payment_badge }}">{{ ucfirst($booking->payment_status) }}</span></p>
                    </div>
                    @if($booking->paid_at)
                    <div class="col-md-4 mb-3">
                        <label class="text-muted small">Paid On</label>
                        <p class="mb-0">{{ $booking->paid_at->format('M j, Y g:i A') }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Reschedule Request -->
        @if($booking->rescheduleRequests->where('status', 'pending')->count() > 0)
        <div class="alert alert-info">
            <i class="fas fa-clock me-2"></i>
            <strong>Reschedule Request Pending:</strong> Your reschedule request is being reviewed.
        </div>
        @endif

        <!-- Cancellation Request -->
        @if($booking->cancellationRequest && $booking->cancellationRequest->status === 'pending')
        <div class="alert alert-warning">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <strong>Cancellation Request Pending:</strong> Your cancellation request is being reviewed.
        </div>
        @endif

        <!-- Review Section -->
        @if($booking->status === 'completed')
        <div class="card">
            <div class="card-header">
                <i class="fas fa-star me-2"></i>Your Review
            </div>
            <div class="card-body">
                @if($booking->review)
                <div class="mb-3">
                    <div class="text-warning mb-2">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star{{ $i <= $booking->review->overall_rating ? '' : '-o' }}"></i>
                        @endfor
                        <span class="text-dark ms-2">({{ $booking->review->overall_rating }}/5)</span>
                    </div>
                    @if($booking->review->title)
                    <h6>{{ $booking->review->title }}</h6>
                    @endif
                    <p class="mb-2">{{ $booking->review->content }}</p>
                    <small class="text-muted">
                        Submitted {{ $booking->review->created_at->format('M j, Y') }}
                        @if($booking->review->status === 'approved')
                        <span class="badge bg-success ms-2">Published</span>
                        @else
                        <span class="badge bg-warning ms-2">Pending Review</span>
                        @endif
                    </small>
                </div>
                @else
                <p class="text-muted mb-3">Share your experience with us!</p>
                <a href="{{ route('customer.reviews.create', $booking) }}" class="btn btn-warning">
                    <i class="fas fa-star me-2"></i>Write a Review
                </a>
                @endif
            </div>
        </div>
        @endif
    </div>

    <!-- Sidebar -->
    <div class="col-lg-4">
        <!-- Actions -->
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-cogs me-2"></i>Actions
            </div>
            <div class="list-group list-group-flush">
                @if($booking->canBeRescheduled())
                <a href="{{ route('customer.bookings.reschedule', $booking) }}" class="list-group-item list-group-item-action">
                    <i class="fas fa-calendar-alt text-primary me-2"></i>Reschedule Booking
                </a>
                @endif

                @if($booking->canBeCancelled() && (!$booking->cancellationRequest || $booking->cancellationRequest->status !== 'pending'))
                <a href="{{ route('customer.bookings.cancel', $booking) }}" class="list-group-item list-group-item-action text-danger">
                    <i class="fas fa-times-circle me-2"></i>Request Cancellation
                </a>
                @endif

                <a href="{{ route('customer.bookings.rebook', $booking) }}" class="list-group-item list-group-item-action">
                    <i class="fas fa-redo text-success me-2"></i>Book Again
                </a>

                <a href="{{ route('contact') }}" class="list-group-item list-group-item-action">
                    <i class="fas fa-headset text-info me-2"></i>Contact Support
                </a>
            </div>
        </div>

        <!-- Location Map -->
        @if($booking->location)
        <div class="card">
            <div class="card-header">
                <i class="fas fa-map-marker-alt me-2"></i>Location
            </div>
            <div class="card-body">
                <h6>{{ $booking->location->name }}</h6>
                <p class="text-muted mb-0">{{ $booking->location->address }}</p>
                @if($booking->location->departure_info)
                <hr>
                <small class="text-muted"><strong>Departure Info:</strong> {{ $booking->location->departure_info }}</small>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
