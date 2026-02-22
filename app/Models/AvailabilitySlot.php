<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class AvailabilitySlot extends Model
{
    protected $fillable = [
        'service_id',
        'location_id',
        'date',
        'start_time',
        'end_time',
        'max_bookings',
        'current_bookings',
        'is_available',
        'is_blocked',
        'notes',
        'instructor_id',
        'pattern_type',
    ];

    protected $casts = [
        'date' => 'date',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
        'is_available' => 'boolean',
        'is_blocked' => 'boolean',
    ];

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function instructor(): BelongsTo
    {
        return $this->belongsTo(Instructor::class);
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function scopeAvailable($query)
    {
        return $query->where('is_available', true)
            ->where('is_blocked', false)
            ->whereColumn('current_bookings', '<', 'max_bookings');
    }

    public function scopeForDate($query, $date)
    {
        return $query->whereDate('date', $date);
    }

    public function scopeFuture($query)
    {
        return $query->where('date', '>=', Carbon::today());
    }

    public function scopeByService($query, $serviceId)
    {
        return $query->where('service_id', $serviceId);
    }

    public function scopeByLocation($query, $locationId)
    {
        return $query->where('location_id', $locationId);
    }

    /**
     * Check if slot has availability
     */
    public function hasAvailability(): bool
    {
        return $this->is_available 
            && !$this->is_blocked 
            && $this->current_bookings < $this->max_bookings;
    }

    /**
     * Check if slot is full
     */
    public function isFull(): bool
    {
        return $this->current_bookings >= $this->max_bookings;
    }

    /**
     * Get remaining spots
     */
    public function getRemainingAttribute(): int
    {
        return max(0, $this->max_bookings - $this->current_bookings);
    }

    /**
     * Increment booking count
     */
    public function incrementBookings(): void
    {
        $this->increment('current_bookings');
    }

    /**
     * Decrement booking count
     */
    public function decrementBookings(): void
    {
        if ($this->current_bookings > 0) {
            $this->decrement('current_bookings');
        }
    }

    /**
     * Get formatted time range
     */
    public function getTimeRangeAttribute(): string
    {
        return Carbon::parse($this->start_time)->format('g:i A') . ' - ' . 
               Carbon::parse($this->end_time)->format('g:i A');
    }
}
