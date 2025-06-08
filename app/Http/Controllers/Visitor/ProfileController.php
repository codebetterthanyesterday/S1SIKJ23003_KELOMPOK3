<?php

namespace App\Http\Controllers\Visitor;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        return view('Pages.Visitor.Profile', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id_user, 'id_user')],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id_user, 'id_user')],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:500'],
            'profile_picture' => ['nullable', 'image', 'max:2048'], // max 2MB
            // 'seller_role' => ['nullable', 'boolean'],
        ]);

        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            // Delete old profile picture if exists
            if ($user->profile_picture) {
                Storage::delete($user->profile_picture);
            }

            // Store new profile picture
            $data['profile_picture'] = $request->file('profile_picture')->store('profile-pictures', 'public');
        }

        // Update user information
        $user->fill([
            'username' => $data['username'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'address' => $data['address'],
            'profile_picture' => $data['profile_picture'] ?? $user->profile_picture,
        ])->save();

        // Handle seller role toggle
        $sellerRole = Role::where('role_name', 'seller')->first();
        if ($request->input('seller_role') !== null) {
            if (!$user->roles->contains($sellerRole->id_role)) {
                $user->roles()->attach($sellerRole->id_role);
            }
        } else {
            if ($user->roles->contains($sellerRole->id_role)) {
                $user->roles()->detach($sellerRole->id_role);
            }
        }

        return redirect()->back()->with('success', 'Profile updated successfully');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'The current password is incorrect']);
        }

        $user->fill([
            'password' => Hash::make($request->password)
        ])->save();

        return redirect()->back()->with('success', 'Password updated successfully');
    }
}
