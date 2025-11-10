<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PlanController extends Controller
{
    public function index() { return view('plans.index'); }
    public function store(Request $request)
{
    // For now, we only have one plan, "free"
    $user = auth()->user();
    $user->plan = 'free';
    $user->save();

    // Redirect to the homepage, where they can now watch videos
    return redirect()->route('home')->with('success', 'You have successfully subscribed to the free plan!');
}
    //
}
