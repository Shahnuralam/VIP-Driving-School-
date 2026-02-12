<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TheoryQuestion extends Model
{
    protected $fillable = [
        'theory_category_id',
        'question',
        'question_image',
        'question_type',
        'options',
        'correct_answers',
        'explanation',
        'explanation_image',
        'difficulty',
        'points',
        'times_answered',
        'times_correct',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'options' => 'array',
        'correct_answers' => 'array',
        'is_active' => 'boolean',
    ];

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

    public function scopeByDifficulty($query, $difficulty)
    {
        return $query->where('difficulty', $difficulty);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }

    // Helpers
    public function getQuestionImageUrl()
    {
        if ($this->question_image) {
            return asset('storage/' . $this->question_image);
        }
        return null;
    }

    public function getExplanationImageUrl()
    {
        if ($this->explanation_image) {
            return asset('storage/' . $this->explanation_image);
        }
        return null;
    }

    public function isCorrect($answer)
    {
        if ($this->question_type === 'multiple') {
            // For multiple choice, answer should be an array
            $answer = is_array($answer) ? $answer : [$answer];
            sort($answer);
            $correct = $this->correct_answers;
            sort($correct);
            return $answer === $correct;
        }

        // For single/true_false, check if answer matches any correct answer
        return in_array($answer, $this->correct_answers);
    }

    public function recordAnswer($isCorrect)
    {
        $this->increment('times_answered');
        if ($isCorrect) {
            $this->increment('times_correct');
        }
    }

    public function getAccuracyRate()
    {
        if ($this->times_answered === 0) {
            return 0;
        }
        return round(($this->times_correct / $this->times_answered) * 100, 1);
    }

    public function getDifficultyBadgeClass()
    {
        return match($this->difficulty) {
            'easy' => 'success',
            'medium' => 'warning',
            'hard' => 'danger',
            default => 'secondary',
        };
    }

    public function getTypeBadgeClass()
    {
        return match($this->question_type) {
            'single' => 'primary',
            'multiple' => 'info',
            'true_false' => 'secondary',
            default => 'secondary',
        };
    }

    public function getTypeLabel()
    {
        return match($this->question_type) {
            'single' => 'Single Choice',
            'multiple' => 'Multiple Choice',
            'true_false' => 'True/False',
            default => 'Unknown',
        };
    }
}
