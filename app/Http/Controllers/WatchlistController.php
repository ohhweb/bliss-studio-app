<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;

class WatchlistController extends Controller
{
    /**
     * Display the authenticated user's watchlist.
     */
    public function index(Request $request)
    {
        $videos = $request->user()->watchlist()->latest()->paginate(12);
        return view('watchlist.index', compact('videos'));
    }

    /**
     * Add or remove a video from the user's watchlist.
     */
    public function toggle(Video $video, Request $request)
    {
        $request->user()->watchlist()->toggle($video);
        return back();
    }
}