<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReviewHelpful extends Model
{
    protected $table = 'review_helpful';

    protected $fillable = [
        'review_id',
        'ip_address',
        'customer_id',
    ];

    public function review()
    {
        return $this->belongsTo(Review::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
