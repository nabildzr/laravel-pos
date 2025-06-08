<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
            'role' => 'required|string|in:operator,admin,super_admin',
            'is_active' => 'required|boolean',
            'profile_image' => 'nullable|image|max:2048',
        ]);

        $userData = $request->except(['_token', 'password_confirmation', 'profile_image']);
        $userData['password'] = Hash::make($request->password);
        $userData['join_date'] = now();


        if (
            $userData['role'] === 'super_admin' &&
            Auth::user()->role !== 'super_admin'
        ) {
            return back()->with('error', 'Only Super Admin can create another Super Admin user.');
        }

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
            'role' => 'required|string|in:operator,admin,super_admin',
            'is_active' => 'required|boolean',
            'profile_image' => 'nullable|image|max:2048',
        ];

        // Hanya validasi password jika user yang login adalah super_admin DAN password field diisi
        if (Auth::user()->role === 'super_admin' && $request->filled('password')) {
            $rules['password'] = 'required|min:6|confirmed';
        }

        $request->validate($rules);

        $userData = $request->except(['_token', 'password_confirmation', 'profile_image']);

        if ($userData['role'] === 'super_admin' && Auth::user()->role !== 'super_admin') {
            return back()->with('error', 'Only Super Admin can assign Super Admin role.');
        }

        // Update password hanya jika:
        // 1. User yang login adalah super_admin
        // 2. Password field diisi
        if (Auth::user()->role === 'super_admin' && $request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        } else {
            // Hapus key password dari userData jika tidak diupdate
            unset($userData['password']);
        }

        // Sisanya sama seperti sebelumnya
        if ($request->hasFile('profile_image')) {
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
        $loginHistory = \App\Models\LoginHistory::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return view('users.viewProfile', compact('user', 'loginHistory'));
    }

    public function deleteUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if (Auth::id() === $user->id) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        if ($user->role === 'super_admin' && Auth::user()->id !==  1) {
            return back()->with('error', 'Super Admin users cannot be deleted.');
        }

        if ($user->profile_image) {
            Storage::disk('public')->delete($user->profile_image);
        }

        $user->delete();

        return back()->with('success', 'User deleted successfully');
    }

    public function changePassword(Request $request)
    {
        // Validate the request
        $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:6|confirmed|different:current_password',
        ], [
            'password.confirmed' => 'The password confirmation does not match.',
            'password.different' => 'The new password must be different from your current password.',
        ]);

        // Check if current password is correct
        $user = Auth::user();
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Your current password is incorrect.']);
        }

        // Update password manually without Eloquent's save()
        DB::table('users')
            ->where('id', $user->id)
            ->update(['password' => Hash::make($request->password)]);

        return redirect()->back()->with('success', 'Password changed successfully!');
    }
}
