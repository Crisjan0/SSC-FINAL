<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{

    public function index()
    {
        // Fetch users to display in the table
        $users = \App\Models\User::all(); 
        
        // This points to resources/views/users/index.blade.php
        return view('users.index', compact('users'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required'
        ]);

        User::create([
            'name' => ucwords(strtolower($request->name)),
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return back()->with('success', 'Officer account created successfully!');
    }

    public function destroy(User $user)
    {
        // Safety: Prevent deleting yourself
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account!');
        }

        $user->delete();
        return back()->with('success', 'Officer account removed.');
    }

    public function updateRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required'
        ]);

        // Safety: Prevent changing your own role
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot change your own role!');
        }

        $user->role = $request->role;
        $user->save();

        return back()->with('success', 'Officer role updated.');
    }

    public function create()
    {
        return view('users.create');
    }
}
