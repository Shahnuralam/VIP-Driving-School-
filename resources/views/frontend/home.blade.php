@extends('frontend.layouts.app')

@section('title', 'VIP Driving School Hobart')

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10" data-aos="fade-up">
                <span class="section-tag mb-3" style="color: var(--primary-color);">Hobart's Trusted Driving School</span>
                <h1 class="hero-title">Developing <span>Safe & Competent</span> Drivers</h1>
                <p class="hero-subtitle">Expert instruction for learners, nervous drivers, and P1 assessments. Let the experts guide you to confidence on the road.</p>
                <div class="d-flex gap-3 justify-content-center flex-wrap">
                    <a href="{{ route('book-online') }}" class="btn btn-book">
                        Book a Lesson
                    </a>
                    <a href="{{ route('lesson-packages') }}" class="btn btn-outline-light">
                        View Packages
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Stats Bar -->
<div class="bg-white py-5 border-bottom">
    <div class="container">
        <div class="row g-4 text-center">
            <div class="col-md-4" data-aos="fade-up">
                <div class="px-4">
                    <div class="text-primary mb-2"><i class="fas fa-user-check fa-2x"></i></div>
                    <h5 class="fw-800 mb-1">Certified Instructors</h5>
                    <p class="text-muted small mb-0">Accredited by the Tasmanian Government</p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                <div class="px-4">
                    <div class="text-primary mb-2"><i class="fas fa-heart fa-2x"></i></div>
                    <h5 class="fw-800 mb-1">Nervous Driver Specialists</h5>
                    <p class="text-muted small mb-0">Patient, supportive approach for anxious learners</p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                <div class="px-4">
                    <div class="text-primary mb-2"><i class="fas fa-star fa-2x"></i></div>
                    <h5 class="fw-800 mb-1">5/5 Customer Rating</h5>
                    <p class="text-muted small mb-0">Consistently rated 5 stars on Facebook</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Why Choose Us -->
<section class="section-padding bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title" data-aos="fade-up">Why Choose VIP Driving School?</h2>
            <p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">We're committed to helping you become a safe and confident driver</p>
        </div>
        <div class="row g-4">
            @forelse($infoCards as $card)
            <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                <div class="info-card h-100">
                    <i class="{{ $card->icon ?? 'fas fa-star' }}"></i>
                    <h5>{{ $card->title }}</h5>
                    <p class="text-muted mb-0">{{ $card->content }}</p>
                </div>
            </div>
            @empty
            <div class="col-md-6 col-lg-3" data-aos="fade-up">
                <div class="info-card h-100">
                    <i class="fas fa-car"></i>
                    <h5>Auto & Manual</h5>
                    <p class="text-muted mb-0">Choose between automatic or manual transmission vehicles</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="100">
                <div class="info-card h-100">
                    <i class="fas fa-id-card"></i>
                    <h5>Valid Licence Required</h5>
                    <p class="text-muted mb-0">You must hold a valid learner's licence to book lessons</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="200">
                <div class="info-card h-100">
                    <i class="fas fa-user-graduate"></i>
                    <h5>Experienced Instructors</h5>
                    <p class="text-muted mb-0">All our instructors are fully qualified and accredited</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="300">
                <div class="info-card h-100">
                    <i class="fas fa-shield-alt"></i>
                    <h5>Dual Control Vehicles</h5>
                    <p class="text-muted mb-0">Learn in safe, dual-control vehicles for your peace of mind</p>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Services Section -->
