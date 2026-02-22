@extends('frontend.layouts.app')

@section('title', 'Booking Confirmed - VIP Driving School Hobart')

@section('content')
<!-- Confirmation Section -->
<section class="section-padding bg-slate-50 min-vh-100 d-flex align-items-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="bg-white p-5 rounded-4 shadow-sm border border-slate-100 text-center" data-aos="fade-up">
                    <div class="mb-4">
                        <div class="d-inline-flex p-4 rounded-circle bg-success bg-opacity-10 text-success">
                            <i class="fas fa-check-circle fa-4x"></i>
                        </div>
                    </div>
                    <h1 class="fw-800 mb-3 text-secondary">Booking Confirmed!</h1>
                    <p class="text-slate-500 mb-5">Thank you for choosing VIP Driving School. Your session is locked in and a confirmation has been sent to your email.</p>

                    <div class="bg-slate-50 rounded-4 p-4 text-start mb-5 border border-slate-100">
                        <h6 class="fw-800 mb-3 text-secondary text-uppercase small" style="letter-spacing: 0.05em;">Booking Details</h6>
                        <div class="d-flex justify-content-between mb-2 pb-2 border-bottom border-slate-200">
                            <span class="text-slate-500">Reference:</span>
                            <span class="fw-bold text-secondary">{{ $booking->booking_reference }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2 pb-2 border-bottom border-slate-200">
                            <span class="text-slate-500">Service:</span>
                            <span class="fw-bold text-secondary">
                                @if($booking->service)
                                    {{ $booking->service->name }}
                                @elseif($booking->package)
                                    {{ $booking->package->name }}
                                @endif
                            </span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-slate-500">Date & Time:</span>
                            <span class="fw-bold text-secondary text-end">
                                {{ $booking->booking_date->format('l, F j, Y') }}<br>
                                <small class="text-primary">{{ \Carbon\Carbon::parse($booking->booking_time)->format('g:i A') }}</small>
                            </span>
                        </div>
                    </div>

                    <div class="row g-3 mb-5 text-start">
                        <div class="col-12">
                            <div class="d-flex gap-3">
                                <i class="fas fa-info-circle text-primary mt-1"></i>
                                <p class="small text-muted mb-0"><strong>What's Next?</strong> Your instructor will contact you before the lesson. Please have your learners licence ready.</p>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid gap-3">
                        <a href="{{ route('frontend.home') }}" class="btn btn-primary py-3 fw-bold">
                            Return Home
                        </a>
                        <a href="{{ route('customer.dashboard') }}" class="btn btn-outline-slate py-3 fw-bold">
                            Manage Booking
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
    .bg-slate-50 { background-color: var(--slate-50); }
    .text-slate-500 { color: var(--slate-500); }
    .text-secondary { color: var(--secondary-color); }
    .tracking-wider { letter-spacing: 0.05em; }
    .btn-outline-slate {
        border: 1px solid var(--slate-200);
        color: var(--secondary-color);
    }
    .btn-outline-slate:hover {
        background: var(--slate-50);
        border-color: var(--slate-300);
    }
</style>
@endsection
