<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Video extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'video_url', 'thumbnail_url', 'video_type', 'category_id',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function likes(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'video_likes');
    }

    /**
     * The users that have this video in their watchlist.
     */
    public function watchlist(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'watchlists');
    }
}