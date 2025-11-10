<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     * We MUST include 'user_id' here.
     */
    protected $fillable = [
        'body',
        'video_id',
        'user_id', // <-- ADD THIS LINE
    ];

    /**
     * A comment belongs to a single user.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * A comment belongs to a single video.
     */
    public function video(): BelongsTo
    {
        return $this->belongsTo(Video::class);
    }
}