<section class="section-padding bg-slate-50">
    <div class="container">
        <div class="text-center mb-5">
            <span class="section-tag" data-aos="fade-up">Our Services</span>
            <h2 class="section-title" data-aos="fade-up" data-aos-delay="100">Choose Your Path</h2>
            <p class="section-subtitle" data-aos="fade-up" data-aos-delay="200">Comprehensive driving education tailored to your needs.</p>
        </div>
        <div class="row g-4 justify-content-center">
            @foreach($categories as $category)
            @php
                $isFeatured = str_contains(strtolower($category->name), 'package');
            @endphp
            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                <div class="service-card {{ $isFeatured ? 'dark featured' : '' }}">
                    @if($isFeatured)
                        <span class="featured-badge">Most Popular</span>
                    @endif
                    <div class="p-5">
                        <div class="mb-4">
                            <i class="{{ $category->icon ?? ($isFeatured ? 'fas fa-box-open' : 'fas fa-car') }} fa-2x text-primary p-3 rounded-3" style="background: rgba(245, 158, 11, 0.1);"></i>
                        </div>
                        <h3 class="fw-800 mb-3 h4">{{ $category->name }}</h3>
                        
                        @if($isFeatured)
                            <div class="mb-3">
                                <span class="text-primary fw-bold">From $235</span>
                            </div>
                        @else
                            <div class="mb-3">
                                <span class="fw-bold" style="color: var(--primary-color);">$80</span>
                            </div>
                        @endif

                        <p class="text-muted mb-4" style="font-size: 0.95rem;">{{ $category->description ?? 'Professional ' . strtolower($category->name) . ' services to help you succeed.' }}</p>
                        
                        <a href="{{ route('book-online') }}" class="btn {{ $isFeatured ? 'btn-primary w-100' : 'btn-link p-0 text-decoration-none fw-bold' }}" style="{{ !$isFeatured ? 'color: var(--secondary-color);' : '' }}">
                            {{ $isFeatured ? 'View Packages' : 'Book Now' }} 
                            <i class="fas fa-arrow-right ms-2 small"></i>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Why Choose Us -->
<section class="section-padding">
    <div class="container">
        <div class="row g-5 align-items-center">
            <div class="col-lg-6" data-aos="fade-right">
                <span class="section-tag">Why Us</span>
                <h2 class="section-title">The Expert Advantage</h2>
                <p class="text-muted mb-5">We are not just a driving school; we are your partners in mastering the road. Our methods are proven, our instructors are patient, and our results speak for themselves.</p>
                
                <div class="row g-4">
                    <div class="col-sm-6">
                        <div class="d-flex gap-3 align-items-start">
                            <i class="fas fa-check-circle text-primary mt-1"></i>
                            <div>
                                <h6 class="fw-800 mb-1">Dual Controls</h6>
                                <p class="small text-muted mb-0">Maximum safety in modern vehicles.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex gap-3 align-items-start">
                            <i class="fas fa-check-circle text-primary mt-1"></i>
                            <div>
                                <h6 class="fw-800 mb-1">Expert Feedback</h6>
                                <p class="small text-muted mb-0">Detailed progress reports.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex gap-3 align-items-start">
                            <i class="fas fa-check-circle text-primary mt-1"></i>
                            <div>
                                <h6 class="fw-800 mb-1">Flexible Booking</h6>
                                <p class="small text-muted mb-0">Online 24/7 rescheduling.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex gap-3 align-items-start">
                            <i class="fas fa-check-circle text-primary mt-1"></i>
                            <div>
                                <h6 class="fw-800 mb-1">Fast Track</h6>
                                <p class="small text-muted mb-0">Get your P's faster.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <div class="position-relative">
                    <img src="https://images.unsplash.com/photo-1596733430284-f7437764b1a9?q=80&w=2070&auto=format&fit=crop" class="img-fluid rounded-4 shadow-lg" alt="Driving Lesson">
                    <div class="position-absolute bottom-0 start-0 p-4 m-4 bg-white rounded-3 shadow-lg d-none d-md-block" style="max-width: 250px;">
                        <div class="d-flex align-items-center gap-3">
                            <div class="bg-primary-light p-2 rounded-2">
                                <i class="fas fa-award text-primary fa-lg"></i>
                            </div>
                            <span class="fw-800 small">Top Rated in Hobart Region</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Locations Section -->
