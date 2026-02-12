@extends('adminlte::page')

@section('title', 'Booking Details')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Booking: {{ $booking->booking_reference }}</h1>
        <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to List
        </a>
    </div>
@stop

@section('content')
<div class="row">
    <div class="col-md-8">
        <!-- Customer Info -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-user mr-2"></i>Customer Information</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Name:</strong> {{ $booking->customer_name }}</p>
                        <p><strong>Email:</strong> <a href="mailto:{{ $booking->customer_email }}">{{ $booking->customer_email }}</a></p>
                        <p><strong>Phone:</strong> <a href="tel:{{ $booking->customer_phone }}">{{ $booking->customer_phone }}</a></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>License:</strong> {{ $booking->customer_license ?? 'N/A' }}</p>
                        <p><strong>Address:</strong> {{ $booking->customer_address ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Booking Details -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-calendar-check mr-2"></i>Booking Details</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Service:</strong> {{ $booking->service?->name ?? 'Package Booking' }}</p>
                        @if($booking->package)
                            <p><strong>Package:</strong> {{ $booking->package->name }}</p>
                        @endif
                        <p><strong>Location:</strong> {{ $booking->location?->name ?? 'N/A' }}</p>
                        <p><strong>Transmission:</strong> {{ ucfirst($booking->transmission_type) }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Date:</strong> {{ $booking->booking_date->format('l, F j, Y') }}</p>
                        <p><strong>Time:</strong> {{ \Carbon\Carbon::parse($booking->booking_time)->format('g:i A') }}</p>
                        <p><strong>Booked At:</strong> {{ $booking->created_at->format('M j, Y g:i A') }}</p>
                    </div>
                </div>
                @if($booking->notes)
                    <hr>
                    <p><strong>Customer Notes:</strong></p>
                    <p class="text-muted">{{ $booking->notes }}</p>
                @endif
            </div>
        </div>

        <!-- Admin Notes -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-sticky-note mr-2"></i>Admin Notes</h3>
            </div>
            <div class="card-body">
                <p class="text-muted">{{ $booking->admin_notes ?? 'No admin notes yet.' }}</p>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <!-- Status Card -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-info-circle mr-2"></i>Status</h3>
            </div>
            <div class="card-body">
                <div class="text-center mb-3">
                    <span class="badge badge-{{ $booking->status_badge }} badge-lg p-2" style="font-size: 1.2rem;">
                        {{ ucfirst($booking->status) }}
                    </span>
                </div>
                <hr>
                <p><strong>Payment Status:</strong> 
                    <span class="badge badge-{{ $booking->payment_badge }}">{{ ucfirst($booking->payment_status) }}</span>
                </p>
                <p><strong>Amount:</strong> <span class="h4 text-success">{{ $booking->formatted_amount }}</span></p>
                @if($booking->paid_at)
                    <p><strong>Paid At:</strong> {{ $booking->paid_at->format('M j, Y g:i A') }}</p>
                @endif
                @if($booking->stripe_payment_intent_id)
                    <p><strong>Stripe ID:</strong> <code>{{ $booking->stripe_payment_intent_id }}</code></p>
                @endif
            </div>
        </div>

        <!-- Update Status Form -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-edit mr-2"></i>Update Status</h3>
            </div>
            <form action="{{ route('admin.bookings.update-status', $booking) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="card-body">
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select name="status" id="status" class="form-control">
                            <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="confirmed" {{ $booking->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                            <option value="completed" {{ $booking->status == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            <option value="no_show" {{ $booking->status == 'no_show' ? 'selected' : '' }}>No Show</option>
                        </select>
                    </div>

                    <div class="form-group" id="cancellation-reason-group" style="{{ $booking->status == 'cancelled' ? '' : 'display: none;' }}">
                        <label for="cancellation_reason">Cancellation Reason</label>
                        <textarea name="cancellation_reason" id="cancellation_reason" rows="2" class="form-control">{{ $booking->cancellation_reason }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="admin_notes">Admin Notes</label>
                        <textarea name="admin_notes" id="admin_notes" rows="3" class="form-control">{{ $booking->admin_notes }}</textarea>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary btn-block">
                        <i class="fas fa-save"></i> Update Status
                    </button>
                </div>
            </form>
        </div>

        @if($booking->status === 'cancelled')
        <!-- Delete Option -->
        <div class="card border-danger">
            <div class="card-header bg-danger text-white">
                <h3 class="card-title"><i class="fas fa-trash mr-2"></i>Delete Booking</h3>
            </div>
            <div class="card-body">
                <p class="text-muted">This action cannot be undone. Only cancelled bookings can be deleted.</p>
                <form action="{{ route('admin.bookings.destroy', $booking) }}" method="POST" onsubmit="return confirm('Are you sure you want to permanently delete this booking?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-block">
                        <i class="fas fa-trash"></i> Delete Permanently
                    </button>
                </form>
            </div>
        </div>
        @endif
    </div>
</div>
@stop

@section('js')
<script>
document.getElementById('status').addEventListener('change', function() {
    var reasonGroup = document.getElementById('cancellation-reason-group');
    if (this.value === 'cancelled') {
        reasonGroup.style.display = 'block';
    } else {
        reasonGroup.style.display = 'none';
    }
});
</script>
@stop
