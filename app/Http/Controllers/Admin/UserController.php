<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        $validator = $this->validateAddForm($request);

        if ($validator->fails()) {
        return back()
            ->withErrors($validator)
            ->withInput();
    }
            // Create user
            $user = new User();
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->password = $request->input('password');
            $user->role = $request->input('role');
            $user->phone_number = $request->input('phone_number');
            $user->address = $validatedData['address']; // Assuming $validatedData contains the validated address
            if ($request->hasFile('image_path')) {
                // Store the new image and update the user's image_path
            $imagePath = $request->file('image_path')->store('profile_images', 'public');
            $user->image_path = $imagePath;
            } else {
                // If no image is uploaded, you may want to set a default image path or leave it as null
                // $user->image_path = 'default-image-path.jpg'; // Example of setting a default image path
            $user->image_path = null; // Or leave it as null
            }
            $user->save();

        return redirect()->route('admin.users.all')->with('simpleSuccessAlert', 'User added successfully');
        } 
    /**
     * Show form for editing the specified user.
     * @param  \Illuminate\Http\Request  $request
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
    public function update(User $user, Request $request)
{
    $validator = $this->validateUpdateForm($request);

    if ($validator->fails()) {
        return back()
            ->withErrors($validator)
            ->withInput();
    }

    // Update user details
    $user->name = $request->input('name');
    $user->email = $request->input('email');
    $user->password = $request->input('password');
    $user->role = $request->input('role');
    $user->phone_number = $request->input('phone_number');
    $user->address = $request->input('address');

    if ($request->hasFile('image_path')) {
        // Store the new image and update the user's image_path
        $imagePath = $request->file('image_path')->store('profile_images', 'public');
        $user->image_path = $imagePath;
    }

    $user->save();

    return redirect()->route('admin.users.all')->with('simpleSuccessAlert', 'User updated successfully');
}


    /**
     * Remove specified user from storage.
     *
     * @param  \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        File::delete(public_path("\images\users\\$supplier->image_path"));

        $supplier->delete();

        return back()->with('simpleSuccessAlert' , 'User removed successfully');
    }

    /**
     * Validate form data for adding a new supplier.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validateAddForm(Request $request)
    {
        return Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'image_path' => 'required|string|max:4048',
            'password' => 'required|string|min:6',
            'role' => 'required|in:user,admin',
            'phone-number' => 'required|string|max:20', // Changed field name to match HTML form
            'address' => 'required|string|max:255',
        ]);  
    }

    protected function validateUpdateForm(Request $request)
    {
        return Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'image_path' => 'required|string|max:4048',
            'password' => 'required|string|min:6',
            'role' => 'required|in:user,admin',
            'phone-number' => 'required|string|max:20', // Changed field name to match HTML form
            'address' => 'required|string|max:255',
        ]);
    }
}


