<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'password'];
    protected $hidden = ['password', 'remember_token'];
    protected $casts = ['email_verified_at' => 'datetime', 'password' => 'hashed'];

    /**
     * The videos that the user has liked.
     */
    public function likes(): BelongsToMany
    {
        return $this->belongsToMany(Video::class, 'video_likes');
    }

    /**
     * The videos that the user has added to their watchlist.
     */
    public function watchlist(): BelongsToMany
    {
        return $this->belongsToMany(Video::class, 'watchlists');
    }
}