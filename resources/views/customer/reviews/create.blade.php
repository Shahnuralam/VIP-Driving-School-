@extends('customer.layouts.app')

@section('title', 'Write a Review')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <a href="{{ route('customer.bookings.show', $booking) }}" class="text-decoration-none">
            <i class="fas fa-arrow-left me-2"></i>Back to Booking
        </a>
        <h4 class="mt-2 mb-0"><i class="fas fa-star text-warning me-2"></i>Write a Review</h4>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <!-- Booking Summary -->
        <div class="card mb-4">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="bg-primary text-white rounded-circle p-3 me-3">
                        <i class="fas fa-car fa-lg"></i>
                    </div>
                    <div>
                        <h5 class="mb-1">{{ $booking->service->name ?? $booking->package->name ?? 'Driving Lesson' }}</h5>
                        <p class="text-muted mb-0">
                            {{ $booking->booking_date->format('F j, Y') }} 
                            @if($booking->instructor)
                            with {{ $booking->instructor->name }}
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Review Form -->
        <div class="card">
            <div class="card-body p-4">
                <form action="{{ route('customer.reviews.store', $booking) }}" method="POST">
                    @csrf

                    <!-- Overall Rating -->
                    <div class="mb-4">
                        <label class="form-label fw-bold">Overall Rating <span class="text-danger">*</span></label>
                        <div class="star-rating d-flex gap-2" id="overall_rating_stars">
                            @for($i = 1; $i <= 5; $i++)
                            <label class="star-label">
                                <input type="radio" name="overall_rating" value="{{ $i }}" class="d-none" {{ old('overall_rating') == $i ? 'checked' : '' }}>
                                <i class="fas fa-star fa-2x text-muted star-icon" data-rating="{{ $i }}"></i>
                            </label>
                            @endfor
                        </div>
                        @error('overall_rating')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Detailed Ratings -->
                    <div class="row mb-4">
                        @if($booking->instructor)
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Instructor</label>
                            <select name="instructor_rating" class="form-select">
                                <option value="">Select</option>
                                @for($i = 5; $i >= 1; $i--)
                                <option value="{{ $i }}" {{ old('instructor_rating') == $i ? 'selected' : '' }}>{{ $i }} Star{{ $i > 1 ? 's' : '' }}</option>
                                @endfor
                            </select>
                        </div>
                        @endif
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Vehicle</label>
                            <select name="vehicle_rating" class="form-select">
                                <option value="">Select</option>
                                @for($i = 5; $i >= 1; $i--)
                                <option value="{{ $i }}" {{ old('vehicle_rating') == $i ? 'selected' : '' }}>{{ $i }} Star{{ $i > 1 ? 's' : '' }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Value for Money</label>
                            <select name="value_rating" class="form-select">
                                <option value="">Select</option>
                                @for($i = 5; $i >= 1; $i--)
                                <option value="{{ $i }}" {{ old('value_rating') == $i ? 'selected' : '' }}>{{ $i }} Star{{ $i > 1 ? 's' : '' }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    <!-- Review Title -->
                    <div class="mb-3">
                        <label for="title" class="form-label">Review Title (optional)</label>
                        <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" 
                               value="{{ old('title') }}" placeholder="Summarize your experience">
                        @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Review Content -->
                    <div class="mb-4">
                        <label for="content" class="form-label fw-bold">Your Review <span class="text-danger">*</span></label>
                        <textarea name="content" id="content" rows="5" 
                                  class="form-control @error('content') is-invalid @enderror" 
                                  placeholder="Share your experience with us. What did you like? What could be improved?"
                                  required>{{ old('content') }}</textarea>
                        @error('content')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Minimum 10 characters</small>
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <a href="{{ route('customer.bookings.show', $booking) }}" class="btn btn-outline-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane me-2"></i>Submit Review
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .star-rating .star-icon {
        cursor: pointer;
        transition: all 0.2s;
    }
    .star-rating .star-icon:hover,
    .star-rating .star-icon.active {
        color: #ffc107 !important;
        transform: scale(1.1);
    }
</style>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const stars = document.querySelectorAll('.star-icon');
    
    stars.forEach(star => {
        star.addEventListener('click', function() {
            const rating = this.dataset.rating;
            const input = this.previousElementSibling;
            input.checked = true;
            
            // Update visual
            stars.forEach(s => {
                if (parseInt(s.dataset.rating) <= rating) {
                    s.classList.add('active');
                    s.classList.remove('text-muted');
                } else {
                    s.classList.remove('active');
                    s.classList.add('text-muted');
                }
            });
        });
        
        star.addEventListener('mouseenter', function() {
            const rating = this.dataset.rating;
            stars.forEach(s => {
                if (parseInt(s.dataset.rating) <= rating) {
                    s.style.color = '#ffc107';
                }
            });
        });
        
        star.addEventListener('mouseleave', function() {
            stars.forEach(s => {
                if (!s.classList.contains('active')) {
                    s.style.color = '';
                }
            });
        });
    });
});
</script>
@endsection
