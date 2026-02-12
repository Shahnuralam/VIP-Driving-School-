<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TheoryAttempt extends Model
{
    protected $fillable = [
        'theory_category_id',
        'customer_id',
        'session_id',
        'ip_address',
        'total_questions',
        'correct_answers',
        'wrong_answers',
        'skipped_questions',
        'score_percentage',
        'passed',
        'time_taken_seconds',
        'answers',
        'started_at',
        'completed_at',
    ];

    protected $casts = [
        'score_percentage' => 'decimal:2',
        'passed' => 'boolean',
        'answers' => 'array',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    // Relationships
    public function category()
    {
        return $this->belongsTo(TheoryCategory::class, 'theory_category_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    // Scopes
    public function scopeCompleted($query)
    {
        return $query->whereNotNull('completed_at');
    }

    public function scopePassed($query)
    {
        return $query->where('passed', true);
    }

    public function scopeByCustomer($query, $customerId)
    {
        return $query->where('customer_id', $customerId);
    }

    public function scopeBySession($query, $sessionId)
    {
        return $query->where('session_id', $sessionId);
    }

    // Helpers
    public function isCompleted()
    {
        return !is_null($this->completed_at);
    }

    public function complete()
    {
        $this->completed_at = now();
        $this->time_taken_seconds = $this->started_at->diffInSeconds(now());
        $this->calculateScore();
        $this->save();
    }

    public function calculateScore()
    {
        if ($this->total_questions > 0) {
            $this->score_percentage = ($this->correct_answers / $this->total_questions) * 100;
            $this->passed = $this->score_percentage >= $this->category->pass_percentage;
        }
    }

    public function recordAnswer($questionId, $selectedAnswer, $isCorrect)
    {
        $answers = $this->answers ?? [];
        $answers[$questionId] = [
            'selected' => $selectedAnswer,
            'correct' => $isCorrect,
        ];
        $this->answers = $answers;

        if ($isCorrect) {
            $this->correct_answers++;
        } else {
            $this->wrong_answers++;
        }

        $this->save();
    }

    public function skipQuestion($questionId)
    {
        $answers = $this->answers ?? [];
        $answers[$questionId] = [
            'selected' => null,
            'skipped' => true,
        ];
        $this->answers = $answers;
        $this->skipped_questions++;
        $this->save();
    }

    public function getTimeFormatted()
    {
        if (!$this->time_taken_seconds) {
            return '-';
        }

        $minutes = floor($this->time_taken_seconds / 60);
        $seconds = $this->time_taken_seconds % 60;

        if ($minutes > 0) {
            return "{$minutes}m {$seconds}s";
        }
        return "{$seconds}s";
    }

    public function getResultBadgeClass()
    {
        if (!$this->isCompleted()) {
            return 'warning';
        }
        return $this->passed ? 'success' : 'danger';
    }

    public function getResultText()
    {
        if (!$this->isCompleted()) {
            return 'In Progress';
        }
        return $this->passed ? 'Passed' : 'Failed';
    }

    public function getScoreGrade()
    {
        if ($this->score_percentage >= 90) return 'A';
        if ($this->score_percentage >= 80) return 'B';
        if ($this->score_percentage >= 70) return 'C';
        if ($this->score_percentage >= 60) return 'D';
        return 'F';
    }
}
