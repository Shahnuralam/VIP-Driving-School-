@extends('frontend.layouts.app')

@section('title', 'Book Online - VIP Driving School Hobart')

@section('content')
<!-- Page Header -->
<section class="page-header">
    <div class="container" data-aos="fade-up">
        <span class="section-tag" style="color: var(--primary-color);">Reservation</span>
        <h1>Let's book you in...</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('frontend.home') }}">Home</a></li>
                <li class="breadcrumb-item active">Book Online</li>
            </ol>
        </nav>
    </div>
</section>

<!-- Info Section -->
<section class="section-padding bg-light">
    <div class="container">
        <div class="row g-4 mb-5">
            <div class="col-md-4" data-aos="fade-up">
                <div class="info-box text-center h-100">
                    <div class="info-icon mb-3">
                        <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Ctext y='50' font-size='50'%3E🚗%3C/text%3E%3C/svg%3E" alt="PRND" style="width: 80px; height: 80px;">
                    </div>
                    <h5 class="fw-800 mb-3">Auto & Manual Transmission</h5>
                    <p class="text-muted small mb-0">Our Lessons are held in both <strong>Automatic & Manual</strong> Transmission Vehicles.</p>
                    <p class="text-muted small mt-2"><strong>Please ensure you book the correct Lesson Type.</strong></p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                <div class="info-box text-center h-100">
                    <div class="info-icon mb-3">
                        <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Ctext y='50' font-size='50'%3E📍%3C/text%3E%3C/svg%3E" alt="Location" style="width: 80px; height: 80px;">
                    </div>
                    <h5 class="fw-800 mb-3">Servicing Hobart & Kingston</h5>
                    <p class="text-muted small mb-0">We service Hobart and surrounding suburbs as well as Kingston from a designated drop-off & pick-up location.</p>
                    <p class="text-muted small mt-2">For a complete list, please check out our <a href="{{ route('frontend.home') }}" class="text-primary">Home</a> page.</p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                <div class="info-box text-center h-100">
                    <div class="info-icon mb-3">
                        <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Ctext y='50' font-size='50'%3E🪪%3C/text%3E%3C/svg%3E" alt="Licence" style="width: 80px; height: 80px;">
                    </div>
                    <h5 class="fw-800 mb-3">Valid Licence</h5>
                    <p class="text-muted small mb-0">All Students must present a valid licence at the commencement of any lesson or P1 Assessment.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Booking Section -->
