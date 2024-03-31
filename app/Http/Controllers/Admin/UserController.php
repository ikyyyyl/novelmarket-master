<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Show users list
     *
     * @return \Illuminate\Http\Response
     */
    public function all()
    {
        $users = User::paginate(10);

        return view('admin.frontend.users.list', compact('users'));
    }

    /**
     * Show form for creating a new user
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.frontend.users.add');
    }

    /**
     * Store a new created user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            // Validate form data
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'image_path' => 'required|string|max:2048',
                'password' => 'required|string|min:6',
                'role' => 'required|in:user,admin',
                'phone-number' => 'required|string|max:20', // Changed field name to match HTML form
                'address' => 'required|string|max:255',
            ]);

            // Create user
            $user = new User();
            $user->name = $validatedData['name'];
            $user->email = $validatedData['email'];
            $user->image_path = $validatedData['image_path'];
            $user->password = bcrypt($validatedData['password']);
            $user->role = $validatedData['role'];
            $user->phone_number = $validatedData['phone-number']; // Updated field name to match database column
            $user->address = $validatedData['address'];
            $user->save();

            return redirect()->route('admin.users.all')->with('simpleSuccessAlert', 'User added successfully');
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['failed_storage' => 'Failed to store user.']);
        }
    }

    /**
     * Show form for editing the specified user.
     *
     * @param  \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('admin.frontend.users.edit', compact('user'));
    }

    /**
     * Update specified user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        try {
            // Validate form data
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $user->id,
                'image_path' => 'required|string|max:2048',
                'role' => 'required|in:user,admin',
                'phone-number' => 'required|string|max:20', // Changed field name to match HTML form
                'address' => 'required|string|max:255',
            ]);

            // Update user
            $user->name = $validatedData['name'];
            $user->email = $validatedData['email'];
            $user->image_path = $validatedData['image_path'];
            $user->role = $validatedData['role'];
            $user->phone_number = $validatedData['phone-number']; // Updated field name to match database column
            $user->address = $validatedData['address'];
            $user->save();

            return redirect()->route('admin.users.all')->with('simpleSuccessAlert', 'User updated successfully');
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['failed_update' => 'Failed to update user.']);
        }
    }

    /**
     * Remove specified user from storage.
     *
     * @param  \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        try {
            $user->delete();

            return redirect()->route('admin.users.all')->with('simpleSuccessAlert', 'User removed successfully');
        } catch (\Exception $e) {
            return back()->withErrors(['failed_delete' => 'Failed to delete user.']);
        }
    }
}