@extends('frontend.layouts.app')

@section('title', 'Booking Confirmed - VIP Driving School Hobart')

@section('content')
<!-- Confirmation Section -->
<section class="section-padding">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="confirmation-card text-center" data-aos="fade-up">
                    <div class="success-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <h1 class="mb-3">Booking Confirmed!</h1>
                    <p class="lead text-muted mb-4">Thank you for booking with VIP Driving School Hobart. Your booking has been confirmed.</p>

                    <div class="booking-details">
                        <div class="detail-item">
                            <span class="label">Booking Reference</span>
                            <span class="value text-primary fw-bold">{{ $booking->booking_reference }}</span>
                        </div>
                        <div class="detail-item">
                            <span class="label">Service</span>
                            <span class="value">
                                @if($booking->service)
                                    {{ $booking->service->name }}
                                @elseif($booking->package)
                                    {{ $booking->package->name }}
                                @else
                                    N/A
                                @endif
                            </span>
                        </div>
                        <div class="detail-item">
                            <span class="label">Date</span>
                            <span class="value">{{ $booking->booking_date->format('l, F j, Y') }}</span>
                        </div>
                        <div class="detail-item">
                            <span class="label">Time</span>
                            <span class="value">{{ \Carbon\Carbon::parse($booking->booking_time)->format('g:i A') }}</span>
                        </div>
                        @if($booking->location)
                        <div class="detail-item">
                            <span class="label">Location</span>
                            <span class="value">{{ $booking->location->name }}</span>
                        </div>
                        @endif
                        <div class="detail-item">
                            <span class="label">Amount Paid</span>
                            <span class="value text-success fw-bold">${{ number_format($booking->amount, 2) }}</span>
                        </div>
                    </div>

                    <div class="alert alert-info mt-4">
                        <i class="fas fa-envelope me-2"></i>
                        A confirmation email has been sent to <strong>{{ $booking->customer_email }}</strong>
                    </div>

                    <div class="mt-4">
                        <h5>What's Next?</h5>
                        <ul class="next-steps">
                            <li><i class="fas fa-check text-success me-2"></i>You will receive a confirmation email with all the details</li>
                            <li><i class="fas fa-check text-success me-2"></i>Our instructor will contact you before the lesson</li>
                            <li><i class="fas fa-check text-success me-2"></i>Please arrive 15 minutes before your scheduled time</li>
                            <li><i class="fas fa-check text-success me-2"></i>Bring your valid learner licence</li>
                        </ul>
                    </div>

                    <div class="d-flex gap-3 justify-content-center mt-4">
                        <a href="{{ route('frontend.home') }}" class="btn btn-outline-primary btn-lg">
                            <i class="fas fa-home me-2"></i>Back to Home
                        </a>
                        <a href="{{ route('book-online') }}" class="btn btn-book btn-lg">
                            <i class="fas fa-calendar-plus me-2"></i>Book Another Lesson
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('styles')
<style>
    .confirmation-card {
        background: white;
        border-radius: 20px;
        padding: 3rem;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    }

    .success-icon {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 2rem;
    }

    .success-icon i {
        font-size: 3rem;
        color: white;
    }

    .booking-details {
        background: #f8f9fa;
        border-radius: 12px;
        padding: 1.5rem;
        margin-top: 2rem;
    }

    .detail-item {
        display: flex;
        justify-content: space-between;
        padding: 0.75rem 0;
        border-bottom: 1px solid #e9ecef;
    }

    .detail-item:last-child {
        border-bottom: none;
    }

    .detail-item .label {
        color: #6c757d;
    }

    .detail-item .value {
        font-weight: 500;
    }

    .next-steps {
        list-style: none;
        padding: 0;
        text-align: left;
        max-width: 400px;
        margin: 1rem auto;
    }

    .next-steps li {
        padding: 0.5rem 0;
    }
</style>
@endsection
