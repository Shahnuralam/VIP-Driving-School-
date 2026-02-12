@extends('frontend.layouts.app')

@section('title', 'Lesson Packages - VIP Driving School Hobart')

@section('content')
<!-- Page Header -->
<section class="page-header">
    <div class="container">
        <h1 data-aos="fade-up">Lesson Packages</h1>
        <nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="100">
            <ol class="breadcrumb justify-content-center">
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
            <h2 class="section-title" data-aos="fade-up">Choose Your Package</h2>
            <p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">Select the package that best suits your learning needs</p>
        </div>

        <!-- Info Alert -->
        <div class="alert alert-info border-0 shadow-sm mb-5" data-aos="fade-up">
            <div class="d-flex align-items-center">
                <i class="fas fa-info-circle fa-2x me-3"></i>
                <div>
                    <strong>Important Information</strong>
                    <p class="mb-0">All packages include a dual-control vehicle, experienced instructor, and pick-up/drop-off service within service areas.</p>
                </div>
            </div>
        </div>

        <!-- Package Grid -->
        <div class="row g-4">
            @forelse($packages as $package)
            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                <div class="package-card h-100 {{ $package->is_featured ? 'featured' : '' }}">
                    @if($package->is_featured)
                    <div class="package-badge popular">
                        <i class="fas fa-star me-1"></i>Most Popular
                    </div>
                    @endif
                    
                    <div class="package-header">
                        <h4>{{ $package->name }}</h4>
                        @if($package->tagline)
                        <span class="badge bg-light text-dark">{{ $package->tagline }}</span>
                        @endif
                    </div>
                    
                    <div class="package-price">
                        <span class="currency">$</span>
                        <span class="amount">{{ number_format($package->price, 0) }}</span>
                        @if($package->lesson_count)
                        <span class="period">/ {{ $package->lesson_count }} {{ Str::plural('lesson', $package->lesson_count) }}</span>
                        @endif
                    </div>
                    
                    @if($package->original_price && $package->original_price > $package->price)
                    <div class="text-center mb-3">
                        <span class="text-muted text-decoration-line-through">${{ number_format($package->original_price, 0) }}</span>
                        <span class="badge bg-success ms-2">Save ${{ number_format($package->original_price - $package->price, 0) }}</span>
                    </div>
                    @endif
                    
                    <div class="package-description">
                        {!! $package->description !!}
                    </div>
                    
                    <ul class="package-features">
                        <li><i class="fas fa-check text-success me-2"></i>{{ $package->lesson_count }} x {{ $package->lesson_duration }}-minute lessons</li>
                        <li><i class="fas fa-check text-success me-2"></i>Flexible scheduling</li>
                        <li><i class="fas fa-check text-success me-2"></i>Pick-up & drop-off included</li>
                        <li><i class="fas fa-check text-success me-2"></i>Dual-control vehicle</li>
                        <li><i class="fas fa-check text-success me-2"></i>Experienced instructor</li>
                    </ul>
                    
                    @if($package->validity_text)
                    <div class="text-center text-muted small mb-3">
                        <i class="fas fa-clock me-1"></i>{{ $package->validity_text }}
                    </div>
                    @endif
                    
                    <div class="package-footer">
                        <a href="{{ route('book-online', ['package' => $package->id]) }}" class="btn btn-book w-100">
                            <i class="fas fa-calendar-check me-2"></i>Book This Package
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="alert alert-warning text-center">
                    <i class="fas fa-exclamation-triangle me-2"></i>No packages available at the moment. Please check back later.
                </div>
            </div>
            @endforelse
        </div>

        <!-- Additional Info Cards -->
        @if($infoCards->count() > 0)
        <div class="mt-5 pt-5 border-top">
            <h3 class="text-center mb-4" data-aos="fade-up">Things to Know</h3>
            <div class="row g-4">
                @foreach($infoCards as $card)
                <div class="col-md-6" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                    <div class="info-card h-100">
                        <i class="{{ $card->icon ?? 'fas fa-info-circle' }}"></i>
                        <h5>{{ $card->title }}</h5>
                        <p class="text-muted mb-0">{{ $card->content }}</p>
                    </div>
                </div>
                @endforeach
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
    .package-card {
        background: white;
        border-radius: 16px;
        padding: 2rem;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }

    .package-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.12);
    }

    .package-card.featured {
        border: 2px solid var(--primary-color);
    }

    .package-badge {
        position: absolute;
        top: 15px;
        right: -35px;
        background: var(--secondary-color);
        color: white;
        padding: 5px 40px;
        font-size: 12px;
        font-weight: 600;
        transform: rotate(45deg);
    }

    .package-badge.popular {
        background: var(--primary-color);
    }

    .package-header {
        text-align: center;
        margin-bottom: 1.5rem;
    }

    .package-header h4 {
        margin-bottom: 0.5rem;
        color: var(--dark-color);
    }

    .package-price {
        text-align: center;
        margin-bottom: 1.5rem;
    }

    .package-price .currency {
        font-size: 1.5rem;
        vertical-align: super;
    }

    .package-price .amount {
        font-size: 3rem;
        font-weight: 700;
        color: var(--primary-color);
    }

    .package-price .period {
        color: #6c757d;
        font-size: 0.9rem;
    }

    .package-description {
        color: #6c757d;
        margin-bottom: 1.5rem;
        flex-grow: 1;
    }

    .package-features {
        list-style: none;
        padding: 0;
        margin-bottom: 1.5rem;
    }

    .package-features li {
        padding: 0.5rem 0;
        border-bottom: 1px solid #eee;
    }

    .package-features li:last-child {
        border-bottom: none;
    }

    .package-footer {
        margin-top: auto;
    }

    .accordion-item {
        border: none;
        margin-bottom: 1rem;
        border-radius: 8px !important;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }

    .accordion-button {
        font-weight: 600;
        background: white;
    }

    .accordion-button:not(.collapsed) {
        background: var(--primary-color);
        color: white;
    }

    .accordion-button:focus {
        box-shadow: none;
    }
</style>
@endsection
