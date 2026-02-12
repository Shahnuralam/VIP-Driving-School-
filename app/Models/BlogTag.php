<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BlogTag extends Model
{
    protected $fillable = [
        'name',
        'slug',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($tag) {
            if (empty($tag->slug)) {
                $tag->slug = Str::slug($tag->name);
            }
        });
    }

    // Relationships
    public function posts()
    {
        return $this->belongsToMany(BlogPost::class, 'blog_post_tag');
    }

    public function publishedPosts()
    {
        return $this->belongsToMany(BlogPost::class, 'blog_post_tag')
            ->where('status', 'published')
            ->where('published_at', '<=', now());
    }

    // Static helper to find or create tag
    public static function findOrCreateByName($name)
    {
        $slug = Str::slug($name);
        return static::firstOrCreate(
            ['slug' => $slug],
            ['name' => $name]
        );
    }
}
