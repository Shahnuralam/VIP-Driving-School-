<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Waitlist extends Model
{
    protected $fillable = [
        'customer_id',
        'service_id',
        'package_id',
        'location_id',
        'availability_slot_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'preferred_date',
        'preferred_time',
        'notes',
        'status',
        'notified_at',
        'expires_at',
    ];

    protected $casts = [
        'preferred_date' => 'date',
        'notified_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    // Relationships
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function availabilitySlot()
    {
        return $this->belongsTo(AvailabilitySlot::class);
    }

    // Scopes
    public function scopeWaiting($query)
    {
        return $query->where('status', 'waiting');
    }

    public function scopeForDate($query, $date)
    {
        return $query->where('preferred_date', $date);
    }

    public function scopeExpired($query)
    {
        return $query->where('status', 'notified')
            ->where('expires_at', '<', now());
    }

    // Helpers
    public function notify()
    {
        $this->status = 'notified';
        $this->notified_at = now();
        $this->expires_at = now()->addHours(24);
        $this->save();
    }

    public function markBooked()
    {
        $this->status = 'booked';
        $this->save();
    }

    public function markExpired()
    {
        $this->status = 'expired';
        $this->save();
    }

    public function getStatusBadgeClass()
    {
        return match($this->status) {
            'waiting' => 'warning',
            'notified' => 'info',
            'booked' => 'success',
            'expired' => 'secondary',
            'cancelled' => 'danger',
            default => 'secondary',
        };
    }
}
