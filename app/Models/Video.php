<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany; // For Likes

class Video extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'video_url',
        'thumbnail_url',
        'video_type', // <-- ADD THIS LINE
        'category_id',
    ];

    /**
     * Get the category that owns the Video.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * The users that have liked the Video.
     */
    public function likes(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'video_likes');
    }
}