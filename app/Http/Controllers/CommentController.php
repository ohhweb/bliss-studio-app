<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Store a newly created comment in storage.
     */
    public function store(Request $request, Video $video)
    {
        // 1. Validate that the comment body is not empty.
        $validated = $request->validate([
            'body' => 'required|string|max:2500'
        ]);

        // 2. Get the currently authenticated user.
        $user = $request->user();

        // 3. Create a new comment using the relationship from the User model.
        // This is a very clean and reliable way to create the comment.
        $user->comments()->create([
            'body' => $validated['body'],
            'video_id' => $video->id, // We explicitly set the video_id here
        ]);

        // 4. Redirect back to the previous page with a success message.
        return back()->with('success', 'Your comment has been posted!');
    }
}