<?php
namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Video $video)
    {
        $request->validate(['body' => 'required|string|max:2500']);

        // Create the comment and associate it with the logged-in user and the video
        $video->comments()->create([
            'body' => $request->input('body'),
            'user_id' => auth()->id(),
        ]);

        return back()->with('success', 'Your comment has been posted!');
    }
}