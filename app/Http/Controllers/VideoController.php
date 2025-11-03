<?php

namespace App\Http\Controllers; // <-- CORRECT: This is NOT in the 'Admin' namespace

use App\Models\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    /**
     * Display the specified video resource for visitors.
     */
    public function show(Video $video)
    {
        // This is the only method this controller needs.
        // It simply shows the 'watch' page for a single video.
        return view('videos.show', compact('video'));
    }
}