<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class ProfileController
{
    public function edit()
    {
        $user = Auth::user();
        $savedRecipes = $user->savedRecipes()->with('category')->latest('recipe_saves.created_at')->get();
        $myComments   = $user->commentsRatings()->with('recipe')->latest()->take(20)->get();
        return view('profile.edit', compact('user', 'savedRecipes', 'myComments'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'avatar'   => ['nullable', 'image', 'max:5120'],
            'bio'      => ['nullable', 'string', 'max:500'],
            'phone'    => ['nullable', 'string', 'max:20'],
        ]);

        $user->name  = $request->name;
        $user->email = $request->email;

        if ($request->filled('bio')) {
            $user->bio = $request->bio;
        }

        if ($request->filled('phone')) {
            $user->phone = $request->phone;
        }

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            // Delete old avatar from storage if it exists
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $user->avatar = $request->file('avatar')->store('avatars', 'public');
        }

        $user->save();

        return redirect()->route('profile.edit')->with('success', 'Profil Anda berhasil diperbarui!');
    }
}

