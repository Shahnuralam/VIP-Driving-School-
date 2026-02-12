<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Page extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'meta_description',
        'meta_keywords',
        'content',
        'featured_image',
        'is_active',
        'show_in_navbar',
        'show_in_footer',
        'navbar_order',
        'footer_order',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'show_in_navbar' => 'boolean',
        'show_in_footer' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($page) {
            if (empty($page->slug)) {
                $page->slug = Str::slug($page->title);
            }
        });
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('title');
    }

    public function scopeInNavbar($query)
    {
        return $query->where('show_in_navbar', true)->orderBy('navbar_order');
    }

    public function scopeInFooter($query)
    {
        return $query->where('show_in_footer', true)->orderBy('footer_order');
    }
}
