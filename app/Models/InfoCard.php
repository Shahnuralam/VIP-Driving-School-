<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InfoCard extends Model
{
    protected $fillable = [
        'title',
        'content',
        'icon',
        'icon_type',
        'page',
        'section',
        'link_url',
        'link_text',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeForPage($query, string $page)
    {
        return $query->where('page', $page);
    }

    public function scopeForSection($query, string $section)
    {
        return $query->where('section', $section);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('title');
    }

    /**
     * Get icon HTML based on type
     */
    public function getIconHtmlAttribute(): string
    {
        if ($this->icon_type === 'image') {
            return '<img src="' . asset('storage/' . $this->icon) . '" alt="' . $this->title . '" class="info-card-icon">';
        }
        
        return '<i class="' . $this->icon . '"></i>';
    }
}
