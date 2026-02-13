<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SettingsController extends Controller
{
    /**
     * Display settings page.
     */
    public function index()
    {
        return view('admin.settings.index');
    }

    /**
     * Display data & sync settings.
     */
    public function sync()
    {
        return view('admin.settings.sync');
    }

    /**
     * Display profile settings.
     */
    public function profile()
    {
        return view('admin.settings.profile', [
            'user' => Auth::user()->load('person'),
        ]);
    }

    /**
     * Update profile.
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'phone' => 'required|string|max:20',
        ]);

        // Update person
        if ($user->person) {
            $user->person->update([
                'full_name' => $validated['full_name'],
                'phone' => $validated['phone'],
            ]);
        }

        // Update user email
        $user->update([
            'email' => $validated['email'],
        ]);

        return redirect()
            ->back()
            ->with('success', 'Profil berhasil diperbarui.');
    }

    /**
     * Update password.
     */
    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => 'required|current_password',
            'password' => 'required|string|min:8|confirmed',
        ]);

        Auth::user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()
            ->back()
            ->with('success', 'Password berhasil diperbarui.');
    }
}
