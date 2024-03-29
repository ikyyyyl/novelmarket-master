<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MyPanelController extends Controller
{
    public function index()
    {
        $user = auth()->user(); // Get the authenticated user
        return view('my-panel.index', compact('user'));
    }

    public function updateUserInfo(Request $request)
    {
        // Validate the form data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . Auth::id(),
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust the validation rules as needed
        ]);

        // Get the authenticated user
        $user = Auth::user();

        // Update the user's name and email
        $user->name = $request->input('name');
        $user->email = $request->input('email');

        // Handle profile picture upload
        if ($request->hasFile('image_path')) {
            // Store the uploaded image
            $imagePath = $request->file('image_path')->store('public/storage');

            // Update the user's image path
            $user->image_path = str_replace('public/', '', $imagePath);
        }

        // Save the updated user information
        $user->save();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'User information updated successfully.');
    }
}
