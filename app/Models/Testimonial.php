<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $fillable = [
        'customer_name',
        'customer_location',
        'customer_image',
        'content',
        'rating',
        'service_type',
        'date',
        'is_featured',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'date' => 'date',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];

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
        return $query->orderBy('sort_order')->orderByDesc('date');
    }

    /**
     * Get star rating HTML
     */
    public function getStarsHtmlAttribute(): string
    {
        $stars = '';
        for ($i = 1; $i <= 5; $i++) {
            $class = $i <= $this->rating ? 'fas fa-star text-warning' : 'far fa-star text-muted';
            $stars .= '<i class="' . $class . '"></i>';
        }
        return $stars;
    }
}
