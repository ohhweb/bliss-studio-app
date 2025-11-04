<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Video;
use Illuminate\Http\Request;

// The class name MUST match the filename "VideoController.php"
class VideoController extends Controller
{
    public function index()
    {
        $videos = Video::latest()->paginate(10);
        return view('admin.videos.index', compact('videos'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.videos.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'         => 'required|string|max:255',
            'description'   => 'nullable|string',
            'video_url'     => 'required|string',
            'thumbnail_url' => 'required|url',
            'video_type'    => 'required|in:youtube,vimeo,direct',
            'category_id'   => 'required|integer|exists:categories,id'
        ]);

        Video::create($validated);
        return redirect()->route('admin.videos.index')->with('success', 'Video added successfully!');
    }

    public function show(Video $video)
    {
        // Not used
    }

    public function edit(Video $video)
    {
        $categories = Category::all();
        return view('admin.videos.edit', compact('video', 'categories'));
    }

    public function update(Request $request, Video $video)
    {
        $validated = $request->validate([
            'title'         => 'required|string|max:255',
            'description'   => 'nullable|string',
            'video_url'     => 'required|string',
            'thumbnail_url' => 'required|url',
            'video_type'    => 'required|in:youtube,vimeo,direct',
            'category_id'   => 'required|integer|exists:categories,id'
        ]);

        $video->update($validated);
        return redirect()->route('admin.videos.index')->with('success', 'Video updated successfully!');
    }

    public function destroy(Video $video)
    {
        $video->delete();
        return redirect()->route('admin.videos.index')->with('success', 'Video deleted successfully!');
    }
}