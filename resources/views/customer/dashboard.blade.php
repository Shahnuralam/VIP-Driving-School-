@extends('customer.layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0">Welcome back, {{ $customer->name }}!</h4>
    <a href="{{ route('book-online') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Book a Lesson
    </a>
</div>

<!-- Stats -->
<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="stat-value">{{ $upcomingBookings->count() }}</div>
                    <div class="opacity-75">Upcoming Lessons</div>
                </div>
                <i class="fas fa-calendar-alt fa-2x opacity-50"></i>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card orange">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="stat-value">{{ $totalLessons }}</div>
                    <div class="opacity-75">Completed Lessons</div>
                </div>
                <i class="fas fa-check-circle fa-2x opacity-50"></i>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card green">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="stat-value">${{ number_format($totalSpent, 0) }}</div>
                    <div class="opacity-75">Total Spent</div>
                </div>
                <i class="fas fa-dollar-sign fa-2x opacity-50"></i>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Upcoming Bookings -->
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-calendar-check me-2"></i>Upcoming Bookings</span>
                <a href="{{ route('customer.bookings', ['status' => 'upcoming']) }}" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body">
                @forelse($upcomingBookings->take(3) as $booking)
                <div class="booking-card card mb-3 {{ $booking->status }}">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="mb-1">
                                    {{ $booking->service->name ?? $booking->package->name ?? 'Driving Lesson' }}
                                </h6>
                                <p class="text-muted mb-1">
                                    <i class="fas fa-calendar me-2"></i>{{ $booking->booking_date->format('l, F j, Y') }}
                                    <span class="ms-3"><i class="fas fa-clock me-2"></i>{{ \Carbon\Carbon::parse($booking->booking_time)->format('g:i A') }}</span>
                                </p>
                                <p class="text-muted mb-0">
                                    <i class="fas fa-map-marker-alt me-2"></i>{{ $booking->location->name ?? 'TBA' }}
                                </p>
                            </div>
                            <div class="text-end">
                                <span class="badge bg-{{ $booking->status_badge }} mb-2">{{ ucfirst($booking->status) }}</span>
                                <br>
                                <a href="{{ route('customer.bookings.show', $booking) }}" class="btn btn-sm btn-outline-primary">
                                    View Details
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-4">
                    <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                    <p class="text-muted mb-3">You don't have any upcoming bookings</p>
                    <a href="{{ route('book-online') }}" class="btn btn-primary">Book Your First Lesson</a>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Quick Actions & Pending Reviews -->
    <div class="col-lg-4">
        <!-- Quick Actions -->
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-bolt me-2"></i>Quick Actions
            </div>
            <div class="list-group list-group-flush">
                <a href="{{ route('book-online') }}" class="list-group-item list-group-item-action">
                    <i class="fas fa-plus-circle text-primary me-2"></i>Book New Lesson
                </a>
                <a href="{{ route('lesson-packages') }}" class="list-group-item list-group-item-action">
                    <i class="fas fa-box text-success me-2"></i>View Packages
                </a>
                <a href="{{ route('customer.profile') }}" class="list-group-item list-group-item-action">
                    <i class="fas fa-user-edit text-info me-2"></i>Update Profile
                </a>
                <a href="{{ route('contact') }}" class="list-group-item list-group-item-action">
                    <i class="fas fa-headset text-warning me-2"></i>Contact Support
                </a>
            </div>
        </div>

        <!-- Pending Reviews -->
        @if($pendingReviews->count() > 0)
        <div class="card">
            <div class="card-header">
                <i class="fas fa-star me-2"></i>Leave a Review
            </div>
            <div class="list-group list-group-flush">
                @foreach($pendingReviews as $booking)
                <div class="list-group-item">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-muted">{{ $booking->booking_date->format('M j, Y') }}</small>
                            <p class="mb-0">{{ $booking->service->name ?? $booking->package->name ?? 'Lesson' }}</p>
                        </div>
                        <a href="{{ route('customer.reviews.create', $booking) }}" class="btn btn-sm btn-warning">
                            <i class="fas fa-star"></i>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Recent Bookings -->
@if($pastBookings->count() > 0)
<div class="card mt-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fas fa-history me-2"></i>Recent History</span>
        <a href="{{ route('customer.bookings', ['status' => 'past']) }}" class="btn btn-sm btn-outline-primary">View All</a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Service</th>
                    <th>Location</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pastBookings as $booking)
                <tr>
                    <td>{{ $booking->booking_date->format('M j, Y') }}</td>
                    <td>{{ $booking->service->name ?? $booking->package->name ?? 'Lesson' }}</td>
                    <td>{{ $booking->location->name ?? '-' }}</td>
                    <td><span class="badge bg-{{ $booking->status_badge }}">{{ ucfirst($booking->status) }}</span></td>
                    <td>
                        <a href="{{ route('customer.bookings.show', $booking) }}" class="btn btn-sm btn-outline-primary">View</a>
                        @if($booking->status === 'completed' && !$booking->review)
                        <a href="{{ route('customer.reviews.create', $booking) }}" class="btn btn-sm btn-outline-warning">Review</a>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif
@endsection
