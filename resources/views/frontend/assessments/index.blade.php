@extends('frontend.layouts.app')

@section('title', 'P1 Assessments - VIP Driving School Hobart')

@section('content')
<!-- Page Header -->
<section class="page-header">
    <div class="container" data-aos="fade-up">
        <span class="section-tag" style="color: var(--primary-color);">Licensing</span>
        <h1>P1 Assessments</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('frontend.home') }}">Home</a></li>
                <li class="breadcrumb-item active">P1 Assessments</li>
            </ol>
        </nav>
    </div>
</section>

<!-- Assessment Info Section -->
<section class="section-padding">
    <div class="container">
        <div class="row g-5">
            <!-- Main Content -->
            <div class="col-lg-8">
                <div class="mb-5" data-aos="fade-up">
                    <span class="section-tag">Information</span>
                    <h2 class="fw-800 mb-4">About P1 Driver Assessments</h2>
                    <p class="text-muted">You can book online within our Bookings Calendar once you register your account during the Check-out process.</p>
                    <p class="text-muted"><strong>Please note:</strong> VIP Driving School separates our Instructors and Assessors, allowing you to book a P Assessment and have lessons with us which provides you a seamless experience throughout your journey to obtain your licence. If you have had a lesson within 6 months, you may not use the same Instructor/Assessor to conduct your P1 Assessment.</p>
                </div>

                <!-- Assessment Locations -->
                <div class="mb-5" data-aos="fade-up">
                    <h4 class="fw-800 mb-4 d-flex align-items-center gap-2">
                        <i class="fas fa-map-marker-alt text-primary"></i> Assessment Locations
                    </h4>
                    <div class="row g-4">
                        @forelse($locations as $location)
                        <div class="col-md-6">
                            <div class="location-card h-100 border">
                                @if($location->image)
                                <div class="location-image">
                                    <img src="{{ Storage::url($location->image) }}" alt="{{ $location->name }}" class="w-100">
                                </div>
                                @endif
                                <div class="p-4">
                                    <h5 class="fw-800 mb-3">{{ $location->name }}</h5>
                                    <div class="d-flex align-items-start gap-2 mb-3 text-muted small">
                                        <i class="fas fa-map-pin mt-1 text-primary"></i>
                                        <span>{{ $location->address }}</span>
                                    </div>
                                    @if($location->available_days_text)
                                    <div class="d-flex align-items-center gap-2 mb-3 text-muted small">
                                        <i class="fas fa-calendar-alt text-primary"></i>
                                        <span>{{ $location->available_days_text }}</span>
                                    </div>
                                    @endif
                                    <a href="{{ route('book-online') }}?location={{ $location->id }}" class="btn btn-book w-100">
                                        <i class="fas fa-calendar-check me-2"></i>Book Now
                                    </a>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-12">
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>Assessment locations will be updated soon.
                            </div>
                        </div>
                        @endforelse
                    </div>
                </div>

                <!-- Assessment Services (Hidden) -->
                @if(false && $assessmentServices->count() > 0)
                <div class="mb-5" data-aos="fade-up" style="display: none;">
                    <h3 class="mb-4"><i class="fas fa-clipboard-check text-primary me-2"></i>Assessment Services</h3>
                    <div class="row g-4">
                        @foreach($assessmentServices as $service)
                        <div class="col-md-6">
                            <div class="service-card h-100">
                                <div class="p-4">
                                    <h5>{{ $service->name }}</h5>
                                    <div class="price-tag mb-3">
                                        <span class="fs-3 fw-bold text-primary">${{ number_format($service->price, 0) }}</span>
                                        @if($service->duration_minutes)
                                        <span class="text-muted">/ {{ $service->duration_minutes }} mins</span>
                                        @endif
                                    </div>
                                    @if($service->description)
                                    <p class="text-muted">{{ $service->description }}</p>
                                    @endif
                                    <a href="{{ route('book-online', ['service' => $service->id]) }}" class="btn btn-book w-100">
                                        <i class="fas fa-calendar-check me-2"></i>Book Assessment
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Things to Know -->
                <div class="sidebar-card mb-4" data-aos="fade-left">
                    <h4><i class="fas fa-lightbulb text-warning me-2"></i>Things to Know</h4>
                    
                    <div class="info-section mb-4">
                        <h6 class="info-heading">Hazard Perception Test</h6>
                        <p class="info-text">You must complete your Hazard Perception Test prior to booking. We cannot register your P1 Assessment with State Growth without this.</p>
                        <a href="https://www.platesplus.tas.gov.au/plates-plus/hpt" target="_blank" class="info-link">
                            <i class="fas fa-external-link-alt me-1"></i>Take the test here
                        </a>
                    </div>

                    <div class="info-section mb-4">
                        <h6 class="info-heading">Log Book Requirements</h6>
                        <p class="info-text">You must have the required learner hours recorded in your Log Book or Plates Plus Logbook App. Failure to meet this requirement will result in forfeiture of your Assessment and payment.</p>
                    </div>

                    <div class="info-section mb-4">
                        <h6 class="info-heading">Assessment Date</h6>
                        <p class="info-text">Check your Drivers Licence for the Earliest Assessment Date. Booking before this date may result in cancellation fees.</p>
                    </div>

                    <div class="info-section mb-4">
                        <h6 class="info-heading">Booking Policy</h6>
                        <p class="info-text">Please only book one Assessment at a time. Cancelling multiple bookings will incur the full cancellation fee.</p>
                    </div>

                    <div class="info-section mb-4">
                        <h6 class="info-heading">Vehicle Requirements</h6>
                        <p class="info-text">If using your own vehicle, it must meet Tasmania Government guidelines. Our Assessors will inspect it before the Assessment.</p>
                        <p class="info-text mt-2"><strong>Note:</strong> Our Assessment vehicles are AUTOMATIC only. Manual Assessments require your own vehicle.</p>
                    </div>
                </div>

                <!-- Things to Bring -->
                <div class="sidebar-card mb-4" data-aos="fade-left" data-aos-delay="100">
                    <h4><i class="fas fa-clipboard-list text-primary me-2"></i>Things to Bring</h4>
                    <ul class="checklist">
                        <li>
                            <i class="fas fa-check-circle"></i>
                            <span>Current Drivers Licence</span>
                        </li>
                        <li>
                            <i class="fas fa-check-circle"></i>
                            <span>Completed Log Book or Plates Plus App</span>
                        </li>
                        <li>
                            <i class="fas fa-check-circle"></i>
                            <span>Signed In-Car Camera Consent Form</span>
                        </li>
                        <li>
                            <i class="fas fa-check-circle"></i>
                            <span>Exemption Form (if applicable)</span>
                        </li>
                        <li>
                            <i class="fas fa-check-circle"></i>
                            <span>Medical Forms (if applicable)</span>
                        </li>
                    </ul>
                    <a href="#" class="download-link mt-3 d-inline-block">
                        <i class="fas fa-download me-2"></i>Download Consent Form
                    </a>
                </div>

                <!-- Downloadable Documents -->
                @if(isset($documents) && $documents->count() > 0)
                <div class="sidebar-card" data-aos="fade-left" data-aos-delay="200">
                    <h4><i class="fas fa-file-download text-info me-2"></i>Helpful Documents</h4>
                    <ul class="document-list">
                        @foreach($documents as $document)
                        <li>
                            <a href="{{ Storage::url($document->file_path) }}" target="_blank" class="document-link">
                                <i class="fas fa-file-pdf text-danger"></i>
                                <span>{{ $document->title }}</span>
                                <i class="fas fa-download"></i>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>

