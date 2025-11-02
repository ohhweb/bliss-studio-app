<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\VideoController;
use App\Http\Controllers\Controller;
use App\Models\Category; // Add this line
use App\Models\Video;    // Add this line
use Illuminate\Http\Request;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
{
    // We will need to pass categories to the view later
    return view('admin.videos.create');
}

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
{
    // Part 1: Validation
    $validated = $request->validate([
        'title'         => 'required|string|max:255',
        'description'   => 'nullable|string',
        'video_url'     => 'required|url',
        'thumbnail_url' => 'required|url',
        'category_id'   => 'required|integer|exists:categories,id'
    ]);

    // Part 2: Creating the Record
    Video::create($validated);

    // Part 3: Redirecting the User
    return redirect('/admin/videos')->with('success', 'Video added successfully!');
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

Route::resource('/admin/videos', VideoController::class);