<section class="section-padding bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <span class="section-tag" data-aos="fade-up">Coverage</span>
            <h2 class="section-title" data-aos="fade-up" data-aos-delay="100">Servicing Greater Hobart</h2>
            <p class="section-subtitle" data-aos="fade-up" data-aos-delay="200">Our instructors come to you. See our primary pickup zones below.</p>
        </div>
        
        <div class="row g-4">
            <div class="col-md-6" data-aos="fade-right">
                <div class="bg-white p-4 rounded-4 border h-100">
                    <h5 class="fw-800 mb-4 d-flex align-items-center gap-2">
                        <i class="fas fa-car text-primary"></i> Driving Lessons
                    </h5>
                    <div class="d-flex flex-wrap gap-2">
                        @foreach($locations->take(10) as $location)
                            <span class="badge bg-slate-100 text-slate-700 px-3 py-2 rounded-2 border" style="font-weight: 600;">{{ $location->name }}</span>
                        @endforeach
                    </div>
                    <p class="mt-4 small text-muted">We also service Kingston & surrounding suburbs. For unlisted areas, call us for alternative arrangements.</p>
                </div>
            </div>
            <div class="col-md-6" data-aos="fade-left">
                <div class="bg-white p-4 rounded-4 border h-100">
                    <h5 class="fw-800 mb-4 d-flex align-items-center gap-2">
                        <i class="fas fa-id-card text-primary"></i> P1 Assessment Routes
                    </h5>
                    <div class="d-flex flex-wrap gap-2">
                        @foreach($locations->take(6) as $location)
                            <span class="badge" style="background: rgba(245, 158, 11, 0.1); color: var(--primary-color); font-weight: 700; padding: 10px 16px;">{{ $location->name }}</span>
                        @endforeach
                    </div>
                    <p class="mt-4 small text-muted">Accredited P1 Assessors working on behalf of State Growth across multiple assessment routes.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
@if($testimonials->count() > 0)
<section class="section-padding">
    <div class="container">
        <div class="text-center mb-5">
            <span class="section-tag" data-aos="fade-up">Testimonials</span>
            <h2 class="section-title" data-aos="fade-up" data-aos-delay="100">What Our Students Say</h2>
            <p class="section-subtitle" data-aos="fade-up" data-aos-delay="200">Hear from our satisfied students who mastered the road with us.</p>
        </div>
        <div class="swiper testimonials-swiper pb-5" data-aos="fade-up">
            <div class="swiper-wrapper">
                @foreach($testimonials as $testimonial)
                <div class="swiper-slide h-auto">
                    <div class="testimonial-card shadow-sm">
                        <div class="stars mb-3">
                            @for($i = 0; $i < $testimonial->rating; $i++)
                            <i class="fas fa-star fa-sm"></i>
                            @endfor
                        </div>
                        <p class="mb-4" style="color: var(--slate-600); font-style: italic;">"{{ $testimonial->content }}"</p>
                        <div class="d-flex align-items-center mt-auto">
                            <div class="rounded-circle d-flex align-items-center justify-content-center fw-800" style="width: 44px; height: 44px; background: var(--slate-100); color: var(--secondary-color);">
                                {{ substr($testimonial->customer_name, 0, 1) }}
                            </div>
                            <div class="ms-3">
                                <h6 class="mb-0 fw-800">{{ $testimonial->customer_name }}</h6>
                                <small class="text-slate-500" style="color: var(--slate-500);">{{ $testimonial->customer_location ?? 'Hobart' }}</small>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
</section>
@endif

<!-- CTA Section -->
<section class="section-padding" style="background: var(--secondary-color);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <h2 class="text-white fw-800 mb-4 h1" data-aos="fade-up">Ready to Start Your Journey?</h2>
                <p class="text-slate-400 mb-5 h5" style="color: var(--slate-400); opacity: 0.8;" data-aos="fade-up" data-aos-delay="100">Book your first lesson today and experience the expert difference.</p>
                <div class="d-flex gap-3 justify-content-center flex-wrap" data-aos="fade-up" data-aos-delay="200">
                    <a href="{{ route('book-online') }}" class="btn btn-book btn-lg px-5">
                        Book Online Now
                    </a>
                    <a href="{{ route('contact') }}" class="btn btn-outline-light btn-lg px-5">
                        Contact Us
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
    // Initialize Testimonials Swiper
    new Swiper('.testimonials-swiper', {
        slidesPerView: 1,
        spaceBetween: 30,
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        breakpoints: {
            768: {
                slidesPerView: 2,
            },
            1024: {
                slidesPerView: 3,
            },
        },
    });
</script>
@endsection
