<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class TheoryCategory extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
        'image',
        'questions_count',
        'pass_percentage',
        'time_limit_minutes',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    // Relationships
    public function questions()
    {
        return $this->hasMany(TheoryQuestion::class);
    }

    public function activeQuestions()
    {
        return $this->hasMany(TheoryQuestion::class)->where('is_active', true);
    }

    public function attempts()
    {
        return $this->hasMany(TheoryAttempt::class);
    }

    public function resources()
    {
        return $this->hasMany(TheoryResource::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    // Helpers
    public function getImageUrl()
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }
        return null;
    }

    public function updateQuestionsCount()
    {
        $this->questions_count = $this->activeQuestions()->count();
        $this->save();
    }

    public function getRandomQuestions($limit = null)
    {
        $query = $this->activeQuestions()->inRandomOrder();
        
        if ($limit) {
            $query->limit($limit);
        }
        
        return $query->get();
    }

    public function getAverageScore()
    {
        return $this->attempts()
            ->whereNotNull('completed_at')
            ->avg('score_percentage') ?? 0;
    }

    public function getPassRate()
    {
        $completed = $this->attempts()->whereNotNull('completed_at');
        $total = $completed->count();
        
        if ($total === 0) return 0;
        
        $passed = $completed->where('passed', true)->count();
        return round(($passed / $total) * 100, 1);
    }
}