<!-- Assessment Process -->
<section class="section-padding bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title" data-aos="fade-up">The Assessment Process</h2>
            <p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">What to expect during your P1 assessment</p>
        </div>
        <div class="row g-4">
            <div class="col-md-6 col-lg-3" data-aos="fade-up">
                <div class="process-step">
                    <div class="step-number">1</div>
                    <h5>Check-In</h5>
                    <p class="text-muted small">Arrive 15 minutes early, present your licence and complete paperwork</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="100">
                <div class="process-step">
                    <div class="step-number">2</div>
                    <h5>Vehicle Check</h5>
                    <p class="text-muted small">Brief familiarisation with the vehicle controls and safety features</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="200">
                <div class="process-step">
                    <div class="step-number">3</div>
                    <h5>Driving Assessment</h5>
                    <p class="text-muted small">Demonstrate your driving skills in various road and traffic conditions</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="300">
                <div class="process-step">
                    <div class="step-number">4</div>
                    <h5>Results & Feedback</h5>
                    <p class="text-muted small">Receive immediate results and constructive feedback on your driving</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="section-padding" style="background: linear-gradient(135deg, var(--primary-color) 0%, #2d5a8c 100%);">
    <div class="container text-center text-white">
        <h2 class="mb-3" data-aos="fade-up">Ready for Your P1 Assessment?</h2>
        <p class="lead mb-4 opacity-75" data-aos="fade-up" data-aos-delay="100">Book your assessment today and take the next step towards your P1 licence</p>
        <a href="{{ route('book-online') }}" class="btn btn-book btn-lg" data-aos="fade-up" data-aos-delay="200">
            <i class="fas fa-calendar-check me-2"></i>Book Your Assessment
        </a>
    </div>
