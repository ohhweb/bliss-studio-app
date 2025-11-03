<?php

namespace App\Http\Controllers\Admin; // <-- CORRECTED: Must be in the 'Admin' namespace

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $videos = Video::latest()->paginate(10);
        return view('admin.videos.index', compact('videos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.videos.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
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
        return redirect()->route('videos.index')->with('success', 'Video added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Video $video)
    {
        // Not used in the admin panel, can be left empty
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Video $video)
    {
        $categories = Category::all();
        return view('admin.videos.edit', compact('video', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
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
        return redirect()->route('videos.index')->with('success', 'Video updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Video $video)
    {
        $video->delete();
        return redirect()->route('videos.index')->with('success', 'Video deleted successfully!');
    }
}