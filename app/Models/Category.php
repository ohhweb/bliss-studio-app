<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo; // <-- Add this at the top
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany; // We need this for the relationship

class Category extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
    ];

    /**
     * Get all of the videos for the Category.
     * This defines the "one-to-many" relationship.
     * --- THIS IS THE CORRECT METHOD ---
     */
    public function videos(): HasMany
    {
        return $this->hasMany(Video::class);
    }
}