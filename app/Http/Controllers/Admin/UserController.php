<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('role', '!=', 'admin')->get();

        return Inertia::render('Admin/Users/Index', [
            'users' => $users,
        ]);
    }

    // public function update(Request $request, User $user)
    // {
    //     $request->validate([
    //         'role' => 'required|in:user,admin',
    //     ]);

    //     $user->role = $request->role;
    //     $user->save();

    //     return redirect()->back()->with('success', 'User role updated.');
    // }
}
