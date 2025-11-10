<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['body', 'video_id'];

    // A comment belongs to a single user
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // A comment belongs to a single video
    public function video(): BelongsTo
    {
        return $this->belongsTo(Video::class);
    }
}