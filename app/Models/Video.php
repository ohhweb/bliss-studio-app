<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // <-- THIS IS THE MISSING LINE
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory; // Now this line knows where to find HasFactory

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
        'category_id',
    ];
}