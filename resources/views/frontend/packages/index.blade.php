@extends('frontend.layouts.app')

@section('title', 'Lesson Packages - VIP Driving School Hobart')

@section('content')
<!-- Page Header -->
<section class="page-header">
    <div class="container" data-aos="fade-up">
        <span class="section-tag" style="color: var(--primary-color);">Save with Packages</span>
        <h1>Lesson Packages</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('frontend.home') }}">Home</a></li>
                <li class="breadcrumb-item active">Lesson Packages</li>
            </ol>
        </nav>
    </div>
</section>

<!-- Packages Section -->
<section class="section-padding">
    <div class="container">
        <div class="text-center mb-5">
            <span class="section-tag" data-aos="fade-up">Packages</span>
            <h2 class="section-title" data-aos="fade-up" data-aos-delay="100">Choose Your Path</h2>
            <p class="section-subtitle" data-aos="fade-up" data-aos-delay="200">Select the package that best suits your learning goals and budget.</p>
        </div>

        <!-- Important Information Box -->
        <div class="row justify-content-center mb-5">
            <div class="col-lg-10">
                <div class="info-box-modern" data-aos="fade-up">
                    <div class="info-box-header">
                        <i class="fas fa-info-circle"></i>
                        <h4>About Our Lesson Packages</h4>
                    </div>
                    <div class="info-box-content">
                        <div class="info-item">
                            <i class="fas fa-clock text-primary"></i>
                            <p>Our <strong>50 Minute Lesson Packages</strong> can be purchased online and you can book them yourself within our Bookings Calendar once you register your account during the Check-out process. We recommend that the lessons be scheduled on alternate days.</p>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-map-marker-alt text-primary"></i>
                            <p>We service <strong>Hobart and surrounding suburbs ONLY</strong>. For a complete list, please check out our <a href="{{ route('frontend.home') }}#locations" class="text-primary fw-bold">Home page</a>.</p>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-car text-primary"></i>
                            <p>Lessons are conducted in <strong>Automatic or Manual Transmission</strong> vehicles. All students must present a valid license/permit at the start of any lesson. Please see our <a href="{{ route('page.show', 'code-of-conduct') }}" class="text-primary fw-bold">Code of Conduct</a> for both Students and Instructors/Assessors.</p>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-gift text-primary"></i>
                            <p><strong>Lesson Packages make great gifts!</strong> You can buy our digital gift cards and set your amount to cover any of our services.</p>
                        </div>
                        <div class="info-item mb-0">
                            <i class="fas fa-calendar-check text-primary"></i>
                            <p class="mb-0">Please check out our availability of lessons before buying a package to ensure it meets your requirements.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Package Grid -->
        <div class="row g-4 justify-content-center align-items-stretch">
            @forelse($packages as $package)
            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                <div class="service-card-new {{ $package->is_featured ? 'featured-dark' : '' }} h-100">
                    @if($package->is_featured)
                        <span class="featured-badge-new">Best Value</span>
                    @endif
                    
                    <div class="service-icon-wrapper">
                        <i class="fas fa-box-open"></i>
                    </div>
                    
                    <h3 class="service-title">{{ $package->name }}</h3>
                    
                    @if($package->tagline)
                    <div class="package-tagline mb-3">{{ $package->tagline }}</div>
                    @endif
                    
                    <div class="service-price mb-3">
                        <span>${{ number_format($package->price, 0) }}</span>
                    </div>
                    
                    @if($package->lesson_count)
                    <div class="package-lesson-info mb-3">{{ $package->lesson_count }} x {{ $package->lesson_duration }}min Lessons</div>
                    @endif
                    
                    @if($package->original_price && $package->original_price > $package->price)
                    <div class="package-savings mb-4">
                        <span class="original-price">${{ number_format($package->original_price, 0) }}</span>
                        <span class="save-badge">Save ${{ number_format($package->original_price - $package->price, 0) }}</span>
                    </div>
                    @endif
                    
                    @if($package->description)
                    <ul class="package-features-list list-unstyled mb-4 w-100">
                        @foreach(explode("\n", $package->description) as $feature)
                            @if(trim($feature))
                            <li class="mb-2 d-flex align-items-start gap-2">
                                <i class="fas fa-check-circle package-check-icon mt-1"></i>
                                <span>{{ trim($feature) }}</span>
                            </li>
                            @endif
                        @endforeach
                    </ul>
                    @else
                    <ul class="package-features-list list-unstyled mb-4 w-100">
                        <li class="mb-2 d-flex align-items-start gap-2">
                            <i class="fas fa-check-circle package-check-icon"></i>
                            <span>Flexible Scheduling</span>
                        </li>
                        <li class="mb-2 d-flex align-items-start gap-2">
                            <i class="fas fa-check-circle package-check-icon"></i>
                            <span>Door-to-Door Service</span>
                        </li>
                        <li class="d-flex align-items-start gap-2">
                            <i class="fas fa-check-circle package-check-icon"></i>
                            <span>Dual Control Safety</span>
                        </li>
                    </ul>
                    @endif
                    
                    <a href="#" class="service-btn {{ $package->is_featured ? 'btn-featured' : 'btn-regular-package' }}" data-bs-toggle="modal" data-bs-target="#packageModal{{ $package->id }}">
                        Get Started <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="alert alert-warning text-center rounded-4 border-0 shadow-sm py-4">
                    <i class="fas fa-exclamation-triangle me-2"></i>No packages available at the moment. Please check back later.
                </div>
            </div>
            @endforelse
        </div>

        <!-- Package Purchase Modals -->
        @foreach($packages as $package)
        <div class="modal fade" id="packageModal{{ $package->id }}" tabindex="-1" aria-labelledby="packageModalLabel{{ $package->id }}" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content" style="border-radius: 20px; border: none;">
                    <div class="modal-header" style="background: linear-gradient(135deg, var(--primary-color) 0%, #ffa726 100%); border-radius: 20px 20px 0 0; border: none;">
                        <h5 class="modal-title fw-800" id="packageModalLabel{{ $package->id }}" style="color: var(--secondary-color);">
                            <i class="fas fa-shopping-cart me-2"></i>Purchase {{ $package->name }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: brightness(0);"></button>
                    </div>
                    <div class="modal-body p-4">
                        @guest('customer')
                        <!-- Login/Signup Tabs -->
                        <ul class="nav nav-pills nav-fill mb-4 auth-tabs" id="authTabs{{ $package->id }}" role="tablist" style="background: #f8f9fa; padding: 0.5rem; border-radius: 12px;">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="login-tab-{{ $package->id }}" data-bs-toggle="pill" data-bs-target="#login-{{ $package->id }}" type="button" role="tab" style="border-radius: 8px;">
                                    <i class="fas fa-sign-in-alt me-2"></i>Login
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="signup-tab-{{ $package->id }}" data-bs-toggle="pill" data-bs-target="#signup-{{ $package->id }}" type="button" role="tab" style="border-radius: 8px;">
                                    <i class="fas fa-user-plus me-2"></i>Sign Up
                                </button>
                            </li>
                        </ul>

                        <div class="tab-content" id="authTabContent{{ $package->id }}">
                            <!-- Login Form -->
                            <div class="tab-pane fade show active" id="login-{{ $package->id }}" role="tabpanel">
                                <form id="loginForm{{ $package->id }}" class="auth-form" data-package-id="{{ $package->id }}">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label fw-600" style="color: var(--secondary-color);">Email Address</label>
                                        <input type="email" name="email" class="form-control" required placeholder="your@email.com" style="font-size: 1rem;">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-600" style="color: var(--secondary-color);">Password</label>
                                        <input type="password" name="password" class="form-control" required placeholder="Enter your password" style="font-size: 1rem;">
                                    </div>
                                    <div class="mb-3 form-check">
                                        <input type="checkbox" name="remember" class="form-check-input" id="remember{{ $package->id }}">
                                        <label class="form-check-label" for="remember{{ $package->id }}" style="color: var(--slate-600);">Remember me</label>
                                    </div>
                                    <div id="login-error-{{ $package->id }}" class="alert alert-danger d-none" style="font-size: 0.9rem;"></div>
                                    <button type="submit" class="btn btn-primary w-100 py-3 fw-700" style="font-size: 1rem;">
                                        <i class="fas fa-sign-in-alt me-2"></i>Login & Continue
                                    </button>
                                </form>
                            </div>

                            <!-- Signup Form -->
                            <div class="tab-pane fade" id="signup-{{ $package->id }}" role="tabpanel">
                                <form id="signupForm{{ $package->id }}" class="auth-form" data-package-id="{{ $package->id }}">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label fw-600" style="color: var(--secondary-color);">Full Name</label>
                                        <input type="text" name="name" class="form-control" required placeholder="John Smith" style="font-size: 1rem;">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-600" style="color: var(--secondary-color);">Email Address</label>
                                        <input type="email" name="email" class="form-control" required placeholder="your@email.com" style="font-size: 1rem;">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-600" style="color: var(--secondary-color);">Phone Number</label>
                                        <input type="tel" name="phone" class="form-control" required placeholder="0400 000 000" style="font-size: 1rem;">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-600" style="color: var(--secondary-color);">Password</label>
                                        <input type="password" name="password" class="form-control" required placeholder="Minimum 8 characters" style="font-size: 1rem;">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-600" style="color: var(--secondary-color);">Confirm Password</label>
                                        <input type="password" name="password_confirmation" class="form-control" required placeholder="Re-enter password" style="font-size: 1rem;">
                                    </div>
                                    <div id="signup-error-{{ $package->id }}" class="alert alert-danger d-none" style="font-size: 0.9rem;"></div>
                                    <button type="submit" class="btn btn-primary w-100 py-3 fw-700" style="font-size: 1rem;">
                                        <i class="fas fa-user-plus me-2"></i>Create Account & Continue
                                    </button>
                                </form>
                            </div>
                        </div>
                        @else
                        <!-- Checkout Section for Logged In Users -->
                        <div class="checkout-section">
                            <!-- Package Summary -->
                            <div class="package-summary mb-4 p-4" style="background: var(--slate-50); border-radius: 12px;">
                                <h6 class="fw-700 mb-3">Order Summary</h6>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>{{ $package->name }}</span>
                                    <span class="fw-700">${{ number_format($package->price, 2) }}</span>
                                </div>
                                @if($package->lesson_count)
                                <div class="text-muted small mb-2">
                                    {{ $package->lesson_count }} x {{ $package->lesson_duration }}min Lessons
                                </div>
                                @endif
                                <hr>
                                <div class="d-flex justify-content-between fw-800">
                                    <span>Total</span>
                                    <span style="color: var(--primary-color); font-size: 1.25rem;">${{ number_format($package->price, 2) }}</span>
                                </div>
                            </div>

                            <!-- Payment Form -->
                            <form id="packagePurchaseForm{{ $package->id }}" class="package-purchase-form" data-package-id="{{ $package->id }}">
                                @csrf
                                <input type="hidden" name="package_id" value="{{ $package->id }}">
                                
                                <div class="mb-3">
                                    <label class="form-label fw-700">Card Details</label>
                                    <div id="card-element-{{ $package->id }}" class="stripe-card-element"></div>
                                    <div id="card-errors-{{ $package->id }}" class="text-danger mt-2 small"></div>
                                </div>

                                <button type="submit" class="btn btn-primary w-100 py-3 fw-700" id="submitBtn{{ $package->id }}">
                                    <i class="fas fa-lock me-2"></i>Complete Purchase - ${{ number_format($package->price, 2) }}
                                </button>
                                
                                <div class="text-center mt-3">
                                    <small class="text-muted">
                                        <i class="fas fa-shield-alt me-1"></i>Secure payment powered by Stripe
                                    </small>
                                </div>
                            </form>
                        </div>
                        @endguest
                    </div>
                </div>
            </div>
        </div>
        @endforeach

        <!-- Additional Info Cards -->
        @if($infoCards->count() > 0)
        <div class="mt-5 pt-5 border-top">
            <h3 class="text-center mb-5 fw-800" data-aos="fade-up" style="color: var(--secondary-color);">Things to Know</h3>
            <div class="row g-4">
                @foreach($infoCards as $card)
                <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                    <div class="info-card h-100">
                        <i class="{{ $card->icon ?? 'fas fa-info-circle' }}"></i>
                        <h5>{{ $card->title }}</h5>
                        <p class="text-muted mb-0">{{ $card->content }}</p>
                    </div>
                </div>
                @endforeach

                <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="{{ $infoCards->count() * 100 }}">
                    <div class="info-card h-100">
                        <i class="fas fa-hourglass-half"></i>
                        <h5>Package Validity</h5>
                        <p class="text-muted mb-0">Book your package lessons within the validity period shown at checkout for the best availability.</p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="{{ ($infoCards->count() + 1) * 100 }}">
                    <div class="info-card h-100">
                        <i class="fas fa-calendar-alt"></i>
                        <h5>Reschedule Notice</h5>
                        <p class="text-muted mb-0">Need to move a lesson? Please provide at least 24 hours' notice so your package session remains available.</p>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</section>

<!-- FAQ Section -->
@if(isset($faqs) && $faqs->count() > 0)
<section class="section-padding bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title" data-aos="fade-up">Frequently Asked Questions</h2>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="accordion" id="faqAccordion" data-aos="fade-up">
                    @foreach($faqs as $index => $faq)
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button {{ $index > 0 ? 'collapsed' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#faq{{ $faq->id }}">
                                {{ $faq->question }}
                            </button>
                        </h2>
                        <div id="faq{{ $faq->id }}" class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                {!! nl2br(e($faq->answer)) !!}
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@endif

<!-- CTA Section -->
<section class="section-padding" style="background: linear-gradient(135deg, var(--primary-color) 0%, #2d5a8c 100%);">
    <div class="container text-center text-white">
        <h2 class="mb-3" data-aos="fade-up">Not Sure Which Package to Choose?</h2>
        <p class="lead mb-4 opacity-75" data-aos="fade-up" data-aos-delay="100">Contact us and we'll help you find the perfect package for your needs</p>
        <a href="{{ route('contact') }}" class="btn btn-outline-light btn-lg" data-aos="fade-up" data-aos-delay="200">
            <i class="fas fa-phone me-2"></i>Contact Us
        </a>
    </div>
</section>
@endsection

@section('styles')
<style>
    /* Modern Info Box */
    .info-box-modern {
        background: white;
        border-radius: 20px;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        border: 1px solid rgba(226, 232, 240, 0.8);
    }

    .info-box-header {
        background: linear-gradient(135deg, var(--primary-color) 0%, #ffa726 100%);
        padding: 1.75rem 2rem;
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .info-box-header i {
        font-size: 1.75rem;
        color: var(--secondary-color);
    }

    .info-box-header h4 {
        margin: 0;
        color: var(--secondary-color);
        font-weight: 800;
        font-size: 1.35rem;
    }

    .info-box-content {
        padding: 2rem;
    }

    .info-item {
        display: flex;
        gap: 1.25rem;
        margin-bottom: 1.5rem;
        align-items: flex-start;
    }

    .info-item i {
        font-size: 1.25rem;
        margin-top: 0.25rem;
        flex-shrink: 0;
    }

    .info-item p {
        margin: 0;
        color: var(--slate-600);
        line-height: 1.7;
        font-size: 0.95rem;
    }

    .info-item a {
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .info-item a:hover {
        color: #ffa726 !important;
        text-decoration: underline;
    }

    .package-card {
        background: white;
        border-radius: 16px;
        border: 1px solid var(--slate-200);
        box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }

    .package-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1);
        border-color: var(--primary-color);
    }

    .package-card.dark {
        background: var(--secondary-color);
        color: white;
        border-color: var(--slate-800);
    }

    .package-card.dark .text-muted {
        color: var(--slate-400) !important;
    }

    .amount {
        line-height: 1;
        color: var(--secondary-color);
    }

    .package-card.dark .amount {
        color: var(--white);
    }

    .package-card.dark .package-price .currency {
        color: var(--primary-color);
    }

    .package-features li {
        color: var(--slate-600);
    }

    .package-card.dark .package-features li {
        color: var(--slate-300);
    }

    .accordion-item {
        border: 1px solid var(--slate-100);
        margin-bottom: 1rem;
        border-radius: 12px !important;
        overflow: hidden;
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
    }

    .accordion-button {
        font-weight: 700;
        padding: 1.25rem;
        color: var(--secondary-color);
    }

    .accordion-button:not(.collapsed) {
        background: var(--slate-50);
        color: var(--primary-color);
        box-shadow: none;
    }

    .accordion-button:focus {
        box-shadow: none;
    }

    @media (max-width: 768px) {
        .info-box-header {
            padding: 1.5rem 1.5rem;
            flex-direction: column;
            text-align: center;
        }

        .info-box-content {
            padding: 1.5rem;
        }

        .info-item {
            flex-direction: column;
            gap: 0.75rem;
            text-align: center;
        }

        .info-item i {
            margin-top: 0;
        }
    }

    /* Stripe Card Element */
    .stripe-card-element {
        padding: 15px;
        border: 2px solid #e0e0e0;
        border-radius: 8px;
        background: white;
        transition: border-color 0.3s ease;
    }

    .stripe-card-element:focus-within {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1);
    }

    /* Auth Tabs */
    .auth-tabs {
        background: #f8f9fa !important;
    }

    .nav-pills .nav-link {
        border-radius: 10px;
        font-weight: 600;
        padding: 0.75rem 1.5rem;
        color: var(--secondary-color) !important;
        background: transparent;
        border: none;
        transition: all 0.3s ease;
        font-size: 1rem;
    }

    .nav-pills .nav-link:hover {
        background: rgba(255, 255, 255, 0.5);
    }

    .nav-pills .nav-link.active {
        background: var(--primary-color) !important;
        color: var(--secondary-color) !important;
        box-shadow: 0 2px 8px rgba(245, 158, 11, 0.3);
    }

    .auth-form .form-label {
        color: var(--secondary-color);
        font-weight: 600;
        margin-bottom: 0.5rem;
        font-size: 0.95rem;
    }

    .auth-form .form-control {
        padding: 0.75rem 1rem;
        border-radius: 8px;
        border: 2px solid #e0e0e0;
        transition: border-color 0.3s ease;
        font-size: 1rem;
        color: var(--secondary-color);
    }

    .auth-form .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1);
    }

    .auth-form .form-control::placeholder {
        color: #aab7c4;
    }
</style>
@endsection

@section('scripts')
<script src="https://js.stripe.com/v3/"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Store which package modal is open
    let currentPackageId = null;
    
    // Track modal open
    @foreach($packages as $package)
    document.getElementById('packageModal{{ $package->id }}').addEventListener('show.bs.modal', function() {
        currentPackageId = {{ $package->id }};
    });
    @endforeach
    
    // Handle Login Forms
    @foreach($packages as $package)
    (function() {
        const loginForm = document.getElementById('loginForm{{ $package->id }}');
        if (loginForm) {
            loginForm.addEventListener('submit', async function(e) {
                e.preventDefault();
                const submitBtn = this.querySelector('button[type="submit"]');
                const errorDiv = document.getElementById('login-error-{{ $package->id }}');
                
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Logging in...';
                errorDiv.classList.add('d-none');
                
                try {
                    const formData = new FormData(this);
                    const response = await fetch('{{ route("customer.login") }}', {
                        method: 'POST',
                        body: formData,
                        credentials: 'same-origin',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                        }
                    });
                    
                    // Check if successful (redirect or ok)
                    if (response.redirected || response.ok) {
                        // Load checkout content via AJAX
                        loadCheckoutContent({{ $package->id }});
                    } else {
                        const text = await response.text();
                        let errorMessage = 'Invalid credentials. Please try again.';
                        
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(text, 'text/html');
                        const errorElement = doc.querySelector('.invalid-feedback, .alert-danger');
                        if (errorElement) {
                            errorMessage = errorElement.textContent.trim();
                        }
                        
                        errorDiv.textContent = errorMessage;
                        errorDiv.classList.remove('d-none');
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = '<i class="fas fa-sign-in-alt me-2"></i>Login & Continue';
                    }
                } catch (error) {
                    console.error('Login error:', error);
                    errorDiv.textContent = 'An error occurred. Please try again.';
                    errorDiv.classList.remove('d-none');
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<i class="fas fa-sign-in-alt me-2"></i>Login & Continue';
                }
            });
        }
        
        const signupForm = document.getElementById('signupForm{{ $package->id }}');
        if (signupForm) {
            signupForm.addEventListener('submit', async function(e) {
                e.preventDefault();
                const submitBtn = this.querySelector('button[type="submit"]');
                const errorDiv = document.getElementById('signup-error-{{ $package->id }}');
                
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Creating account...';
                errorDiv.classList.add('d-none');
                
                try {
                    const formData = new FormData(this);
                    const response = await fetch('{{ route("customer.register") }}', {
                        method: 'POST',
                        body: formData,
                        credentials: 'same-origin',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                        }
                    });
                    
                    // Check if successful
                    if (response.redirected || response.ok) {
                        // Load checkout content via AJAX
                        loadCheckoutContent({{ $package->id }});
                    } else {
                        const text = await response.text();
                        let errorMessage = 'Registration failed. Please try again.';
                        
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(text, 'text/html');
                        const errorElements = doc.querySelectorAll('.invalid-feedback, .alert-danger');
                        if (errorElements.length > 0) {
                            errorMessage = Array.from(errorElements).map(el => el.textContent.trim()).join('<br>');
                        }
                        
                        errorDiv.innerHTML = errorMessage;
                        errorDiv.classList.remove('d-none');
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = '<i class="fas fa-user-plus me-2"></i>Create Account & Continue';
                    }
                } catch (error) {
                    console.error('Signup error:', error);
                    errorDiv.textContent = 'An error occurred. Please try again.';
                    errorDiv.classList.remove('d-none');
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<i class="fas fa-user-plus me-2"></i>Create Account & Continue';
                }
            });
        }
    })();
    @endforeach
    
    // Function to load checkout content after login
    async function loadCheckoutContent(packageId) {
        const modalBody = document.querySelector('#packageModal' + packageId + ' .modal-body');
        
        // Show loading
        modalBody.innerHTML = '<div class="text-center py-5"><i class="fas fa-spinner fa-spin fa-3x text-primary"></i><p class="mt-3">Loading checkout...</p></div>';
        
        try {
            // Fetch the checkout content
            const response = await fetch('{{ route("packages.checkout") }}?package_id=' + packageId, {
                credentials: 'same-origin',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                }
            });
            
            const html = await response.text();
            modalBody.innerHTML = html;
            
            // Initialize Stripe for this package
            initializeStripe(packageId);
            
        } catch (error) {
            console.error('Error loading checkout:', error);
            modalBody.innerHTML = '<div class="alert alert-danger">Failed to load checkout. Please refresh and try again.</div>';
        }
    }
    
    // Initialize Stripe for a specific package
    function initializeStripe(packageId) {
        const stripe = Stripe('{{ config("services.stripe.key") }}');
        const elements = stripe.elements();
        
        // Create card element without automatic payment methods for localhost
        const cardElement = elements.create('card', {
            hidePostalCode: true,
            style: {
                base: {
                    fontSize: '16px',
                    color: '#32325d',
                    fontFamily: '"Plus Jakarta Sans", sans-serif',
                    '::placeholder': {
                        color: '#aab7c4'
                    }
                },
                invalid: {
                    color: '#fa755a',
                    iconColor: '#fa755a'
                }
            }
        });
        
        cardElement.mount('#card-element-' + packageId);
        
        // Handle card errors
        cardElement.on('change', function(event) {
            const displayError = document.getElementById('card-errors-' + packageId);
            if (event.error) {
                displayError.textContent = event.error.message;
            } else {
                displayError.textContent = '';
            }
        });
        
        // Handle form submission
        const form = document.getElementById('packagePurchaseForm' + packageId);
        const submitBtn = document.getElementById('submitBtn' + packageId);
        
        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Processing...';
            
            try {
                // Create payment method
                const {error, paymentMethod} = await stripe.createPaymentMethod({
                    type: 'card',
                    card: cardElement,
                });
                
                if (error) {
                    document.getElementById('card-errors-' + packageId).textContent = error.message;
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<i class="fas fa-lock me-2"></i>Complete Purchase';
                    return;
                }
                
                // Submit to server
                const formData = new FormData(form);
                formData.append('payment_method', paymentMethod.id);
                
                const response = await fetch('{{ route("packages.purchase") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                    body: formData
                });
                
                const result = await response.json();
                
                if (result.success) {
                    window.location.href = result.redirect;
                } else {
                    document.getElementById('card-errors-' + packageId).textContent = result.message || 'Payment failed. Please try again.';
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<i class="fas fa-lock me-2"></i>Complete Purchase';
                }
                
            } catch (error) {
                console.error('Payment error:', error);
                document.getElementById('card-errors-' + packageId).textContent = 'An error occurred. Please try again.';
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fas fa-lock me-2"></i>Complete Purchase';
            }
        });
    }
    
    @auth('customer')
    // Initialize Stripe for already logged in users
    @foreach($packages as $package)
    (function() {
        const cardElementDiv = document.getElementById('card-element-{{ $package->id }}');
        if (cardElementDiv) {
            initializeStripe({{ $package->id }});
        }
    })();
    @endforeach
    @endauth
});
</script>
@endsection
