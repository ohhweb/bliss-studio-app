<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller; 
use App\Models\Category;
use App\Models\Video;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Fetch the single latest video as the featured one
        $featuredVideo = Video::latest()->first();

        // Fetch all categories with their videos for the scrolling rows
        $categories = Category::has('videos')->with('videos')->get();

        return view('home', compact('categories', 'featuredVideo'));
    }
// namespace App\Http\Controllers; 
// use App\Http\Controllers\Controller; 
// use App\Models\Category;
// use App\Models\Video;
// use Illuminate\Http\Request;

// class HomeController extends Controller
// {
//     /**
//      * Display the homepage with categories and videos.
//      */
//     public function index()
//     {
//         $categories = Category::has('videos')->with('videos')->get();
//         return view('home', compact('categories'));
//     }
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
    public function showSearchForm() // <-- ADD THIS METHOD
{
    // For now, it just shows a view. We can add "recent searches" logic later.
    return view('search-form');
}
}