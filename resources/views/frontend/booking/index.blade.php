@extends('frontend.layouts.app')

@section('title', 'Book Online - VIP Driving School Hobart')

@section('content')
<!-- Page Header -->
<section class="page-header">
    <div class="container" data-aos="fade-up">
        <span class="section-tag" style="color: var(--primary-color);">Reservation</span>
        <h1>Book Online</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('frontend.home') }}">Home</a></li>
                <li class="breadcrumb-item active">Book Online</li>
            </ol>
        </nav>
    </div>
</section>

<!-- Booking Section -->
<section class="section-padding">
    <div class="container">
        <div class="row g-5">
            <!-- Booking Form -->
            <div class="col-lg-8">
                <div class="booking-form-card" data-aos="fade-up">
                    <h3 class="fw-800 mb-4">Schedule Your Lesson</h3>

                    <!-- Step Indicator -->
                    <div class="booking-steps mb-5">
                        <div class="step active" data-step="1">
                            <span class="step-num">1</span>
                            <span class="step-lbl">Service</span>
                        </div>
                        <div class="step" data-step="2">
                            <span class="step-num">2</span>
                            <span class="step-lbl">Time</span>
                        </div>
                        <div class="step" data-step="3">
                            <span class="step-num">3</span>
                            <span class="step-lbl">Details</span>
                        </div>
                        <div class="step" data-step="4">
                            <span class="step-num">4</span>
                            <span class="step-lbl">Pay</span>
                        </div>
                    </div>

                    <form id="bookingForm" method="POST" action="{{ route('book-online.store') }}">
                        @csrf

                        <!-- Step 1: Service Selection -->
                        <div class="booking-step" id="step1">
                            <h4 class="fw-800 mb-4 h5">Select a Service</h4>

                            <!-- Service Category Filter -->
                            <div class="mb-4">
                                <div class="category-buttons d-flex gap-2 flex-wrap">
                                    <button type="button" class="btn btn-outline-slate btn-sm rounded-pill px-4 active" data-category="all">All</button>
                                    @foreach($categories as $category)
                                    <button type="button" class="btn btn-outline-slate btn-sm rounded-pill px-4" data-category="{{ $category->id }}">{{ $category->name }}</button>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Services Grid -->
                            <div class="services-list d-grid gap-3">
                                @foreach($services as $service)
                                <div class="service-option-item" data-category="{{ $service->category_id }}">
                                    <input type="radio" name="service_id" id="service_{{ $service->id }}" class="btn-check" value="{{ $service->id }}" data-price="{{ $service->price }}" data-duration="{{ $service->duration_minutes }}" {{ request('service') == $service->id ? 'checked' : '' }}>
                                    <label class="btn btn-outline-slate w-100 text-start p-4 rounded-4 shadow-sm" for="service_{{ $service->id }}">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="fw-800 mb-1 h5">{{ $service->name }}</h6>
                                                <p class="text-muted small mb-0">{{ Str::limit($service->description, 80) }}</p>
                                                <div class="mt-2 d-flex gap-3">
                                                    @if($service->duration_minutes)
                                                    <span class="small fw-bold text-primary"><i class="fas fa-clock me-1"></i>{{ $service->duration_minutes }}m</span>
                                                    @endif
                                                    <span class="small fw-bold text-secondary"><i class="fas fa-tag me-1"></i>${{ number_format($service->price, 0) }}</span>
                                                </div>
                                            </div>
                                            <div class="check-mark bg-primary rounded-circle text-white d-flex align-items-center justify-content-center" style="width: 24px; height: 24px; opacity: 0;">
                                                <i class="fas fa-check small"></i>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                                @endforeach
                            </div>

                            <!-- Packages Option -->
                            @if($packages->count() > 0)
                            <div class="mt-5 pt-5 border-top">
                                <h5 class="fw-800 mb-4 h6 text-uppercase text-slate-400" style="letter-spacing: 0.1em;">Or Choose a Package</h5>
                                <div class="packages-list row g-3">
                                    @foreach($packages->take(3) as $package)
                                    <div class="col-md-4">
                                        <div class="package-option-item h-100">
                                            <input type="radio" name="package_id" id="package_{{ $package->id }}" class="btn-check" value="{{ $package->id }}" data-price="{{ $package->price }}" {{ request('package') == $package->id ? 'checked' : '' }}>
                                            <label class="btn btn-outline-slate w-100 text-start p-4 rounded-4 shadow-sm h-100 d-flex flex-column justify-content-between position-relative" for="package_{{ $package->id }}">
                                                <div>
                                                    <h6 class="fw-800 mb-2">{{ $package->name }}</h6>
                                                    <div class="d-flex align-items-baseline gap-1">
                                                        <span class="fs-4 fw-800 text-primary">${{ number_format($package->price, 0) }}</span>
                                                        @if($package->duration_hours)
                                                        <span class="small text-slate-500">/ {{ $package->duration_hours }}h</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="check-mark-wrapper position-absolute" style="top: 15px; right: 15px;">
                                                    <div class="check-mark bg-primary rounded-circle text-white d-flex align-items-center justify-content-center" style="width: 20px; height: 20px; opacity: 0; transition: opacity 0.2s;">
                                                        <i class="fas fa-check" style="font-size: 10px;"></i>
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                <div class="mt-4">
                                    <a href="{{ route('lesson-packages') }}" class="text-primary fw-bold small text-decoration-none d-inline-flex align-items-center">
                                        View all packages <i class="fas fa-arrow-right ms-2"></i>
                                    </a>
                                </div>
                            </div>
                            @endif

                            <div class="step-actions">
                                <button type="button" class="btn btn-book next-step" data-next="2">
                                    Continue <i class="fas fa-arrow-right ms-2"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Step 2: Date & Time Selection -->
                        <div class="booking-step d-none" id="step2">
                            <h4 class="step-title">Select Date & Time</h4>

                            <!-- Location Selection -->
                            <div class="mb-4">
                                <label class="form-label fw-bold">Preferred Location</label>
                                <select name="location_id" id="locationSelect" class="form-select form-select-lg">
                                    <option value="">Select a location</option>
                                    @foreach($locations as $location)
                                    <option value="{{ $location->id }}">{{ $location->name }} - {{ $location->address }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Instructor Selection -->
                            <div class="mb-4">
                                <label class="form-label fw-bold">Preferred Instructor (Optional)</label>
                                <select name="instructor_id" id="instructorSelect" class="form-select form-select-lg">
                                    <option value="">Any Instructor</option>
                                    @foreach($instructors as $instructor)
                                    <option value="{{ $instructor->id }}">{{ $instructor->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Calendar -->
                            <div class="mb-4">
                                <label class="form-label fw-bold">Available Dates</label>
                                <div id="bookingCalendar"></div>
                            </div>

                            <!-- Time Slots -->
                            <div class="mb-4 d-none" id="timeSlotsContainer">
                                <label class="form-label fw-bold">Available Time Slots</label>
                                <div id="timeSlots" class="time-slots-grid"></div>
                                <input type="hidden" name="slot_id" id="selectedSlotId">
                                <input type="hidden" name="booking_date" id="selectedDate">
                                <input type="hidden" name="booking_time" id="selectedTime">
                            </div>

                            <div class="step-actions">
                                <button type="button" class="btn btn-outline-secondary prev-step" data-prev="1">
                                    <i class="fas fa-arrow-left me-2"></i>Back
                                </button>
                                <button type="button" class="btn btn-book next-step" data-next="3">
                                    Continue <i class="fas fa-arrow-right ms-2"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Step 3: Personal Details -->
                        <div class="booking-step d-none" id="step3">
                            <h4 class="step-title">Your Details</h4>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">First Name *</label>
                                    <input type="text" name="first_name" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Last Name *</label>
                                    <input type="text" name="last_name" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Email Address *</label>
                                    <input type="email" name="email" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Phone Number *</label>
                                    <input type="tel" name="phone" class="form-control" required>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Pickup Address</label>
                                    <input type="text" name="pickup_address" class="form-control" placeholder="Enter your pickup address">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Learner Licence Number</label>
                                    <input type="text" name="licence_number" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Transmission Preference</label>
                                    <select name="transmission" class="form-select">
                                        <option value="auto">Automatic</option>
                                        <option value="manual">Manual</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Special Requirements or Notes</label>
                                    <textarea name="notes" class="form-control" rows="3" placeholder="Any special requirements or information we should know"></textarea>
                                </div>
                            </div>

                            <div class="step-actions">
                                <button type="button" class="btn btn-outline-secondary prev-step" data-prev="2">
                                    <i class="fas fa-arrow-left me-2"></i>Back
                                </button>
                                <button type="button" class="btn btn-book next-step" data-next="4">
                                    Continue to Payment <i class="fas fa-arrow-right ms-2"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Step 4: Payment -->
                        <div class="booking-step d-none" id="step4">
                            <h4 class="step-title">Payment</h4>

                            <!-- Booking Summary -->
                            <div class="booking-summary mb-4">
                                <h5>Booking Summary</h5>
                                <div class="summary-item">
                                    <span>Service:</span>
                                    <span id="summaryService">-</span>
                                </div>
                                <div class="summary-item">
                                    <span>Date:</span>
                                    <span id="summaryDate">-</span>
                                </div>
                                <div class="summary-item">
                                    <span>Time:</span>
                                    <span id="summaryTime">-</span>
                                </div>
                                <div class="summary-item">
                                    <span>Location:</span>
                                    <span id="summaryLocation">-</span>
                                </div>
                                <div class="summary-item">
                                    <span>Instructor:</span>
                                    <span id="summaryInstructor">-</span>
                                </div>
                                <div class="summary-total">
                                    <span>Total:</span>
                                    <span id="summaryTotal">$0</span>
                                </div>
                            </div>

                            <!-- Stripe Payment -->
                            <div class="payment-section">
                                <label class="form-label fw-bold">Card Details</label>
                                <div id="card-element" class="stripe-card-element"></div>
                                <div id="card-errors" class="text-danger mt-2"></div>
                            </div>

                            <div class="form-check mt-4">
                                <input class="form-check-input" type="checkbox" id="termsCheck" required>
                                <label class="form-check-label" for="termsCheck">
                                    I agree to the <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal">terms and conditions</a>
                                </label>
                            </div>

                            <div class="step-actions">
                                <button type="button" class="btn btn-outline-secondary prev-step" data-prev="3">
                                    <i class="fas fa-arrow-left me-2"></i>Back
                                </button>
                                <button type="submit" class="btn btn-book btn-lg" id="submitBtn">
                                    <i class="fas fa-lock me-2"></i>Pay & Confirm Booking
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Info Cards -->
                @if($infoCards->count() > 0)
                <div class="sidebar-card mb-4" data-aos="fade-left">
                    <h4><i class="fas fa-info-circle text-primary me-2"></i>Important Information</h4>
                    @foreach($infoCards as $card)
                    <div class="info-item">
                        <i class="{{ $card->icon ?? 'fas fa-check' }} text-success"></i>
                        <div>
                            <strong>{{ $card->title }}</strong>
                            <p class="text-muted small mb-0">{{ $card->content }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif

                <!-- Contact Card -->
                <div class="sidebar-card" data-aos="fade-left" data-aos-delay="100">
                    <h4><i class="fas fa-headset text-primary me-2"></i>Need Help?</h4>
                    <p class="text-muted">If you have any questions or need assistance with your booking, please contact us.</p>
                    <div class="contact-info">
                        <div class="mb-2">
                            <i class="fas fa-phone text-primary me-2"></i>
                            <a href="tel:{{ $settings['contact_phone'] ?? '0400000000' }}">{{ $settings['contact_phone'] ?? '0400 000 000' }}</a>
                        </div>
                        <div>
                            <i class="fas fa-envelope text-primary me-2"></i>
                            <a href="mailto:{{ $settings['contact_email'] ?? 'info@vipdrivingschool.com.au' }}">{{ $settings['contact_email'] ?? 'info@vipdrivingschool.com.au' }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Terms Modal -->
<div class="modal fade" id="termsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Terms and Conditions</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <h6>Booking Terms</h6>
                <ul>
                    <li>Bookings must be cancelled at least 24 hours in advance for a full refund.</li>
                    <li>Cancellations made less than 24 hours before the lesson will incur a 50% cancellation fee.</li>
                    <li>No-shows will be charged the full lesson amount.</li>
                    <li>Students must hold a valid learner's licence at the time of the lesson.</li>
                    <li>The instructor reserves the right to terminate a lesson early if the student is deemed unfit to drive.</li>
                </ul>
                <h6>Payment Terms</h6>
                <ul>
                    <li>Payment is required at the time of booking.</li>
                    <li>All prices are in Australian Dollars (AUD) and include GST.</li>
                    <li>Package credits are valid for the period specified at the time of purchase.</li>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">I Understand</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .booking-form-card {
        background: white;
        border-radius: 20px;
        padding: 3rem;
        border: 1px solid var(--slate-200);
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    }

    .booking-steps {
        display: flex;
        justify-content: space-between;
        position: relative;
    }

    .booking-steps::before {
        content: '';
        position: absolute;
        top: 20px;
        left: 0;
        right: 0;
        height: 2px;
        background: var(--slate-100);
        z-index: 0;
    }

    .step {
        display: flex;
        flex-direction: column;
        align-items: center;
        z-index: 1;
        background: white;
        padding: 0 10px;
    }

    .step-num {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        background: var(--slate-50);
        color: var(--slate-400);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        margin-bottom: 8px;
        border: 2px solid var(--slate-100);
        transition: all 0.3s ease;
    }

    .step.active .step-num {
        background: var(--primary-color);
        color: var(--secondary-color);
        border-color: var(--primary-color);
        transform: scale(1.1);
    }

    .step.completed .step-num {
        background: var(--secondary-color);
        color: var(--white);
        border-color: var(--secondary-color);
    }

    .step-lbl {
        font-size: 0.75rem;
        font-weight: 700;
        color: var(--slate-400);
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .step.active .step-lbl { color: var(--secondary-color); }

    .btn-outline-slate {
        border: 1px solid var(--slate-200);
        color: var(--secondary-color);
    }

    .btn-outline-slate:hover {
        background: var(--slate-50);
        border-color: var(--slate-300);
    }

    .btn-check:checked + label {
        border-color: var(--primary-color) !important;
        background-color: rgba(245, 158, 11, 0.08) !important;
        box-shadow: 0 8px 20px rgba(245, 158, 11, 0.15) !important;
    }

    .btn-check:checked + label .check-mark {
        opacity: 1 !important;
    }

    /* Force hide standard radio buttons if btn-check is failing */
    input.btn-check {
        display: none !important;
    }

    .btn-outline-slate {
        border: 2px solid var(--slate-100) !important;
        background: white !important;
        color: var(--secondary-color) !important;
        display: block !important;
        position: relative;
        transition: all 0.3s ease !important;
    }

    .btn-outline-slate:hover {
        border-color: var(--slate-200) !important;
        background: var(--slate-50) !important;
    }

    .time-slot {
        background: white;
        border: 1px solid var(--slate-200);
        border-radius: 12px;
        padding: 1rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .time-slot:hover {
        border-color: var(--primary-color);
        background: var(--slate-50);
    }

    .time-slot.selected {
        background: var(--secondary-color);
        border-color: var(--secondary-color);
        color: white;
    }

    .time-slot.selected .instructor-name {
        color: var(--slate-400);
    }

    .time-slot.unavailable {
        opacity: 0.4;
        cursor: not-allowed;
        background: var(--slate-50);
    }

    .step-actions {
        display: flex;
        justify-content: space-between;
        margin-top: 2rem;
        padding-top: 1.5rem;
        border-top: 2px solid #f0f0f0;
    }

    .booking-summary {
        background: #f8f9fa;
        border-radius: 12px;
        padding: 1.5rem;
    }

    .booking-summary h5 {
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 1px solid #e0e0e0;
    }

    .summary-item {
        display: flex;
        justify-content: space-between;
        padding: 0.5rem 0;
    }

    .summary-total {
        display: flex;
        justify-content: space-between;
        padding-top: 1rem;
        margin-top: 0.5rem;
        border-top: 2px solid #e0e0e0;
        font-size: 1.25rem;
        font-weight: 700;
    }

    .summary-total span:last-child {
        color: var(--primary-color);
    }

    .stripe-card-element {
        padding: 15px;
        border: 2px solid #e0e0e0;
        border-radius: 8px;
        background: white;
    }

    .sidebar-card {
        background: white;
        border-radius: 16px;
        padding: 1.5rem;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    }

    .sidebar-card h4 {
        font-size: 1.1rem;
        margin-bottom: 1rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid #f0f0f0;
    }

    .info-item {
        display: flex;
        gap: 12px;
        padding: 0.75rem 0;
        border-bottom: 1px solid #f0f0f0;
    }

    .info-item:last-child {
        border-bottom: none;
    }

    .info-item i {
        flex-shrink: 0;
        margin-top: 3px;
    }

    #bookingCalendar {
        background: white;
        border-radius: 12px;
        padding: 10px;
        border: 1px solid #e0e0e0;
        min-height: 380px;
    }

    /* FullCalendar Customization */
    .fc .fc-toolbar-title {
        font-size: 1.1rem;
    }

    .fc .fc-button-primary {
        background: var(--primary-color);
        border-color: var(--primary-color);
    }

    .fc .fc-day-today {
        background: rgba(52, 152, 219, 0.1) !important;
    }

    .fc .fc-daygrid-day.fc-day-has-event {
        cursor: pointer;
    }

    @media (max-width: 768px) {
        .booking-steps {
            padding: 0;
        }

        .step-label {
            display: none;
        }

        .category-buttons {
            overflow-x: auto;
            flex-wrap: nowrap;
            padding-bottom: 10px;
        }

        .category-btn {
            white-space: nowrap;
        }
    }
</style>
@endsection

@section('scripts')
<script src="https://js.stripe.com/v3/"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Stripe
    const stripe = Stripe('{{ config("services.stripe.key") }}');
    const elements = stripe.elements();
    const cardElement = elements.create('card', {
        style: {
            base: {
                fontSize: '16px',
                color: '#32325d',
                '::placeholder': { color: '#aab7c4' }
            }
        }
    });
    cardElement.mount('#card-element');

    // Handle card errors
    cardElement.on('change', function(event) {
        const displayError = document.getElementById('card-errors');
        displayError.textContent = event.error ? event.error.message : '';
    });

    // Step Navigation
    const steps = document.querySelectorAll('.booking-step');
    const stepIndicators = document.querySelectorAll('.booking-steps .step');
    let currentStep = 1;

    document.querySelectorAll('.next-step').forEach(btn => {
        btn.addEventListener('click', function() {
            const nextStep = parseInt(this.dataset.next);
            if (validateStep(currentStep)) {
                goToStep(nextStep);
            }
        });
    });

    document.querySelectorAll('.prev-step').forEach(btn => {
        btn.addEventListener('click', function() {
            const prevStep = parseInt(this.dataset.prev);
            goToStep(prevStep);
        });
    });

    function goToStep(step) {
        steps.forEach(s => s.classList.add('d-none'));
        document.getElementById('step' + step).classList.remove('d-none');

        stepIndicators.forEach((indicator, index) => {
            indicator.classList.remove('active', 'completed');
            if (index + 1 < step) indicator.classList.add('completed');
            if (index + 1 === step) indicator.classList.add('active');
        });

        currentStep = step;
        if (step === 4) updateSummary();

        // When showing Date & Time step, FullCalendar needs to recalculate size (it was hidden)
        if (step === 2 && typeof calendar !== 'undefined') {
            setTimeout(function() {
                calendar.updateSize();
            }, 50);
        }
    }

    function validateStep(step) {
        if (step === 1) {
            const serviceSelected = document.querySelector('input[name="service_id"]:checked') || 
                                   document.querySelector('input[name="package_id"]:checked');
            if (!serviceSelected) {
                alert('Please select a service or package');
                return false;
            }
        }
        if (step === 2) {
            if (!document.getElementById('selectedSlotId').value && !document.getElementById('selectedDate').value) {
                alert('Please select a date and time');
                return false;
            }
        }
        if (step === 3) {
            const required = ['first_name', 'last_name', 'email', 'phone'];
            for (let field of required) {
                if (!document.querySelector(`input[name="${field}"]`).value) {
                    alert('Please fill in all required fields');
                    return false;
                }
            }
        }
        return true;
    }

    // Category Filter
    document.querySelectorAll('.category-buttons button').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.category-buttons button').forEach(b => b.classList.remove('active'));
            this.classList.add('active');

            const category = this.dataset.category;
            document.querySelectorAll('.service-option-item').forEach(option => {
                if (category === 'all' || option.dataset.category === category) {
                    option.classList.remove('d-none');
                } else {
                    option.classList.add('d-none');
                }
            });
        });
    });

    // Initialize FullCalendar (must have min-height so it renders when step is hidden)
    const calendarEl = document.getElementById('bookingCalendar');
    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: ''
        },
        selectable: true,
        selectMirror: true,
        validRange: {
            start: new Date()
        },
        height: 'auto',
        contentHeight: 350,
        dateClick: function(info) {
            loadTimeSlots(info.dateStr);
        }
    });
    calendar.render();

    // Instructor Select Listener
    document.getElementById('instructorSelect').addEventListener('change', function() {
        const selectedDate = document.getElementById('selectedDate').value;
        if (selectedDate) {
            loadTimeSlots(selectedDate);
        }
    });

    // Load time slots for selected date
    function loadTimeSlots(date) {
        const locationId = document.getElementById('locationSelect').value;
        const serviceId = document.querySelector('input[name="service_id"]:checked')?.value;
        const instructorId = document.getElementById('instructorSelect').value;

        document.getElementById('selectedDate').value = date;
        document.getElementById('timeSlotsContainer').classList.remove('d-none');
        document.getElementById('timeSlots').innerHTML = '<div class="text-center py-3"><i class="fas fa-spinner fa-spin"></i> Loading...</div>';

        fetch(`{{ url('book-online/slots') }}?date=${date}&location_id=${locationId}&service_id=${serviceId}&instructor_id=${instructorId}`)
            .then(response => response.json())
            .then(data => {
                let html = '';
                if (data.slots && data.slots.length > 0) {
                    data.slots.forEach(slot => {
                        const isAvailable = slot.is_available !== false;
                        const photoHtml = slot.instructor_photo ? `<img src="${slot.instructor_photo}" class="instructor-img" alt="${slot.instructor_name}">` : '';
                        html += `<div class="time-slot ${isAvailable ? '' : 'unavailable'}" 
                                     data-slot-id="${slot.id}" 
                                     data-time="${slot.start_time}"
                                     data-instructor="${slot.instructor_name}"
                                     ${isAvailable ? '' : 'title="Not available"'}>
                                    ${photoHtml}
                                    <div class="slot-time">${slot.start_time}</div>
                                    <div class="instructor-name text-truncate w-100 px-1">${slot.instructor_name}</div>
                                </div>`;
                    });
                } else {
                    html = '<div class="col-12 text-center text-muted py-3">No available slots for this date</div>';
                }
                document.getElementById('timeSlots').innerHTML = html;

                // Add click handlers for time slots
                document.querySelectorAll('.time-slot:not(.unavailable)').forEach(slot => {
                    slot.addEventListener('click', function() {
                        document.querySelectorAll('.time-slot').forEach(s => s.classList.remove('selected'));
                        this.classList.add('selected');
                        document.getElementById('selectedSlotId').value = this.dataset.slotId;
                        document.getElementById('selectedTime').value = this.dataset.time;
                        // Store instructor name directly on the element dataset if needed
                    });
                });
            })
            .catch(error => {
                document.getElementById('timeSlots').innerHTML = '<div class="col-12 text-center text-danger py-3">Error loading slots</div>';
            });
    }

    // Update Summary
    function updateSummary() {
        const serviceEl = document.querySelector('input[name="service_id"]:checked');
        const packageEl = document.querySelector('input[name="package_id"]:checked');
        const locationEl = document.getElementById('locationSelect');
        const instructorEl = document.getElementById('instructorSelect');
        const slotEl = document.querySelector('.time-slot.selected');

        if (serviceEl) {
            document.getElementById('summaryService').textContent = serviceEl.closest('.service-option-item').querySelector('h6').textContent;
            document.getElementById('summaryTotal').textContent = '$' + serviceEl.dataset.price;
        } else if (packageEl) {
            document.getElementById('summaryService').textContent = packageEl.closest('.package-option-item').querySelector('h6').textContent;
            document.getElementById('summaryTotal').textContent = '$' + packageEl.dataset.price;
        }

        document.getElementById('summaryDate').textContent = document.getElementById('selectedDate').value || '-';
        document.getElementById('summaryTime').textContent = document.getElementById('selectedTime').value || '-';
        document.getElementById('summaryLocation').textContent = locationEl.options[locationEl.selectedIndex]?.text || '-';
        document.getElementById('summaryInstructor').textContent = instructorEl.options[instructorEl.selectedIndex]?.text || 'Any Instructor';
        
        if (slotEl && slotEl.dataset.instructor) {
             // If we picked a specific slot with a known instructor, maybe update summary to show THAT instructor instead of "Any"?
             // But for now, let's just show what was selected in dropdown.
             if (instructorEl.value === "") {
                 document.getElementById('summaryInstructor').textContent = slotEl.dataset.instructor;
             }
        }
    }

    // Form Submission with Stripe
    const form = document.getElementById('bookingForm');
    form.addEventListener('submit', async function(e) {
        e.preventDefault();

        const submitBtn = document.getElementById('submitBtn');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Processing...';

        try {
            // Create payment method
            const {error, paymentMethod} = await stripe.createPaymentMethod({
                type: 'card',
                card: cardElement,
            });

            if (error) {
                document.getElementById('card-errors').textContent = error.message;
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fas fa-lock me-2"></i>Pay & Confirm Booking';
                return;
            }

            // Add payment method ID to form
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'payment_method';
            hiddenInput.value = paymentMethod.id;
            form.appendChild(hiddenInput);

            // Submit form
            form.submit();
        } catch (err) {
            document.getElementById('card-errors').textContent = 'An error occurred. Please try again.';
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fas fa-lock me-2"></i>Pay & Confirm Booking';
        }
    });
});
</script>
@endsection