</section>
@endsection

@section('styles')
<style>
    .sidebar-card {
        background: white;
        border-radius: 16px;
        padding: 2rem;
        border: 1px solid var(--slate-100);
        box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
    }

    .sidebar-card h4 {
        font-size: 1.2rem;
        font-weight: 800;
        margin-bottom: 1.5rem;
        color: var(--secondary-color);
    }

    .info-section {
        padding-bottom: 1rem;
        border-bottom: 1px solid var(--slate-100);
    }

    .info-section:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .info-heading {
        font-size: 0.95rem;
        font-weight: 700;
        color: var(--secondary-color);
        margin-bottom: 0.5rem;
    }

    .info-text {
        font-size: 0.875rem;
        color: var(--slate-600);
        line-height: 1.6;
        margin-bottom: 0;
    }

    .info-link {
        display: inline-block;
        font-size: 0.875rem;
        color: var(--primary-color);
        text-decoration: none;
        font-weight: 600;
        margin-top: 0.5rem;
        transition: all 0.3s ease;
    }

    .info-link:hover {
        color: #d65a00;
        transform: translateX(3px);
    }

    .checklist {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .checklist li {
        display: flex;
        align-items: start;
        gap: 0.75rem;
        padding: 0.75rem 0;
        border-bottom: 1px solid var(--slate-50);
        font-size: 0.9rem;
        color: var(--slate-700);
    }

    .checklist li:last-child {
        border-bottom: none;
    }

    .checklist li i {
        color: var(--primary-color);
        font-size: 1.1rem;
        margin-top: 2px;
        flex-shrink: 0;
    }

    .download-link {
        font-size: 0.875rem;
        color: var(--primary-color);
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .download-link:hover {
        color: #d65a00;
        transform: translateX(3px);
    }

    .info-list li {
        padding: 1rem 0;
        border-bottom: 1px solid var(--slate-50);
        font-size: 0.95rem;
        color: var(--slate-600);
    }

    .process-step {
        text-align: center;
        padding: 3rem 2rem;
        background: white;
        border-radius: 20px;
        border: 1px solid var(--slate-100);
        box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
        height: 100%;
        transition: transform 0.3s ease;
    }

    .process-step:hover {
        transform: translateY(-5px);
        border-color: var(--primary-color);
    }

    .step-number {
        width: 60px;
        height: 60px;
        background: var(--secondary-color);
        color: var(--primary-color);
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        font-weight: 800;
        margin: 0 auto 1.5rem;
    }

    .location-card {
        background: white;
        border-radius: 16px;
        transition: all 0.3s ease;
        overflow: hidden;
    }

    .location-card:hover {
        border-color: var(--primary-color) !important;
        box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1);
    }

    .location-image {
        width: 100%;
        height: 200px;
        overflow: hidden;
        background: var(--slate-100);
    }

    .location-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .location-card:hover .location-image img {
        transform: scale(1.05);
    }

    .location-card .btn-book {
        transition: all 0.3s ease;
    }

    .location-card .btn-book:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(255, 107, 0, 0.3);
    }

    .info-list li a {
        word-break: break-all;
    }
</style>
@endsection
