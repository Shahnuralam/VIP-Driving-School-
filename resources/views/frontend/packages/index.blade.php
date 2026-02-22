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
        <div class="row g-4 justify-content-center">
            @forelse($packages as $package)
            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                <div class="package-card h-100 {{ $package->is_featured ? 'featured dark' : '' }}">
                    @if($package->is_featured)
                        <span class="featured-badge">Best Value</span>
                    @endif
                    
                    <div class="p-5">
                        <h3 class="fw-800 mb-2 h4">{{ $package->name }}</h3>
                        @if($package->tagline)
                        <span class="badge bg-primary text-slate-900 mb-4 px-3 py-2 rounded-2" style="font-weight: 700; background: rgba(245, 158, 11, 0.2); color: var(--primary-color);">{{ $package->tagline }}</span>
                        @endif
                        
                        <div class="package-price mb-4">
                            <span class="currency h4">$</span>
                            <span class="amount display-4 fw-800">{{ number_format($package->price, 0) }}</span>
                            @if($package->lesson_count)
                            <div class="text-muted small mt-1">For {{ $package->lesson_count }} {{ Str::plural('lesson', $package->lesson_count) }}</div>
                            @endif
                        </div>
                        
                        @if($package->original_price && $package->original_price > $package->price)
                        <div class="mb-4">
                            <span class="text-muted text-decoration-line-through me-2">${{ number_format($package->original_price, 0) }}</span>
                            <span class="badge bg-success bg-opacity-10 text-success px-2 py-1">Save ${{ number_format($package->original_price - $package->price, 0) }}</span>
                        </div>
                        @endif
                        
                        <ul class="package-features list-unstyled mb-5">
                            <li class="mb-3 d-flex align-items-center gap-2">
                                <i class="fas fa-check-circle text-primary"></i>
                                <span>{{ $package->lesson_count }} x {{ $package->lesson_duration }}m Lessons</span>
                            </li>
                            <li class="mb-3 d-flex align-items-center gap-2">
                                <i class="fas fa-check-circle text-primary"></i>
                                <span>Flexible Scheduling</span>
                            </li>
                            <li class="mb-3 d-flex align-items-center gap-2">
                                <i class="fas fa-check-circle text-primary"></i>
                                <span>Door-to-Door Service</span>
                            </li>
                            <li class="d-flex align-items-center gap-2">
                                <i class="fas fa-check-circle text-primary"></i>
                                <span>Dual Control Safety</span>
                            </li>
                        </ul>
                        
                        <div class="mt-auto">
                            <a href="{{ route('book-online', ['package' => $package->id]) }}" class="btn {{ $package->is_featured ? 'btn-primary' : 'btn-outline-primary' }} w-100 py-3">
                                Get Started <i class="fas fa-arrow-right ms-2 small"></i>
                            </a>
                        </div>
                    </div>
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
</style>
@endsection
