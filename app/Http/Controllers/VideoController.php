<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function show(Video $video, Request $request)
    {
        // If a user is logged in, log this video to their watch history.
        if ($request->user()) {
            // The touch() method updates the `updated_at` timestamp if the record exists.
            if ($request->user()->watchedHistory()->where('video_id', $video->id)->exists()) {
                $request->user()->watchedHistory()->updateExistingPivot($video->id, ['updated_at' => now()]);
            } else {
                // If it doesn't exist, attach it for the first time.
                $request->user()->watchedHistory()->attach($video->id);
            }
        }

        return view('videos.show', compact('video'));
    }
}