<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function toggle(Video $video, Request $request)
    {
        $request->user()->likes()->toggle($video);

        return back();
    }
}