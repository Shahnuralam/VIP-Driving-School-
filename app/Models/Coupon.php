<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Coupon extends Model
{
    protected $fillable = [
        'code',
        'name',
        'description',
        'type',
        'value',
        'min_order_amount',
        'max_discount_amount',
        'applicable_services',
        'applicable_packages',
        'applicable_locations',
        'first_booking_only',
        'usage_limit',
        'usage_limit_per_customer',
        'times_used',
        'starts_at',
        'expires_at',
        'is_active',
    ];

    protected $casts = [
        'value' => 'decimal:2',
        'min_order_amount' => 'decimal:2',
        'max_discount_amount' => 'decimal:2',
        'applicable_services' => 'array',
        'applicable_packages' => 'array',
        'applicable_locations' => 'array',
        'first_booking_only' => 'boolean',
        'starts_at' => 'datetime',
        'expires_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($coupon) {
            $coupon->code = strtoupper($coupon->code);
        });
    }

    // Relationships
    public function usages()
    {
        return $this->hasMany(CouponUsage::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeValid($query)
    {
        return $query->where('is_active', true)
            ->where(function($q) {
                $q->whereNull('starts_at')->orWhere('starts_at', '<=', now());
            })
            ->where(function($q) {
                $q->whereNull('expires_at')->orWhere('expires_at', '>=', now());
            })
            ->where(function($q) {
                $q->whereNull('usage_limit')->orWhereRaw('times_used < usage_limit');
            });
    }

    // Validation
    public function isValid()
    {
        if (!$this->is_active) {
            return ['valid' => false, 'message' => 'This coupon is not active.'];
        }

        if ($this->starts_at && $this->starts_at > now()) {
            return ['valid' => false, 'message' => 'This coupon is not yet active.'];
        }

        if ($this->expires_at && $this->expires_at < now()) {
            return ['valid' => false, 'message' => 'This coupon has expired.'];
        }

        if ($this->usage_limit && $this->times_used >= $this->usage_limit) {
            return ['valid' => false, 'message' => 'This coupon has reached its usage limit.'];
        }

        return ['valid' => true, 'message' => ''];
    }

    public function canBeUsedBy($customerEmail, $customerId = null)
    {
        $validation = $this->isValid();
        if (!$validation['valid']) {
            return $validation;
        }

        // Check per-customer limit
        $usageCount = $this->usages()
            ->where(function($q) use ($customerEmail, $customerId) {
                $q->where('customer_email', $customerEmail);
                if ($customerId) {
                    $q->orWhere('customer_id', $customerId);
                }
            })
            ->count();

        if ($usageCount >= $this->usage_limit_per_customer) {
            return ['valid' => false, 'message' => 'You have already used this coupon.'];
        }

        // Check first booking only
        if ($this->first_booking_only) {
            $hasBookings = Booking::where(function($q) use ($customerEmail, $customerId) {
                $q->where('customer_email', $customerEmail);
                if ($customerId) {
                    $q->orWhere('customer_id', $customerId);
                }
            })->where('payment_status', 'paid')->exists();

            if ($hasBookings) {
                return ['valid' => false, 'message' => 'This coupon is only for first-time bookings.'];
            }
        }

        return ['valid' => true, 'message' => ''];
    }

    public function isApplicableTo($serviceId = null, $packageId = null, $locationId = null)
    {
        // If no restrictions, applicable to all
        if (empty($this->applicable_services) && empty($this->applicable_packages) && empty($this->applicable_locations)) {
            return true;
        }

        if (!empty($this->applicable_services) && $serviceId && !in_array($serviceId, $this->applicable_services)) {
            return false;
        }

        if (!empty($this->applicable_packages) && $packageId && !in_array($packageId, $this->applicable_packages)) {
            return false;
        }

        if (!empty($this->applicable_locations) && $locationId && !in_array($locationId, $this->applicable_locations)) {
            return false;
        }

        return true;
    }

    // Calculate discount
    public function calculateDiscount($amount)
    {
        if ($this->min_order_amount && $amount < $this->min_order_amount) {
            return 0;
        }

        $discount = 0;
        if ($this->type === 'percentage') {
            $discount = $amount * ($this->value / 100);
            if ($this->max_discount_amount) {
                $discount = min($discount, $this->max_discount_amount);
            }
        } else {
            $discount = min($this->value, $amount);
        }

        return round($discount, 2);
    }

    public function recordUsage($bookingId, $customerEmail, $customerId, $discountAmount)
    {
        $this->usages()->create([
            'booking_id' => $bookingId,
            'customer_email' => $customerEmail,
            'customer_id' => $customerId,
            'discount_amount' => $discountAmount,
        ]);

        $this->increment('times_used');
    }

    public function getDiscountText()
    {
        if ($this->type === 'percentage') {
            return $this->value . '% off';
        }
        return '$' . number_format($this->value, 2) . ' off';
    }
}
