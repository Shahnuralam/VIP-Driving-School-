<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BlogPost extends Model
{
    protected $fillable = [
        'blog_category_id',
        'author_id',
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'featured_image_alt',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'canonical_url',
        'status',
        'published_at',
        'scheduled_at',
        'views_count',
        'comments_count',
        'reading_time',
        'allow_comments',
        'is_featured',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'scheduled_at' => 'datetime',
        'allow_comments' => 'boolean',
        'is_featured' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($post) {
            if (empty($post->slug)) {
                $post->slug = Str::slug($post->title);
            }
            if (empty($post->reading_time)) {
                $post->reading_time = self::calculateReadingTime($post->content);
            }
        });

        static::updating(function ($post) {
            if ($post->isDirty('content')) {
                $post->reading_time = self::calculateReadingTime($post->content);
            }
        });
    }

    public static function calculateReadingTime($content)
    {
        $wordCount = str_word_count(strip_tags($content));
        return max(1, ceil($wordCount / 200)); // 200 words per minute
    }

    // Relationships
    public function category()
    {
        return $this->belongsTo(BlogCategory::class, 'blog_category_id');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function tags()
    {
        return $this->belongsToMany(BlogTag::class, 'blog_post_tag');
    }

    public function comments()
    {
        return $this->hasMany(BlogComment::class);
    }

    public function approvedComments()
    {
        return $this->hasMany(BlogComment::class)->where('status', 'approved');
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('status', 'published')
            ->where('published_at', '<=', now());
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeRecent($query)
    {
        return $query->orderByDesc('published_at');
    }

    public function scopeByCategory($query, $categorySlug)
    {
        return $query->whereHas('category', function($q) use ($categorySlug) {
            $q->where('slug', $categorySlug);
        });
    }

    public function scopeByTag($query, $tagSlug)
    {
        return $query->whereHas('tags', function($q) use ($tagSlug) {
            $q->where('slug', $tagSlug);
        });
    }

    // Helpers
    public function isPublished()
    {
        return $this->status === 'published' && $this->published_at <= now();
    }

    public function publish()
    {
        $this->status = 'published';
        $this->published_at = now();
        $this->scheduled_at = null;
        $this->save();
    }

    public function unpublish()
    {
        $this->status = 'draft';
        $this->save();
    }

    public function incrementViews()
    {
        $this->increment('views_count');
    }

    public function syncTags($tagNames)
    {
        $tagIds = [];
        foreach ($tagNames as $name) {
            $tag = BlogTag::findOrCreateByName(trim($name));
            $tagIds[] = $tag->id;
        }
        $this->tags()->sync($tagIds);
    }

    public function getTagsString()
    {
        return $this->tags->pluck('name')->implode(', ');
    }

    public function getFeaturedImageUrl()
    {
        if ($this->featured_image) {
            return asset('storage/' . $this->featured_image);
        }
        return null;
    }

    public function getExcerptText($length = 150)
    {
        if ($this->excerpt) {
            return $this->excerpt;
        }
        return Str::limit(strip_tags($this->content), $length);
    }

    public function getMetaTitleText()
    {
        return $this->meta_title ?: $this->title;
    }

    public function getMetaDescriptionText()
    {
        return $this->meta_description ?: $this->getExcerptText(160);
    }

    public function getRelatedPosts($limit = 3)
    {
        return self::published()
            ->where('id', '!=', $this->id)
            ->where(function($q) {
                $q->where('blog_category_id', $this->blog_category_id)
                  ->orWhereHas('tags', function($q2) {
                      $q2->whereIn('blog_tags.id', $this->tags->pluck('id'));
                  });
            })
            ->recent()
            ->limit($limit)
            ->get();
    }

    public function getStatusBadgeClass()
    {
        return match($this->status) {
            'draft' => 'secondary',
            'scheduled' => 'info',
            'published' => 'success',
            default => 'secondary',
        };
    }
}
