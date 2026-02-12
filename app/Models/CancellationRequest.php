<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CancellationRequest extends Model
{
    protected $fillable = [
        'booking_id',
        'customer_id',
        'reason',
        'refund_type',
        'refund_amount',
        'status',
        'stripe_refund_id',
        'admin_notes',
        'processed_by',
        'processed_at',
    ];

    protected $casts = [
        'refund_amount' => 'decimal:2',
        'processed_at' => 'datetime',
    ];

    // Relationships
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function processedBy()
    {
        return $this->belongsTo(User::class, 'processed_by');
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    // Helpers
    public function approve($userId, $refundType, $refundAmount = null, $notes = null)
    {
        $this->status = 'approved';
        $this->refund_type = $refundType;
        $this->refund_amount = $refundAmount;
        $this->processed_by = $userId;
        $this->processed_at = now();
        $this->admin_notes = $notes;
        $this->save();
    }

    public function reject($userId, $notes = null)
    {
        $this->status = 'rejected';
        $this->processed_by = $userId;
        $this->processed_at = now();
        $this->admin_notes = $notes;
        $this->save();
    }

    public function markRefunded($stripeRefundId)
    {
        $this->status = 'refunded';
        $this->stripe_refund_id = $stripeRefundId;
        $this->save();
    }

    public function getStatusBadgeClass()
    {
        return match($this->status) {
            'pending' => 'warning',
            'approved' => 'info',
            'rejected' => 'danger',
            'refunded' => 'success',
            default => 'secondary',
        };
    }

    public function getRefundTypeBadgeClass()
    {
        return match($this->refund_type) {
            'full' => 'success',
            'partial' => 'warning',
            'credit' => 'info',
            'none' => 'secondary',
            default => 'secondary',
        };
    }
}
