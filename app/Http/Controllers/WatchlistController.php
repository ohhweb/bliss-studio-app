<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;

class WatchlistController extends Controller
{
    /**
     * Add or remove a video from the authenticated user's watchlist.
     */
    public function toggle(Video $video, Request $request)
    {
        // The toggle() method is a Laravel shortcut that automatically
        // adds the relationship if it doesn't exist, or removes it if it does.
        // It's perfect for this kind of button.
        $request->user()->watchlist()->toggle($video);

        // Redirect the user back to the page they were on.
        return back();
    }
}