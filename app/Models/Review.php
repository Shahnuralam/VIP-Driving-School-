<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Review extends Model
{
    protected $fillable = [
        'booking_id',
        'customer_id',
        'service_id',
        'package_id',
        'instructor_id',
        'customer_name',
        'customer_email',
        'customer_location',
        'overall_rating',
        'instructor_rating',
        'vehicle_rating',
        'value_rating',
        'title',
        'content',
        'admin_response',
        'admin_responded_at',
        'status',
        'rejection_reason',
        'moderated_by',
        'moderated_at',
        'is_featured',
        'show_on_homepage',
        'helpful_count',
        'review_token',
        'review_requested_at',
    ];

    protected $casts = [
        'admin_responded_at' => 'datetime',
        'moderated_at' => 'datetime',
        'is_featured' => 'boolean',
        'show_on_homepage' => 'boolean',
        'review_requested_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($review) {
            if (empty($review->review_token)) {
                $review->review_token = Str::random(64);
            }
        });

        static::saved(function ($review) {
            if ($review->instructor_id && $review->status === 'approved') {
                $review->instructor->updateRating();
            }
        });
    }

    // Relationships
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function instructor()
    {
        return $this->belongsTo(Instructor::class);
    }

    public function moderator()
    {
        return $this->belongsTo(User::class, 'moderated_by');
    }

    public function helpfulVotes()
    {
        return $this->hasMany(ReviewHelpful::class);
    }

    // Scopes
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeForHomepage($query)
    {
        return $query->where('show_on_homepage', true)->where('status', 'approved');
    }

    // Helpers
    public function approve($userId)
    {
        $this->status = 'approved';
        $this->moderated_by = $userId;
        $this->moderated_at = now();
        $this->save();
    }

    public function reject($userId, $reason = null)
    {
        $this->status = 'rejected';
        $this->rejection_reason = $reason;
        $this->moderated_by = $userId;
        $this->moderated_at = now();
        $this->save();
    }

    public function addResponse($response)
    {
        $this->admin_response = $response;
        $this->admin_responded_at = now();
        $this->save();
    }

    public function markHelpful($ipAddress, $customerId = null)
    {
        $exists = $this->helpfulVotes()
            ->where('ip_address', $ipAddress)
            ->exists();

        if (!$exists) {
            $this->helpfulVotes()->create([
                'ip_address' => $ipAddress,
                'customer_id' => $customerId,
            ]);
            $this->increment('helpful_count');
            return true;
        }

        return false;
    }

    public function getStarsHtml()
    {
        $stars = '';
        for ($i = 1; $i <= 5; $i++) {
            if ($i <= $this->overall_rating) {
                $stars .= '<i class="fas fa-star text-warning"></i>';
            } else {
                $stars .= '<i class="far fa-star text-warning"></i>';
            }
        }
        return $stars;
    }

    public function getAverageRating()
    {
        $ratings = array_filter([
            $this->overall_rating,
            $this->instructor_rating,
            $this->vehicle_rating,
            $this->value_rating,
        ]);

        return count($ratings) > 0 ? round(array_sum($ratings) / count($ratings), 1) : 0;
    }

    public function getStatusBadgeClass()
    {
        return match($this->status) {
            'pending' => 'warning',
            'approved' => 'success',
            'rejected' => 'danger',
            default => 'secondary',
        };
    }
}
