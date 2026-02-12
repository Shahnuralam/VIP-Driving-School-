<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Instructor extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'email',
        'phone',
        'bio',
        'qualifications',
        'years_experience',
        'photo',
        'license_number',
        'license_expiry',
        'specializations',
        'available_days',
        'available_from',
        'available_to',
        'service_areas',
        'rating',
        'total_reviews',
        'total_lessons',
        'is_featured',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'license_expiry' => 'date',
        'specializations' => 'array',
        'available_days' => 'array',
        'service_areas' => 'array',
        'rating' => 'decimal:2',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($instructor) {
            if (empty($instructor->slug)) {
                $instructor->slug = Str::slug($instructor->name);
            }
        });
    }

    // Relationships
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function unavailabilities()
    {
        return $this->hasMany(InstructorUnavailability::class);
    }

    public function suburbs()
    {
        return $this->belongsToMany(Suburb::class, 'instructor_suburb');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    // Helpers
    public function getPhotoUrl()
    {
        if ($this->photo) {
            return asset('storage/' . $this->photo);
        }
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=1e3a5f&color=fff&size=200';
    }

    public function isAvailableOn($date)
    {
        $dayName = strtolower(date('l', strtotime($date)));
        
        // Check if day is in available days
        if (!in_array($dayName, array_map('strtolower', $this->available_days ?? []))) {
            return false;
        }
        
        // Check for unavailabilities
        return !$this->unavailabilities()
            ->where('date', $date)
            ->whereNull('start_time') // Full day block
            ->exists();
    }

    public function isAvailableAt($date, $time)
    {
        if (!$this->isAvailableOn($date)) {
            return false;
        }
        
        // Check time range
        if ($time < $this->available_from || $time > $this->available_to) {
            return false;
        }
        
        // Check for time-specific unavailabilities
        return !$this->unavailabilities()
            ->where('date', $date)
            ->where(function($q) use ($time) {
                $q->where(function($q2) use ($time) {
                    $q2->whereNotNull('start_time')
                       ->where('start_time', '<=', $time)
                       ->where('end_time', '>=', $time);
                });
            })
            ->exists();
    }

    public function updateRating()
    {
        $reviews = $this->reviews()->where('status', 'approved');
        $this->rating = $reviews->avg('instructor_rating') ?? 5.00;
        $this->total_reviews = $reviews->count();
        $this->save();
    }

    public function getSpecializationsText()
    {
        $specs = $this->specializations ?? [];
        $labels = [
            'automatic' => 'Automatic',
            'manual' => 'Manual',
            'heavy_vehicle' => 'Heavy Vehicle',
            'motorcycle' => 'Motorcycle',
            'defensive' => 'Defensive Driving',
            'test_preparation' => 'Test Preparation',
        ];
        
        return collect($specs)->map(fn($s) => $labels[$s] ?? ucfirst($s))->implode(', ');
    }
}
