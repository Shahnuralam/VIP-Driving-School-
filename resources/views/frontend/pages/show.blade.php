@extends('frontend.layouts.app')

@section('title', $page->title . ' - VIP Driving School Hobart')

@if($page->meta_description)
@section('meta_description', $page->meta_description)
@endif

@if($page->meta_keywords)
@section('meta_keywords', $page->meta_keywords)
@endif

@section('content')
<!-- Page Header -->
<section class="page-header">
    <div class="container">
        <h1 data-aos="fade-up">{{ $page->title }}</h1>
        <nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="100">
            <ol class="breadcrumb justify-content-center">
                <li class="breadcrumb-item"><a href="{{ route('frontend.home') }}">Home</a></li>
                <li class="breadcrumb-item active">{{ $page->title }}</li>
            </ol>
        </nav>
    </div>
</section>

<!-- Page Content -->
<section class="section-padding">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4 p-md-5">
                        @if($page->featured_image)
                        <img src="{{ asset('storage/' . $page->featured_image) }}" alt="{{ $page->title }}" class="img-fluid rounded mb-4">
                        @endif
                        
                        <div class="page-content">
                            {!! $page->content !!}
                        </div>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <p class="text-muted small">Last updated: {{ $page->updated_at->format('F j, Y') }}</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section">
    <div class="container text-center">
        <h2 class="mb-3" data-aos="fade-up">Ready to Start Your Driving Journey?</h2>
        <p class="mb-4" data-aos="fade-up" data-aos-delay="100">Book your first lesson today and take the first step towards becoming a confident driver.</p>
        <a href="{{ route('book-online') }}" class="btn btn-book btn-lg" data-aos="fade-up" data-aos-delay="200">
            <i class="fas fa-calendar-check me-2"></i>Book a Lesson
        </a>
    </div>
</section>
@endsection

@push('styles')
<style>
.page-content h2 {
    color: var(--primary-color);
    margin-top: 2rem;
    margin-bottom: 1rem;
}
.page-content h3 {
    color: var(--dark-color);
    margin-top: 1.5rem;
    margin-bottom: 0.75rem;
}
.page-content ul {
    padding-left: 1.5rem;
}
.page-content li {
    margin-bottom: 0.5rem;
}
.page-content p {
    line-height: 1.8;
    color: #555;
}
</style>
@endpush
