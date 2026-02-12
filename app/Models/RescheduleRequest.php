<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RescheduleRequest extends Model
{
    protected $fillable = [
        'booking_id',
        'customer_id',
        'original_date',
        'original_time',
        'requested_date',
        'requested_time',
        'new_slot_id',
        'reason',
        'status',
        'admin_notes',
        'processed_by',
        'processed_at',
    ];

    protected $casts = [
        'original_date' => 'date',
        'requested_date' => 'date',
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

    public function newSlot()
    {
        return $this->belongsTo(AvailabilitySlot::class, 'new_slot_id');
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
    public function approve($userId, $notes = null)
    {
        $this->status = 'approved';
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

    public function getStatusBadgeClass()
    {
        return match($this->status) {
            'pending' => 'warning',
            'approved' => 'success',
            'rejected' => 'danger',
            'cancelled' => 'secondary',
            default => 'secondary',
        };
    }
}
