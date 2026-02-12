<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use Carbon\Carbon;

class Booking extends Model
{
    protected $fillable = [
        'booking_reference',
        'customer_id',
        'instructor_id',
        'service_id',
        'package_id',
        'location_id',
        'availability_slot_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'customer_license',
        'customer_address',
        'pickup_address',
        'booking_date',
        'booking_time',
        'transmission_type',
        'status',
        'amount',
        'coupon_id',
        'discount_amount',
        'original_amount',
        'gift_voucher_id',
        'voucher_amount_used',
        'parent_booking_id',
        'is_recurring',
        'recurring_frequency',
        'recurring_count',
        'payment_status',
        'stripe_payment_intent_id',
        'stripe_charge_id',
        'paid_at',
        'notes',
        'admin_notes',
        'review_requested',
        'review_requested_at',
        'booking_source',
        'utm_source',
        'utm_medium',
        'utm_campaign',
        'cancellation_reason',
        'cancelled_at',
    ];

    protected $casts = [
        'booking_date' => 'date',
        'booking_time' => 'datetime:H:i',
        'amount' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'original_amount' => 'decimal:2',
        'voucher_amount_used' => 'decimal:2',
        'is_recurring' => 'boolean',
        'review_requested' => 'boolean',
        'review_requested_at' => 'datetime',
        'paid_at' => 'datetime',
        'cancelled_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($booking) {
            if (empty($booking->booking_reference)) {
                $booking->booking_reference = static::generateReference();
            }
        });
    }

    /**
     * Generate a unique booking reference
     */
    public static function generateReference(): string
    {
        do {
            $reference = 'VDS-' . strtoupper(Str::random(8));
        } while (static::where('booking_reference', $reference)->exists());

        return $reference;
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function availabilitySlot(): BelongsTo
    {
        return $this->belongsTo(AvailabilitySlot::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function instructor(): BelongsTo
    {
        return $this->belongsTo(Instructor::class);
    }

    public function coupon(): BelongsTo
    {
        return $this->belongsTo(Coupon::class);
    }

    public function giftVoucher(): BelongsTo
    {
        return $this->belongsTo(GiftVoucher::class);
    }

    public function parentBooking(): BelongsTo
    {
        return $this->belongsTo(Booking::class, 'parent_booking_id');
    }

    public function childBookings()
    {
        return $this->hasMany(Booking::class, 'parent_booking_id');
    }

    public function review()
    {
        return $this->hasOne(Review::class);
    }

    public function rescheduleRequests()
    {
        return $this->hasMany(RescheduleRequest::class);
    }

    public function cancellationRequest()
    {
        return $this->hasOne(CancellationRequest::class);
    }

    // Status scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    // Payment scopes
    public function scopePaid($query)
    {
        return $query->where('payment_status', 'paid');
    }

    public function scopeUnpaid($query)
    {
        return $query->where('payment_status', 'pending');
    }

    // Date scopes
    public function scopeForDate($query, $date)
    {
        return $query->whereDate('booking_date', $date);
    }

    public function scopeUpcoming($query)
    {
        return $query->where('booking_date', '>=', Carbon::today())
            ->whereIn('status', ['pending', 'confirmed']);
    }

    public function scopeToday($query)
    {
        return $query->whereDate('booking_date', Carbon::today());
    }

    public function scopeThisWeek($query)
    {
        return $query->whereBetween('booking_date', [
            Carbon::now()->startOfWeek(),
            Carbon::now()->endOfWeek(),
        ]);
    }

    public function scopeThisMonth($query)
    {
        return $query->whereMonth('booking_date', Carbon::now()->month)
            ->whereYear('booking_date', Carbon::now()->year);
    }

    /**
     * Check if booking can be cancelled
     */
    public function canBeCancelled(): bool
    {
        return in_array($this->status, ['pending', 'confirmed']) 
            && $this->booking_date >= Carbon::today();
    }

    /**
     * Cancel the booking
     */
    public function cancel(?string $reason = null): void
    {
        $this->update([
            'status' => 'cancelled',
            'cancellation_reason' => $reason,
            'cancelled_at' => now(),
        ]);

        // Decrement slot booking count if applicable
        if ($this->availabilitySlot) {
            $this->availabilitySlot->decrementBookings();
        }
    }

    /**
     * Confirm the booking
     */
    public function confirm(): void
    {
        $this->update(['status' => 'confirmed']);
    }

    /**
     * Mark as completed
     */
    public function markAsCompleted(): void
    {
        $this->update(['status' => 'completed']);
    }

    /**
     * Get formatted amount
     */
    public function getFormattedAmountAttribute(): string
    {
        return '$' . number_format($this->amount, 2);
    }

    /**
     * Get status badge class
     */
    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'pending' => 'warning',
            'confirmed' => 'info',
            'completed' => 'success',
            'cancelled' => 'danger',
            'no_show' => 'secondary',
            default => 'secondary',
        };
    }

    /**
     * Get payment status badge class
     */
    public function getPaymentBadgeAttribute(): string
    {
        return match($this->payment_status) {
            'pending' => 'warning',
            'paid' => 'success',
            'refunded' => 'info',
            'failed' => 'danger',
            default => 'secondary',
        };
    }

    /**
     * Get formatted booking datetime
     */
    public function getFormattedDateTimeAttribute(): string
    {
        return $this->booking_date->format('D, M j, Y') . ' at ' . 
               Carbon::parse($this->booking_time)->format('g:i A');
    }

    /**
     * Check if customer can leave a review
     */
    public function canBeReviewed(): bool
    {
        return $this->status === 'completed' && !$this->review()->exists();
    }

    /**
     * Request review from customer
     */
    public function requestReview(): void
    {
        $this->update([
            'review_requested' => true,
            'review_requested_at' => now(),
        ]);
    }

    /**
     * Check if booking can be rescheduled
     */
    public function canBeRescheduled(): bool
    {
        return in_array($this->status, ['pending', 'confirmed'])
            && $this->booking_date > Carbon::today();
    }

    /**
     * Get the final amount after discounts
     */
    public function getFinalAmount(): float
    {
        return $this->amount - $this->discount_amount - $this->voucher_amount_used;
    }

    /**
     * Get total savings
     */
    public function getTotalSavings(): float
    {
        return $this->discount_amount + $this->voucher_amount_used;
    }
}