<section class="section-padding {{ request()->has('service') ? 'd-none' : '' }}">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="fw-800">Select Service Type</h2>
        </div>

        <!-- Service Type Tabs -->
        <div class="service-tabs-container" data-aos="fade-up">
            @php
                $p1Category = $categories->firstWhere('slug', 'p1-assessments');
                // Get services that belong to P1 category AND have no specific location (location_id is null)
                $p1Services = $p1Category ? $services->where('category_id', $p1Category->id)->whereNull('location_id') : collect();
                
                // Check if a location is specified in the URL
                $selectedLocationId = request()->get('location');
                $selectedLocationServices = !empty($selectedLocationId)
                    ? $services->where('location_id', (int) $selectedLocationId)
                    : collect();
                $hasSelectedLocation = !empty($selectedLocationId) && $selectedLocationServices->count() > 0;
            @endphp
            
            <ul class="nav nav-tabs service-tabs justify-content-center mb-5" id="serviceTypeTabs" role="tablist">
                <!-- P1 Assessments Tab (services with NO location = available at all locations) -->
                @if($p1Services->count() > 0)
                <li class="nav-item" role="presentation">
                    <button class="nav-link {{ !$hasSelectedLocation ? 'active' : '' }}" id="p1-tab" data-bs-toggle="tab" data-bs-target="#p1-content" type="button" role="tab">
                        P1 Assessments
                    </button>
                </li>
                @endif

                <!-- Location-based Tabs (services with specific location) -->
                @foreach($locations as $index => $location)
                    @php
                        // Get services that have THIS specific location
                        $locationServices = $services->where('location_id', $location->id);
                        // Check if this location should be active (compare as strings)
                        $isActiveLocation = $hasSelectedLocation && $selectedLocationId == $location->id;
                        // Or if no P1 services and this is first location and no location selected
                        $isDefaultActive = !$hasSelectedLocation && $p1Services->count() == 0 && $index == 0;
                    @endphp
                    @if($locationServices->count() > 0)
                    <li class="nav-item" role="presentation">
                        <button class="nav-link {{ ($isActiveLocation || $isDefaultActive) ? 'active' : '' }}" 
                                id="location-{{ $location->id }}-tab" 
                                data-bs-toggle="tab" 
                                data-bs-target="#location-{{ $location->id }}-content" 
                                type="button" 
                                role="tab"
                                aria-selected="{{ ($isActiveLocation || $isDefaultActive) ? 'true' : 'false' }}">
                            Lessons - {{ $location->name }}
                        </button>
                    </li>
                    @endif
                @endforeach
            </ul>

            <div class="tab-content" id="serviceTypeTabContent">
                <!-- P1 Assessments Content (services available at ALL locations) -->
                @if($p1Services->count() > 0)
                <div class="tab-pane fade {{ !$hasSelectedLocation ? 'show active' : '' }}" id="p1-content" role="tabpanel" aria-labelledby="p1-tab">
                    <div class="row g-4">
                        @foreach($p1Services as $service)
                        <div class="col-12">
                            <div class="service-booking-card">
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <h4 class="service-title text-danger mb-2">{{ $service->name }}</h4>
                                        <p class="service-desc text-muted mb-3">{{ $service->description }}</p>
                                        <div class="service-meta">
                                            <span class="badge bg-success text-white me-2">
                                                <i class="fas fa-map-marker-alt me-1"></i>All Locations
                                            </span>
                                            @if($service->duration_minutes)
                                            <span class="badge bg-light text-dark">
                                                <i class="fas fa-clock me-1"></i>{{ $service->duration_minutes }} mins
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4 text-md-end">
                                        <div class="service-price mb-3">
                                            <span class="price-amount">${{ number_format($service->price, 0) }}</span>
                                            @if($service->duration_minutes)
                                            <span class="price-duration text-muted d-block">{{ $service->duration_minutes }} minutes</span>
                                            @endif
                                        </div>
                                        <a href="{{ route('book-online') }}?service={{ $service->id }}" class="btn btn-dark btn-book-now">
                                            Book Now
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Location-based Content (services for specific locations) -->
                @foreach($locations as $index => $location)
                    @php
                        $locationServices = $services->where('location_id', $location->id);
                        $isActiveLocation = $hasSelectedLocation && $selectedLocationId == $location->id;
                        $isDefaultActive = !$hasSelectedLocation && $p1Services->count() == 0 && $index == 0;
                    @endphp
                    @if($locationServices->count() > 0)
                    <div class="tab-pane fade {{ ($isActiveLocation || $isDefaultActive) ? 'show active' : '' }}" 
                         id="location-{{ $location->id }}-content" 
                         role="tabpanel"
                         aria-labelledby="location-{{ $location->id }}-tab">
                        <div class="row g-4">
                            @foreach($locationServices as $service)
                            <div class="col-12">
                                <div class="service-booking-card">
                                    <div class="row align-items-center">
                                        <div class="col-md-8">
                                            <h4 class="service-title text-danger mb-2">{{ $service->name }}</h4>
                                            <p class="service-desc text-muted mb-3">{{ $service->description }}</p>
                                            <div class="service-meta">
                                                <span class="badge bg-success text-white me-2">
                                                    <i class="fas fa-map-marker-alt me-1"></i>{{ $location->name }}
                                                </span>
                                                @if($service->duration_minutes)
                                                <span class="badge bg-light text-dark">
                                                    <i class="fas fa-clock me-1"></i>{{ $service->duration_minutes }} mins
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-4 text-md-end">
                                            <div class="service-price mb-3">
                                                <span class="price-amount">${{ number_format($service->price, 0) }}</span>
                                            </div>
                                            <a href="{{ route('book-online') }}?service={{ $service->id }}" class="btn btn-dark btn-book-now">
                                                Book Now
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                @endforeach
            </div>
        </div>

        <div class="text-center mt-5" data-aos="fade-up">
            <p class="lead text-muted mb-4">Our <strong>online booking tool</strong> allows you to select, <strong>schedule and securely pay for single Lessons & P1 Assessments up to 3 months in advance</strong> with confirmation provided immediately over email. 50 Minute Lessons can also be purchased in <strong>Lesson Packages</strong> which you can schedule yourself below.</p>
            <p class="text-muted">If you're booking your P1 Assessment, please read the <a href="{{ route('p1-assessments') }}" class="text-primary fw-bold">P1 Assessments</a> page prior to making your booking to ensure you are familiar with what is required of you and what to expect.</p>
        </div>

        <div class="text-center mt-4" data-aos="fade-up">
            <p class="text-muted small">Please also take the time to read our <a href="#" class="text-primary">Terms & Conditions</a>, <a href="#" class="text-primary">Privacy Policy</a> & <a href="#" class="text-primary">Privacy Collection Statement</a></p>
        </div>
    </div>
