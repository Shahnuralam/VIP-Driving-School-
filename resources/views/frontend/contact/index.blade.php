@extends('frontend.layouts.app')

@section('title', 'Contact Us - VIP Driving School Hobart')

@section('content')
<!-- Page Header -->
<section class="page-header">
    <div class="container" data-aos="fade-up">
        <span class="section-tag" style="color: var(--primary-color);">Get In Touch</span>
        <h1>Contact Us</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('frontend.home') }}">Home</a></li>
                <li class="breadcrumb-item active">Contact</li>
            </ol>
        </nav>
    </div>
</section>

<!-- Contact Section -->
<section class="section-padding">
    <div class="container">
        <div class="row g-5">
            <!-- Contact Form -->
            <div class="col-lg-8" data-aos="fade-up">
                <div class="contact-form-card">
                    <h3 class="mb-4">Send Us a Message</h3>

                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif

                    @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif

                    <form method="POST" action="{{ route('contact.store') }}">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Your Name *</label>
                                <input type="text" name="name" class="form-control form-control-lg" value="{{ old('name') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email Address *</label>
                                <input type="email" name="email" class="form-control form-control-lg" value="{{ old('email') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Phone Number</label>
                                <input type="tel" name="phone" class="form-control form-control-lg" value="{{ old('phone') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Subject *</label>
                                <select name="subject" class="form-select form-select-lg" required>
                                    <option value="">Select a subject</option>
                                    <option value="General Enquiry" {{ old('subject') == 'General Enquiry' ? 'selected' : '' }}>General Enquiry</option>
                                    <option value="Booking Enquiry" {{ old('subject') == 'Booking Enquiry' ? 'selected' : '' }}>Booking Enquiry</option>
                                    <option value="Package Information" {{ old('subject') == 'Package Information' ? 'selected' : '' }}>Package Information</option>
                                    <option value="P1 Assessment" {{ old('subject') == 'P1 Assessment' ? 'selected' : '' }}>P1 Assessment</option>
                                    <option value="Feedback" {{ old('subject') == 'Feedback' ? 'selected' : '' }}>Feedback</option>
                                    <option value="Other" {{ old('subject') == 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Message *</label>
                                <textarea name="message" class="form-control" rows="5" required>{{ old('message') }}</textarea>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-book btn-lg">
                                    <i class="fas fa-paper-plane me-2"></i>Send Message
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Contact Info -->
            <div class="col-lg-4">
                <div class="contact-info-card mb-4" data-aos="fade-left">
                    <h5 class="fw-800 mb-3"><i class="fas fa-map-marker-alt text-primary me-2"></i>Our Office</h5>
                    <p class="text-muted mb-0">{{ $settings['business_address'] ?? 'Hobart, Tasmania' }}</p>
                </div>

                <div class="contact-info-card mb-4" data-aos="fade-left" data-aos-delay="100">
                    <h5 class="fw-800 mb-3"><i class="fas fa-phone text-primary me-2"></i>Phone</h5>
                    <p class="mb-0">
                        <a href="tel:{{ $settings['contact_phone'] ?? '0400000000' }}" class="fw-bold text-decoration-none" style="color: var(--secondary-color);">
                            {{ $settings['contact_phone'] ?? '0400 000 000' }}
                        </a>
                    </p>
                </div>

                <div class="contact-info-card mb-4" data-aos="fade-left" data-aos-delay="200">
                    <h5 class="fw-800 mb-3"><i class="fas fa-envelope text-primary me-2"></i>Email</h5>
                    <p class="mb-0">
                        <a href="mailto:{{ $settings['contact_email'] ?? 'info@vipdrivingschool.com.au' }}" class="fw-bold text-decoration-none" style="color: var(--secondary-color);">
                            {{ $settings['contact_email'] ?? 'info@vipdrivingschool.com.au' }}
                        </a>
                    </p>
                </div>

                <div class="contact-info-card mb-4" data-aos="fade-left" data-aos-delay="300">
                    <h5 class="fw-800 mb-3"><i class="fas fa-clock text-primary me-2"></i>Business Hours</h5>
                    <ul class="list-unstyled mb-0 text-muted">
                        <li class="mb-1 d-flex justify-content-between"><span>Mon - Fri:</span> <span>8:00 AM - 6:00 PM</span></li>
                        <li class="mb-1 d-flex justify-content-between"><span>Saturday:</span> <span>8:00 AM - 4:00 PM</span></li>
                        <li class="d-flex justify-content-between"><span>Sunday:</span> <span>Closed</span></li>
                    </ul>
                </div>

                <div class="contact-info-card" data-aos="fade-left" data-aos-delay="400">
                    <h5 class="fw-800 mb-3">Connect With Us</h5>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-google"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Map Section -->
<section class="map-section">
    <iframe 
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d47231.01738252853!2d147.28876973437504!3d-42.88207930000001!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xaa6e758cfa9a9e1f%3A0x502a35af3deaf90!2sHobart%20TAS%2C%20Australia!5e0!3m2!1sen!2s!4v1707300000000!5m2!1sen!2s" 
        width="100%" 
        height="450" 
        style="border:0;" 
        allowfullscreen="" 
        loading="lazy" 
        referrerpolicy="no-referrer-when-downgrade">
    </iframe>
</section>
@endsection

@section('styles')
<style>
    .contact-form-card {
        background: white;
        border-radius: 20px;
        padding: 3rem;
        border: 1px solid var(--slate-200);
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    }

    .contact-info-card {
        background: white;
        border-radius: 16px;
        padding: 2rem;
        border: 1px solid var(--slate-100);
        box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
    }

    .contact-info-card h5 {
        font-size: 1.1rem;
        color: var(--secondary-color);
    }

    .social-links {
        display: flex;
        gap: 12px;
    }

    .social-links a {
        width: 44px;
        height: 44px;
        border-radius: 10px;
        background: var(--slate-50);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--secondary-color);
        transition: all 0.3s ease;
        text-decoration: none;
    }

    .social-links a:hover {
        background: var(--primary-color);
        color: var(--secondary-color);
        transform: translateY(-3px);
    }

    .form-label {
        font-weight: 700;
        color: var(--secondary-color);
        font-size: 0.9rem;
        margin-bottom: 0.75rem;
    }

    .form-control, .form-select {
        border: 1px solid var(--slate-200);
        padding: 0.75rem 1rem;
        border-radius: 10px;
        font-size: 0.95rem;
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 4px rgba(245, 158, 11, 0.1);
    }

    .map-section iframe {
        display: block;
    }
</style>
@endsection
