<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogComment extends Model
{
    protected $fillable = [
        'blog_post_id',
        'parent_id',
        'customer_id',
        'author_name',
        'author_email',
        'author_website',
        'content',
        'ip_address',
        'user_agent',
        'status',
        'moderated_by',
        'moderated_at',
    ];

    protected $casts = [
        'moderated_at' => 'datetime',
    ];

    // Relationships
    public function post()
    {
        return $this->belongsTo(BlogPost::class, 'blog_post_id');
    }

    public function parent()
    {
        return $this->belongsTo(BlogComment::class, 'parent_id');
    }

    public function replies()
    {
        return $this->hasMany(BlogComment::class, 'parent_id');
    }

    public function approvedReplies()
    {
        return $this->hasMany(BlogComment::class, 'parent_id')->where('status', 'approved');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function moderator()
    {
        return $this->belongsTo(User::class, 'moderated_by');
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

    public function scopeTopLevel($query)
    {
        return $query->whereNull('parent_id');
    }

    // Helpers
    public function approve($userId)
    {
        $this->status = 'approved';
        $this->moderated_by = $userId;
        $this->moderated_at = now();
        $this->save();

        // Update post comments count
        $this->post->update([
            'comments_count' => $this->post->approvedComments()->count()
        ]);
    }

    public function markAsSpam($userId)
    {
        $this->status = 'spam';
        $this->moderated_by = $userId;
        $this->moderated_at = now();
        $this->save();
    }

    public function trash($userId)
    {
        $this->status = 'trash';
        $this->moderated_by = $userId;
        $this->moderated_at = now();
        $this->save();
    }

    public function getStatusBadgeClass()
    {
        return match($this->status) {
            'pending' => 'warning',
            'approved' => 'success',
            'spam' => 'danger',
            'trash' => 'dark',
            default => 'secondary',
        };
    }

    public function getGravatarUrl($size = 50)
    {
        $hash = md5(strtolower(trim($this->author_email)));
        return "https://www.gravatar.com/avatar/{$hash}?s={$size}&d=mp";
    }
}
