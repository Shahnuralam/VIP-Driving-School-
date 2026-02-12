<?php

namespace App\Models;

use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Customer extends Authenticatable
{
    use HasFactory, Notifiable, CanResetPassword;

    protected $guard = 'customer';

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'license_number',
        'address',
        'suburb',
        'postcode',
        'date_of_birth',
        'profile_photo',
        'preferred_transmission',
        'is_active',
        'email_notifications',
        'sms_notifications',
        'last_login_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'date_of_birth' => 'date',
        'is_active' => 'boolean',
        'email_notifications' => 'boolean',
        'sms_notifications' => 'boolean',
        'last_login_at' => 'datetime',
    ];

    // Relationships
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function giftVouchersRedeemed()
    {
        return $this->hasMany(GiftVoucher::class, 'redeemed_by');
    }

    public function theoryAttempts()
    {
        return $this->hasMany(TheoryAttempt::class);
    }

    public function newsletterSubscription()
    {
        return $this->hasOne(NewsletterSubscriber::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Helpers
    public function getUpcomingBookings()
    {
        return $this->bookings()
            ->whereIn('status', ['pending', 'confirmed'])
            ->where('booking_date', '>=', now()->toDateString())
            ->orderBy('booking_date')
            ->orderBy('booking_time')
            ->get();
    }

    public function getPastBookings()
    {
        return $this->bookings()
            ->where(function($q) {
                $q->where('booking_date', '<', now()->toDateString())
                  ->orWhereIn('status', ['completed', 'cancelled', 'no_show']);
            })
            ->orderByDesc('booking_date')
            ->get();
    }

    public function getTotalLessons()
    {
        return $this->bookings()->where('status', 'completed')->count();
    }

    public function getTotalSpent()
    {
        return $this->bookings()
            ->where('payment_status', 'paid')
            ->sum('amount');
    }

    public function getProfilePhotoUrl()
    {
        if ($this->profile_photo) {
            return asset('storage/' . $this->profile_photo);
        }
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=1e3a5f&color=fff';
    }

    public function canLeaveReview($bookingId)
    {
        $booking = $this->bookings()->find($bookingId);
        if (!$booking || $booking->status !== 'completed') {
            return false;
        }
        return !Review::where('booking_id', $bookingId)->exists();
    }
}