</section>

<!-- Original Booking Form (Hidden by default, shown when Book Now is clicked) -->
<section class="section-padding {{ request()->has('service') ? '' : 'd-none' }}" id="bookingFormSection">
    <div class="container">
        <div class="row g-5">
            <!-- Booking Form -->
            <div class="col-lg-8">
                <div class="booking-form-card" data-aos="fade-up">
                    <h3 class="fw-800 mb-4">Schedule Your Lesson</h3>
                    
                    @if($errors->any())
                        <div class="alert alert-danger mb-4">
                            <ul class="mb-0 ps-3">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

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

                            <!-- Hidden fields for location and instructor (will be set from selected slot) -->
                            <input type="hidden" name="location_id" id="locationSelect">
                            <input type="hidden" name="instructor_id" id="instructorSelect">
                            <input type="hidden" id="locationName">
                            <input type="hidden" id="instructorName">

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
                                @if(!auth('customer')->check())
                                <div class="col-12">
                                    <div class="account-option-card">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="create_account" id="createAccountCheck" value="1" {{ old('create_account') ? 'checked' : '' }}>
                                            <label class="form-check-label fw-semibold" for="createAccountCheck">
                                                Create my customer account after payment
                                            </label>
                                        </div>
                                        <p class="text-muted small mb-0">
                                            Save your booking history, manage upcoming lessons, and access your customer dashboard anytime.
                                        </p>

                                        <div id="accountPasswordFields" class="row g-3 mt-1 d-none">
                                            <div class="col-md-6">
                                                <label class="form-label">Account Password *</label>
                                                <input type="password" name="account_password" class="form-control" autocomplete="new-password" minlength="8">
                                                <small class="text-muted">Minimum 8 characters</small>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Confirm Password *</label>
                                                <input type="password" name="account_password_confirmation" class="form-control" autocomplete="new-password" minlength="8">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @else
                                <div class="col-12">
                                    <div class="account-option-card account-option-card--active">
                                        <i class="fas fa-user-check text-success me-2"></i>
                                        You are logged in. This booking will be saved to your customer dashboard.
                                    </div>
                                </div>
                                @endif
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

