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
            <label class="form-label fw-700" style="color: var(--secondary-color);">Card Details</label>
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
