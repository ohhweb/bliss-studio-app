<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Video;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the homepage with categories and videos.
     */
   public function index()
{
    // Fetch the 5 latest videos for the slider
    $featuredVideos = Video::latest()->take(5)->get(); // <-- CHANGE THIS LINE

    // Fetch all categories with their videos for the scrolling rows
    $categories = Category::has('videos')->with('videos')->get();

    return view('home', compact('categories', 'featuredVideos')); // <-- `featuredVideos` is now a collection
}

    /**
     * Search for videos based on a query.
     */
    public function search(Request $request)
    {
        $query = $request->input('query');

        $videos = Video::where('title', 'LIKE', "%{$query}%")
                       ->orWhere('description', 'LIKE', "%{$query}%")
                       ->latest()
                       ->paginate(12);

        return view('search', compact('videos', 'query'));
    }
    
    /**
     * Show the search form page for mobile.
     */
    public function showSearchForm()
    {
        return view('search-form');
    }
}