<!-- Booking Notice Modal -->
<div class="modal fade" id="bookingNoticeModal" tabindex="-1" aria-labelledby="bookingNoticeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bookingNoticeModalLabel">Action Required</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p id="bookingNoticeModalMessage" class="mb-0"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-book" data-bs-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .section-padding {
        padding: 10px 0;
    }

    /* Info Boxes */
    .info-box {
        background: white;
        border-radius: 16px;
        padding: 0.5rem 1rem;
        border: 1px solid var(--slate-100);
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
    }

    .info-box:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.12);
    }

    /* Service Tabs */
    .service-tabs-container {
        background: white;
        border-radius: 20px;
        padding: 1rem 1rem;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
    }

    .service-tabs {
        border-bottom: none;
        flex-wrap: wrap;
        gap: 0.5rem;
        justify-content: center;
    }

    .service-tabs .nav-item {
        margin-bottom: 1rem;
    }

    .service-tabs .nav-link {
        border: 2px solid #e2e8f0;
        border-radius: 8px;
        color: #475569 !important;
        font-weight: 600;
        padding: 0.875rem 2rem;
        transition: all 0.3s ease;
        font-size: 0.95rem;
        background: white !important;
        position: relative;
    }

    .service-tabs .nav-link:hover {
        color: #1e293b !important;
        border-color: #cbd5e1;
        background: #f8fafc !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }

    .service-tabs .nav-link.active {
        color: white !important;
        border-color: var(--primary-color);
        background: var(--primary-color) !important;
        font-weight: 700;
        box-shadow: 0 4px 15px rgba(255, 107, 0, 0.3);
    }

    /* Force text visibility */
    .service-tabs button {
        color: #475569 !important;
    }

    .service-tabs button.active {
        color: white !important;
    }

    /* Service Booking Cards */
    .service-booking-card {
        background: white;
        border: 2px solid var(--slate-100);
        border-radius: 16px;
        padding: 1rem;
        transition: all 0.3s ease;
    }

    .service-booking-card:hover {
        border-color: var(--primary-color);
        box-shadow: 0 10px 25px rgba(255, 107, 0, 0.15);
        transform: translateY(-3px);
    }

    .service-title {
        font-weight: 800;
        color: var(--secondary-color);
        font-size: 1.3rem;
    }

    .service-desc {
        font-size: 0.95rem;
        line-height: 1.6;
    }

    .service-meta .badge {
        font-size: 0.85rem;
        padding: 0.5rem 0.75rem;
        font-weight: 600;
    }

    .service-price {
        text-align: right;
    }

    .price-amount {
        font-size: 2.5rem;
        font-weight: 800;
        color: var(--primary-color);
        display: block;
        line-height: 1;
    }

    .price-duration {
        font-size: 0.9rem;
        margin-top: 0.25rem;
    }

    .btn-book-now {
        padding: 0.75rem 2rem;
        font-weight: 700;
        border-radius: 12px;
        transition: all 0.3s ease;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-size: 0.9rem;
    }

    .btn-book-now:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
    }

    @media (max-width: 768px) {
        .service-tabs .nav-link {
            font-size: 0.85rem;
            padding: 0.75rem 1rem;
        }

        .service-booking-card {
            padding: 1.5rem;
        }

        .service-title {
            font-size: 1.1rem;
        }

        .price-amount {
            font-size: 2rem;
        }

        .service-price {
            text-align: left;
            margin-top: 1rem;
        }
    }

    .booking-form-card {
        background: white;
        border-radius: 20px;
        padding: 3rem;
        border: 1px solid var(--slate-200);
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    }

    .account-option-card {
        background: var(--slate-50);
        border: 1px solid var(--slate-200);
        border-radius: 14px;
        padding: 1rem 1.1rem;
    }

    .account-option-card--active {
        border-color: #16a34a33;
        background: #f0fdf4;
        color: #166534;
        font-weight: 600;
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

    .time-slots-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 1rem;
    }

    .time-slot {
        background: white;
        border: 2px solid var(--slate-200);
        border-radius: 12px;
        padding: 1rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .time-slot:hover:not(.unavailable) {
        border-color: var(--primary-color);
        background: rgba(255, 107, 0, 0.05);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .time-slot.selected {
        background: var(--primary-color);
        border-color: var(--primary-color);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(255, 107, 0, 0.3);
    }

    .time-slot.selected .instructor-name {
        color: white;
        opacity: 0.9;
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
        background: var(--secondary-color);
        border-color: var(--secondary-color);
    }

    .fc .fc-button-primary:hover {
        background: #1e293b;
        border-color: #1e293b;
    }

    .fc .fc-day-today {
        background: rgba(30, 41, 59, 0.08) !important;
    }

    .fc .fc-daygrid-day:hover {
        background: rgba(30, 41, 59, 0.05);
        cursor: pointer;
    }

    .fc .fc-daygrid-day.fc-day-has-event {
        cursor: pointer;
    }

    /* Calendar header styling */
    .fc .fc-toolbar-title {
        color: var(--secondary-color);
        font-weight: 700;
    }

    .fc .fc-daygrid-day-frame {
        min-height: 82px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Calendar day numbers */
    .fc .fc-daygrid-day-number {
        color: var(--secondary-color);
        font-weight: 600;
        float: none;
        margin: 0;
        padding: 0;
        text-align: center;
    }

    .fc .fc-daygrid-day-top {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Calendar day header (Sun, Mon, etc) */
    .fc .fc-col-header-cell-cushion {
        color: var(--secondary-color);
        font-weight: 700;
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
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>
<script src="https://js.stripe.com/v3/"></script>
<script>
window.addEventListener('pageshow', function(event) {
    // If the page is restored from browser back/forward cache, force fresh CSRF/session state.
    if (event.persisted) {
        window.location.reload();
    }
});

document.addEventListener('DOMContentLoaded', function() {
    // Check if service is pre-selected from URL
    const urlParams = new URLSearchParams(window.location.search);
    const preSelectedService = urlParams.get('service');
    const sessionPingUrl = '{{ route('session.ping') }}';
    const csrfMeta = document.querySelector('meta[name="csrf-token"]');
    const createAccountCheck = document.getElementById('createAccountCheck');
    const accountPasswordFields = document.getElementById('accountPasswordFields');
    const bookingNoticeModalEl = document.getElementById('bookingNoticeModal');
    const bookingNoticeTitleEl = document.getElementById('bookingNoticeModalLabel');
    const bookingNoticeMessageEl = document.getElementById('bookingNoticeModalMessage');

    function showBookingNotice(message, title = 'Action Required') {
        if (!bookingNoticeModalEl || !bookingNoticeTitleEl || !bookingNoticeMessageEl || typeof bootstrap === 'undefined') {
            // Fallback only if modal/bootstrap is not available.
            alert(message);
            return;
        }
        bookingNoticeTitleEl.textContent = title;
        bookingNoticeMessageEl.textContent = message;
        const modal = bootstrap.Modal.getOrCreateInstance(bookingNoticeModalEl);
        modal.show();
    }

    function toggleAccountPasswordFields() {
        if (!createAccountCheck || !accountPasswordFields) {
            return;
        }
        if (createAccountCheck.checked) {
            accountPasswordFields.classList.remove('d-none');
        } else {
            accountPasswordFields.classList.add('d-none');
        }
    }

    function scrollToTimeSlots() {
        const timeSlotsContainer = document.getElementById('timeSlotsContainer');
        if (!timeSlotsContainer) {
            return;
        }

        const y = timeSlotsContainer.getBoundingClientRect().top + window.pageYOffset - 110;
        window.scrollTo({
            top: Math.max(y, 0),
            behavior: 'smooth'
        });
    }

    if (createAccountCheck && accountPasswordFields) {
        toggleAccountPasswordFields();
        createAccountCheck.addEventListener('change', toggleAccountPasswordFields);
    }
    
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
    
    // If service is pre-selected, auto-advance to step 2
    if (preSelectedService) {
        setTimeout(function() {
            goToStep(2);
        }, 300);
    }

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
                showBookingNotice('Please select a service or package.');
                return false;
            }
        }
        if (step === 2) {
            if (!document.getElementById('selectedSlotId').value) {
                showBookingNotice('Please select an available time slot.');
                return false;
            }
        }
        if (step === 3) {
            const required = ['first_name', 'last_name', 'email', 'phone'];
            for (let field of required) {
                if (!document.querySelector(`input[name="${field}"]`).value) {
                    showBookingNotice('Please fill in all required fields.');
                    return false;
                }
            }

            if (createAccountCheck && createAccountCheck.checked) {
                const passwordInput = document.querySelector('input[name="account_password"]');
                const passwordConfirmInput = document.querySelector('input[name="account_password_confirmation"]');

                if (!passwordInput.value || passwordInput.value.length < 8) {
                    showBookingNotice('Please enter an account password with at least 8 characters.');
                    passwordInput.focus();
                    return false;
                }

                if (passwordInput.value !== passwordConfirmInput.value) {
                    showBookingNotice('Password confirmation does not match.');
                    passwordConfirmInput.focus();
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

    // Load time slots for selected date
    function loadTimeSlots(date) {
        const serviceId = document.querySelector('input[name="service_id"]:checked')?.value;

        console.log('Loading slots for:', { date, serviceId });

        if (!serviceId) {
            showBookingNotice('Please select a service first.');
            return;
        }

        // Reset previous selection before loading slots for a new date.
        document.getElementById('selectedSlotId').value = '';
        document.getElementById('selectedTime').value = '';

        document.getElementById('selectedDate').value = date;
        document.getElementById('timeSlotsContainer').classList.remove('d-none');
        document.getElementById('timeSlots').innerHTML = '<div class="text-center py-3"><i class="fas fa-spinner fa-spin"></i> Loading...</div>';
        scrollToTimeSlots();

        const url = `{{ url('book-online/slots') }}?date=${date}&service_id=${serviceId}`;
        console.log('Fetching from:', url);

        fetch(url)
            .then(response => {
                console.log('Response status:', response.status);
                return response.json();
            })
            .then(data => {
                console.log('Received data:', data);
                let html = '';
                if (data.slots && data.slots.length > 0) {
                    data.slots.forEach(slot => {
                        const isAvailable = slot.is_available !== false;
                        html += `<div class="time-slot ${isAvailable ? '' : 'unavailable'}" 
                                     data-slot-id="${slot.id}" 
                                     data-time="${slot.start_time}"
                                     data-instructor="${slot.instructor_name}"
                                     data-location="${slot.location_name}"
                                     data-location-id="${slot.location_id || ''}"
                                     data-instructor-id="${slot.instructor_id || ''}"
                                     ${isAvailable ? '' : 'title="Not available"'}>
                                    <div class="slot-time fw-bold">${slot.start_time}</div>
                                    <div class="instructor-name text-muted small">${slot.instructor_name}</div>
                                </div>`;
                    });
                } else {
                    html = '<div class="col-12 text-center text-muted py-3">No available slots for this date</div>';
                }
                document.getElementById('timeSlots').innerHTML = html;

                // Add click handlers for time slots
                const availableSlotEls = Array.from(document.querySelectorAll('.time-slot:not(.unavailable)'));
                availableSlotEls.forEach(slot => {
                    slot.addEventListener('click', function() {
                        document.querySelectorAll('.time-slot').forEach(s => s.classList.remove('selected'));
                        this.classList.add('selected');
                        document.getElementById('selectedSlotId').value = this.dataset.slotId;
                        document.getElementById('selectedTime').value = this.dataset.time;
                        
                        // Auto-fill location and instructor IDs and names from the selected slot
                        if (this.dataset.locationId) {
                            document.getElementById('locationSelect').value = this.dataset.locationId;
                            document.getElementById('locationName').value = this.dataset.location;
                        }
                        if (this.dataset.instructorId) {
                            document.getElementById('instructorSelect').value = this.dataset.instructorId;
                            document.getElementById('instructorName').value = this.dataset.instructor;
                        }
                    });
                });

                // If only one slot is available, auto-select it.
                if (availableSlotEls.length === 1) {
                    availableSlotEls[0].click();
                }
            })
            .catch(error => {
                console.error('Error loading slots:', error);
                document.getElementById('timeSlots').innerHTML = '<div class="col-12 text-center text-danger py-3">Error loading slots. Please try again.</div>';
            });
    }

    // Update Summary
    function updateSummary() {
        const serviceEl = document.querySelector('input[name="service_id"]:checked');
        const packageEl = document.querySelector('input[name="package_id"]:checked');
        const locationName = document.getElementById('locationName').value;
        const instructorName = document.getElementById('instructorName').value;

        if (serviceEl) {
            document.getElementById('summaryService').textContent = serviceEl.closest('.service-option-item').querySelector('h6').textContent;
            document.getElementById('summaryTotal').textContent = '$' + serviceEl.dataset.price;
        } else if (packageEl) {
            document.getElementById('summaryService').textContent = packageEl.closest('.package-option-item').querySelector('h6').textContent;
            document.getElementById('summaryTotal').textContent = '$' + packageEl.dataset.price;
        }

        document.getElementById('summaryDate').textContent = document.getElementById('selectedDate').value || '-';
        document.getElementById('summaryTime').textContent = document.getElementById('selectedTime').value || '-';
        document.getElementById('summaryLocation').textContent = locationName || '-';
        document.getElementById('summaryInstructor').textContent = instructorName || '-';
    }

    // Form Submission with Stripe
    const form = document.getElementById('bookingForm');
    const csrfInput = form.querySelector('input[name="_token"]');

    async function keepSessionAlive() {
        try {
            await fetch(sessionPingUrl, {
                method: 'GET',
                credentials: 'same-origin',
                cache: 'no-store',
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });
        } catch (e) {
            // Silent fail: submit flow still proceeds, this is best-effort.
        }
    }

    // Keep session active while user is completing long multi-step booking/payment.
    setInterval(keepSessionAlive, 5 * 60 * 1000);

    form.addEventListener('submit', async function(e) {
        e.preventDefault();

        if (csrfInput && csrfMeta) {
            csrfInput.value = csrfMeta.getAttribute('content');
        }

        await keepSessionAlive();

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
