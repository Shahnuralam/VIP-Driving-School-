@extends('frontend.layouts.app')

@section('title', 'VIP Driving School Hobart')

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6" data-aos="fade-right">
                <h1 class="hero-title">Learn to Drive with Confidence</h1>
                <p class="hero-subtitle">Professional driving lessons and P1 assessments in Hobart. Our experienced instructors will help you become a safe and confident driver.</p>
                <div class="d-flex gap-3 flex-wrap">
                    <a href="{{ route('book-online') }}" class="btn btn-book btn-lg">
                        <i class="fas fa-calendar-check me-2"></i>Book a Lesson
                    </a>
                    <a href="{{ route('lesson-packages') }}" class="btn btn-outline-light btn-lg">
                        View Packages
                    </a>
                </div>
                <div class="mt-4 d-flex gap-4">
                    <div>
                        <h3 class="mb-0">500+</h3>
                        <small class="opacity-75">Happy Students</small>
                    </div>
                    <div>
                        <h3 class="mb-0">98%</h3>
                        <small class="opacity-75">Pass Rate</small>
                    </div>
                    <div>
                        <h3 class="mb-0">10+</h3>
                        <small class="opacity-75">Years Experience</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 text-center" data-aos="fade-left">
                <div class="hero-image-placeholder rounded-4 shadow-lg d-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, #1a365d 0%, #2d5a87 100%); min-height: 400px;">
                    <div class="text-white text-center p-4">
                        <i class="fas fa-car fa-4x mb-3 opacity-50"></i>
                        <h4 class="opacity-75">Professional Driving Lessons</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

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
<section class="section-padding">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title" data-aos="fade-up">Our Services</h2>
            <p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">Comprehensive driving education for all levels</p>
        </div>
        <div class="row g-4">
            @foreach($categories as $category)
            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                <div class="service-card">
                    <div class="p-4">
                        <div class="mb-3">
                            <i class="{{ $category->icon ?? 'fas fa-car' }} fa-2x text-primary"></i>
                        </div>
                        <h4>{{ $category->name }}</h4>
                        <p class="text-muted">{{ $category->description ?? 'Professional ' . strtolower($category->name) . ' services to help you succeed.' }}</p>
                        <p class="mb-3"><strong>{{ $category->active_services_count }} services available</strong></p>
                        <a href="{{ route('book-online') }}" class="btn btn-outline-primary">
                            View Services <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Locations Section -->
<section class="section-padding bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title" data-aos="fade-up">Our Service Areas</h2>
            <p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">We provide driving lessons across Hobart and surrounding areas</p>
        </div>
        <div class="row g-4">
            @foreach($locations as $location)
            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                <div class="location-card">
                    <div class="p-4">
                        <h5><i class="fas fa-map-marker-alt text-primary me-2"></i>{{ $location->name }}</h5>
                        <p class="text-muted small mb-2">{{ $location->address }}</p>
                        @if($location->available_days_text)
                        <p class="mb-0"><strong>Available:</strong> {{ $location->available_days_text }}</p>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Testimonials Section -->
@if($testimonials->count() > 0)
<section class="section-padding">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title" data-aos="fade-up">What Our Students Say</h2>
            <p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">Hear from our satisfied students</p>
        </div>
        <div class="swiper testimonials-swiper" data-aos="fade-up">
            <div class="swiper-wrapper">
                @foreach($testimonials as $testimonial)
                <div class="swiper-slide">
                    <div class="testimonial-card">
                        <div class="stars mb-3">
                            @for($i = 0; $i < $testimonial->rating; $i++)
                            <i class="fas fa-star"></i>
                            @endfor
                        </div>
                        <p class="mb-3">"{{ $testimonial->content }}"</p>
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                {{ substr($testimonial->customer_name, 0, 1) }}
                            </div>
                            <div class="ms-3">
                                <h6 class="mb-0">{{ $testimonial->customer_name }}</h6>
                                <small class="text-muted">{{ $testimonial->customer_location ?? 'Hobart' }}</small>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="swiper-pagination mt-4"></div>
        </div>
    </div>
</section>
@endif

<!-- CTA Section -->
<section class="section-padding" style="background: linear-gradient(135deg, var(--primary-color) 0%, #2d5a8c 100%);">
    <div class="container text-center text-white">
        <h2 class="mb-3" data-aos="fade-up">Ready to Get Started?</h2>
        <p class="lead mb-4 opacity-75" data-aos="fade-up" data-aos-delay="100">Book your first driving lesson today and take the first step towards your licence</p>
        <a href="{{ route('book-online') }}" class="btn btn-book btn-lg" data-aos="fade-up" data-aos-delay="200">
            <i class="fas fa-calendar-check me-2"></i>Book Now
        </a>
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
