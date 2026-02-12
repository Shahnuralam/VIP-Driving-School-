<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InstructorUnavailability extends Model
{
    protected $fillable = [
        'instructor_id',
        'date',
        'start_time',
        'end_time',
        'reason',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function instructor()
    {
        return $this->belongsTo(Instructor::class);
    }

    public function isFullDay()
    {
        return is_null($this->start_time);
    }
}
