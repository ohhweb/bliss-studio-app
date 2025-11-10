<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    public function block(Request $request, User $user)
    {
        $request->validate(['block_note' => 'required|string|max:1000']);
        
        $user->status = 'blocked';
        $user->block_note = $request->input('block_note');
        $user->save();

        return back()->with('success', 'User has been blocked.');
    }

    public function unblock(User $user)
    {
        $user->status = 'active';
        $user->block_note = null;
        $user->save();
        
        return back()->with('success', 'User has been unblocked.');
    }
}