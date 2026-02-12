<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Location extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'address',
        'departure_info',
        'latitude',
        'longitude',
        'available_days',
        'available_days_text',
        'map_embed_code',
        'image',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'available_days' => 'array',
        'is_active' => 'boolean',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($location) {
            if (empty($location->slug)) {
                $location->slug = Str::slug($location->name);
            }
        });
    }

    public function services(): HasMany
    {
        return $this->hasMany(Service::class);
    }

    public function availabilitySlots(): HasMany
    {
        return $this->hasMany(AvailabilitySlot::class);
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    /**
     * Get formatted available days string
     */
    public function getFormattedDaysAttribute(): string
    {
        if ($this->available_days_text) {
            return $this->available_days_text;
        }

        if (!$this->available_days || empty($this->available_days)) {
            return 'Contact for Availability';
        }

        return implode(', ', $this->available_days);
    }
}
