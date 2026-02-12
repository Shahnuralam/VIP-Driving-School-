<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class GiftVoucher extends Model
{
    protected $fillable = [
        'code',
        'type',
        'amount',
        'package_id',
        'balance',
        'purchaser_name',
        'purchaser_email',
        'purchaser_phone',
        'recipient_name',
        'recipient_email',
        'message',
        'stripe_payment_intent_id',
        'stripe_charge_id',
        'payment_status',
        'paid_at',
        'status',
        'expires_at',
        'redeemed_at',
        'redeemed_by',
        'redeemed_booking_id',
        'email_sent',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'balance' => 'decimal:2',
        'paid_at' => 'datetime',
        'expires_at' => 'date',
        'redeemed_at' => 'datetime',
        'email_sent' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($voucher) {
            if (empty($voucher->code)) {
                $voucher->code = self::generateUniqueCode();
            }
            if ($voucher->type === 'fixed' && $voucher->balance == 0) {
                $voucher->balance = $voucher->amount;
            }
        });
    }

    public static function generateUniqueCode()
    {
        do {
            $code = 'VDS-' . strtoupper(Str::random(8));
        } while (self::where('code', $code)->exists());
        
        return $code;
    }

    // Relationships
    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function redeemedByCustomer()
    {
        return $this->belongsTo(Customer::class, 'redeemed_by');
    }

    public function redeemedBooking()
    {
        return $this->belongsTo(Booking::class, 'redeemed_booking_id');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active')
            ->where('payment_status', 'paid')
            ->where('expires_at', '>=', now()->toDateString());
    }

    public function scopeValid($query)
    {
        return $query->whereIn('status', ['active', 'partially_used'])
            ->where('payment_status', 'paid')
            ->where('expires_at', '>=', now()->toDateString());
    }

    // Helpers
    public function isValid()
    {
        return in_array($this->status, ['active', 'partially_used'])
            && $this->payment_status === 'paid'
            && $this->expires_at >= now()->toDateString();
    }

    public function canBeRedeemed()
    {
        if (!$this->isValid()) {
            return false;
        }
        
        if ($this->type === 'fixed') {
            return $this->balance > 0;
        }
        
        return $this->status === 'active';
    }

    public function getValueText()
    {
        if ($this->type === 'package') {
            return $this->package ? $this->package->name : 'Package Voucher';
        }
        return '$' . number_format($this->amount, 2);
    }

    public function getBalanceText()
    {
        if ($this->type === 'package') {
            return $this->status === 'active' ? 'Available' : 'Used';
        }
        return '$' . number_format($this->balance, 2);
    }

    public function useAmount($amount)
    {
        if ($this->type !== 'fixed') {
            return false;
        }
        
        $this->balance = max(0, $this->balance - $amount);
        $this->status = $this->balance > 0 ? 'partially_used' : 'fully_used';
        $this->save();
        
        return true;
    }

    public function redeem($customerId, $bookingId)
    {
        $this->redeemed_at = now();
        $this->redeemed_by = $customerId;
        $this->redeemed_booking_id = $bookingId;
        
        if ($this->type === 'package') {
            $this->status = 'fully_used';
        }
        
        $this->save();
    }

    public function getStatusBadgeClass()
    {
        return match($this->status) {
            'active' => 'success',
            'partially_used' => 'warning',
            'fully_used' => 'secondary',
            'expired' => 'danger',
            'cancelled' => 'dark',
            default => 'secondary',
        };
    }

    public function getDaysUntilExpiry()
    {
        return now()->diffInDays($this->expires_at, false);
    }
}
