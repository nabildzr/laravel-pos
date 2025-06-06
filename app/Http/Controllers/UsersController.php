<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UsersController extends Controller
{
    public function usersList()
    {
        return view('users/usersList');
    }

    public function addUser()
    {
        return view('users.addUser');
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'phone_number' => 'nullable|string|max:20',
            'role' => 'required|string|in:user,staff,admin,super_admin',
            'is_active' => 'required|boolean',
            'profile_image' => 'nullable|image|max:2048',
        ]);

        if (
            isset($userData['role']) &&
            $userData['role'] === 'super_admin' &&
            Auth::user()->role !== 'super_admin'
        ) {
            return back()->with('error', 'Only Super Admin can create another Super Admin user.');
        }

        $userData = $request->except(['_token', 'password_confirmation', 'profile_image']);
        $userData['password'] = Hash::make($request->password);

        $userData['join_date'] = now();


        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('profile_images', 'public');
            $userData['profile_image'] = $path;
        }

        User::create($userData);

        return redirect()->route('usersList')->with('success', 'User created successfully');
    }

    public function editUser($id)
    {
        $user = User::findOrFail($id);
        return view('users.addUser', compact('user'));
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $rules = [
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone_number' => 'nullable|string|max:20',
            'role' => 'required|string|in:user,staff,admin,super_admin',
            'is_active' => 'required|boolean',
            'profile_image' => 'nullable|image|max:2048',
        ];

        if ($request->filled('password')) {
            $rules['password'] = 'required|min:6|confirmed';
        }

        $request->validate($rules);

        $userData = $request->except(['_token', 'password_confirmation', 'profile_image']);

        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        // Handle profile image
        if ($request->hasFile('profile_image')) {
            // Delete old image if exists
            if ($user->profile_image) {
                Storage::disk('public')->delete($user->profile_image);
            }
            $path = $request->file('profile_image')->store('profile_images', 'public');
            $userData['profile_image'] = $path;
        }

        $user->update($userData);

        return redirect()->route('usersList')->with('success', 'User updated successfully');
    }

    public function viewUserProfile($id)
    {
        $user = User::findOrFail($id);
        $loginHistory = $user->loginHistory()->orderBy('created_at', 'desc')->take(10)->get();

        return view('users.viewProfileFromList', compact('user', 'loginHistory'));
    }

    public function viewProfile()
    {
        $user = Auth::user();
        $loginHistory = $user->loginHistory()->orderBy('created_at', 'desc')->take(10)->get();

        return view('users.viewProfile', compact('user', 'loginHistory'));
    }

    public function deleteUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Check if user is super_admin
        if ($user->role === 'super_admin') {
            return back()->with('error', 'Super Admin users cannot be deleted.');
        }

        // Delete profile image if exists
        if ($user->profile_image) {
            Storage::disk('public')->delete($user->profile_image);
        }

        $user->delete();

        return back()->with('success', 'User deleted successfully');
    }
}
