<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class TheoryResource extends Model
{
    protected $fillable = [
        'theory_category_id',
        'title',
        'slug',
        'description',
        'type',
        'content',
        'video_url',
        'file_path',
        'external_url',
        'thumbnail',
        'duration_minutes',
        'views_count',
        'is_featured',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($resource) {
            if (empty($resource->slug)) {
                $resource->slug = Str::slug($resource->title);
            }
        });
    }

    // Relationships
    public function category()
    {
        return $this->belongsTo(TheoryCategory::class, 'theory_category_id');
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

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('title');
    }

    // Helpers
    public function getThumbnailUrl()
    {
        if ($this->thumbnail) {
            return asset('storage/' . $this->thumbnail);
        }
        
        // Default thumbnail based on type
        return match($this->type) {
            'video' => 'https://via.placeholder.com/320x180?text=Video',
            'pdf' => 'https://via.placeholder.com/320x180?text=PDF',
            'article' => 'https://via.placeholder.com/320x180?text=Article',
            default => 'https://via.placeholder.com/320x180?text=Resource',
        };
    }

    public function getFileUrl()
    {
        if ($this->file_path) {
            return asset('storage/' . $this->file_path);
        }
        return null;
    }

    public function getUrl()
    {
        if ($this->type === 'link' && $this->external_url) {
            return $this->external_url;
        }
        return route('theory.resource', $this->slug);
    }

    public function incrementViews()
    {
        $this->increment('views_count');
    }

    public function getDurationFormatted()
    {
        if (!$this->duration_minutes) {
            return null;
        }

        if ($this->duration_minutes < 60) {
            return $this->duration_minutes . ' min';
        }

        $hours = floor($this->duration_minutes / 60);
        $minutes = $this->duration_minutes % 60;
        return "{$hours}h {$minutes}m";
    }

    public function getTypeIcon()
    {
        return match($this->type) {
            'article' => 'fas fa-file-alt',
            'video' => 'fas fa-video',
            'pdf' => 'fas fa-file-pdf',
            'link' => 'fas fa-external-link-alt',
            default => 'fas fa-file',
        };
    }

    public function getTypeBadgeClass()
    {
        return match($this->type) {
            'article' => 'primary',
            'video' => 'danger',
            'pdf' => 'warning',
            'link' => 'info',
            default => 'secondary',
        };
    }
}
