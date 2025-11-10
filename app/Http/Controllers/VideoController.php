<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    /**
     * Display the specified video resource for visitors.
     * This method also logs watch history and fetches related content and comments.
     */
    public function show(Video $video, Request $request)
    {
        // 1. Log to watch history if the user is authenticated.
        if ($request->user()) {
            // Check if the record already exists in the pivot table.
            if ($request->user()->watchedHistory()->where('video_id', $video->id)->exists()) {
                // If it exists, just update the 'updated_at' timestamp to mark it as recently watched.
                $request->user()->watchedHistory()->updateExistingPivot($video->id, ['updated_at' => now()]);
            } else {
                // If it doesn't exist, create the record for the first time.
                $request->user()->watchedHistory()->attach($video->id);
            }
        }

        // 2. Fetch related videos from the same category.
        $relatedVideos = Video::where('category_id', $video->category_id)
                              ->where('id', '!=', $video->id) // Exclude the current video
                              ->inRandomOrder()
                              ->take(10)
                              ->get();
                          
        // 3. Eager load all comments for this video, along with the user who posted them.
        // This is now outside the if-statement, so it always runs.
        $comments = $video->comments()->with('user')->latest()->get();

        // 4. Return the view, passing all the necessary data.
        return view('videos.show', compact('video', 'relatedVideos', 'comments'));
    }
}