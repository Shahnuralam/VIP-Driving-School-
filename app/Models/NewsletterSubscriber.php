<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class NewsletterSubscriber extends Model
{
    protected $fillable = [
        'email',
        'name',
        'customer_id',
        'status',
        'confirmation_token',
        'confirmed_at',
        'unsubscribe_token',
        'unsubscribed_at',
        'source',
        'ip_address',
    ];

    protected $casts = [
        'confirmed_at' => 'datetime',
        'unsubscribed_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($subscriber) {
            $subscriber->confirmation_token = Str::random(64);
            $subscriber->unsubscribe_token = Str::random(64);
        });
    }

    // Relationships
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    // Scopes
    public function scopeSubscribed($query)
    {
        return $query->where('status', 'subscribed');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    // Helpers
    public function confirm()
    {
        $this->status = 'subscribed';
        $this->confirmed_at = now();
        $this->confirmation_token = null;
        $this->save();
    }

    public function unsubscribe()
    {
        $this->status = 'unsubscribed';
        $this->unsubscribed_at = now();
        $this->save();
    }

    public function resubscribe()
    {
        $this->status = 'subscribed';
        $this->unsubscribed_at = null;
        $this->unsubscribe_token = Str::random(64);
        $this->save();
    }

    public function getStatusBadgeClass()
    {
        return match($this->status) {
            'pending' => 'warning',
            'subscribed' => 'success',
            'unsubscribed' => 'secondary',
            default => 'secondary',
        };
    }
}
