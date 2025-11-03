<?php

namespace App\Http\Controllers;

use App\Models\Category; // <-- THIS IS THE MISSING LINE
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function index()
    {
        // Fetch all categories that have at least one video,
        // and also load the video relationships for each category.
        $categories = Category::has('videos')->with('videos')->get();

        return view('home', compact('categories'));
    }
}