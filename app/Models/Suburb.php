<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Suburb extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'postcode',
        'state',
        'latitude',
        'longitude',
        'meta_title',
        'meta_description',
        'hero_title',
        'hero_description',
        'hero_image',
        'content',
        'features',
        'local_routes_info',
        'test_center_info',
        'is_serviced',
        'travel_fee',
        'min_booking_hours',
        'show_on_map',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'features' => 'array',
        'travel_fee' => 'decimal:2',
        'is_serviced' => 'boolean',
        'show_on_map' => 'boolean',
        'is_active' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($suburb) {
            if (empty($suburb->slug)) {
                $suburb->slug = Str::slug($suburb->name);
            }
        });
    }

    // Relationships
    public function instructors()
    {
        return $this->belongsToMany(Instructor::class, 'instructor_suburb');
    }

    public function activeInstructors()
    {
        return $this->belongsToMany(Instructor::class, 'instructor_suburb')
            ->where('is_active', true);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeServiced($query)
    {
        return $query->where('is_serviced', true);
    }

    public function scopeOnMap($query)
    {
        return $query->where('show_on_map', true)
            ->whereNotNull('latitude')
            ->whereNotNull('longitude');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    // Helpers
    public function getHeroImageUrl()
    {
        if ($this->hero_image) {
            return asset('storage/' . $this->hero_image);
        }
        return null;
    }

    public function getFullName()
    {
        $parts = [$this->name];
        if ($this->postcode) {
            $parts[] = $this->postcode;
        }
        $parts[] = $this->state;
        return implode(', ', $parts);
    }

    public function getMetaTitleText()
    {
        if ($this->meta_title) {
            return $this->meta_title;
        }
        return "Driving Lessons in {$this->name} | VIP Driving School";
    }

    public function getMetaDescriptionText()
    {
        if ($this->meta_description) {
            return $this->meta_description;
        }
        return "Professional driving lessons in {$this->name}, Tasmania. Experienced instructors, flexible scheduling, and competitive rates. Book your lesson today!";
    }

    public function getHeroTitleText()
    {
        return $this->hero_title ?: "Driving Lessons in {$this->name}";
    }

    public function getHeroDescriptionText()
    {
        return $this->hero_description ?: "Professional driving instruction for learners in {$this->name} and surrounding areas.";
    }

    public function getMapCoordinates()
    {
        if ($this->latitude && $this->longitude) {
            return [
                'lat' => (float) $this->latitude,
                'lng' => (float) $this->longitude,
            ];
        }
        return null;
    }

    public function hasTravelFee()
    {
        return $this->travel_fee && $this->travel_fee > 0;
    }
}
