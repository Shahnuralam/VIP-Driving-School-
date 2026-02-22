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
    <div class="container" data-aos="fade-up">
        <span class="section-tag" style="color: var(--primary-color);">Information</span>
        <h1>{{ $page->title }}</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('frontend.home') }}">Home</a></li>
                <li class="breadcrumb-item active">{{ $page->title }}</li>
            </ol>
        </nav>
    </div>
</section>

<!-- Page Content -->
<section class="section-padding bg-slate-50">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <div class="bg-white p-5 rounded-4 shadow-sm border border-slate-100" data-aos="fade-up">
                    @if($page->featured_image)
                    <div class="mb-5">
                        <img src="{{ asset('storage/' . $page->featured_image) }}" alt="{{ $page->title }}" class="img-fluid rounded-4 shadow-sm">
                    </div>
                    @endif
                    
                    <div class="page-content">
                        {!! $page->content !!}
                    </div>

                    <div class="mt-5 pt-4 border-top text-center">
                        <p class="text-muted small mb-0">Last updated: {{ $page->updated_at->format('F j, Y') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

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

@push('styles')
<style>
.page-content {
    color: var(--slate-700);
    line-height: 1.8;
}
.page-content h2 {
    color: var(--secondary-color);
    font-weight: 800;
    margin-top: 2.5rem;
    margin-bottom: 1.25rem;
}
.page-content h3 {
    color: var(--secondary-color);
    font-weight: 700;
    margin-top: 2rem;
    margin-bottom: 1rem;
}
.page-content p {
    margin-bottom: 1.5rem;
}
.page-content ul, .page-content ol {
    margin-bottom: 1.5rem;
    padding-left: 1.5rem;
}
.page-content li {
    margin-bottom: 0.75rem;
}
.page-content a {
    color: var(--primary-color);
    text-decoration: underline;
    font-weight: 600;
}
.page-content img {
    border-radius: 12px;
    margin-bottom: 1.5rem;
}
</style>
@endpush
