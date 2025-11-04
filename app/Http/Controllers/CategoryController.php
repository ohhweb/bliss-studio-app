<?php

namespace App\Http\Controllers; // <-- CORRECTED: No hyphen, correct spelling

use App\Http\Controllers\Controller; // <-- This now works correctly
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display all videos for a specific category.
     */
    public function show(Category $category)
    {
        $videos = $category->videos()->latest()->paginate(12);
        return view('categories.show', compact('category', 'videos'));
    }
}