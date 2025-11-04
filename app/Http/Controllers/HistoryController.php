<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    /**
     * Display the authenticated user's watched history.
     */
    public function index(Request $request)
    {
        // Get the videos from the user's watched history,
        // ordering by the most recently watched ('pivot_updated_at').
        $videos = $request->user()->watchedHistory()->orderBy('pivot_updated_at', 'desc')->paginate(12);

        return view('history.index', compact('videos'));
    }
}