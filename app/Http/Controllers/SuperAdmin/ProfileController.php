<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Display SuperAdmin profile.
     */
    public function show()
    {
        $user = Auth::user()->load('person', 'roles');

        // Get SuperAdmin statistics
        $stats = [
            'total_approvals' => $user->approvedUnits()->count(),
            'pending_approvals' => \App\Models\Unit::pending()->count(),
            'total_units' => \App\Models\Unit::count(),
            'total_santri' => \App\Models\Santri::count(),
        ];

        return view('superadmin.profile', compact('user', 'stats'));
    }

    /**
     * Update SuperAdmin profile.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'required|string|max:255',
        ]);

        // Update person data
        if ($user->person) {
            $user->person->update([
                'full_name' => $validated['full_name'],
                'phone' => $validated['phone'] ?? $user->person->phone,
            ]);
        }

        // Update user email
        $user->update([
            'email' => $validated['email'],
        ]);

        return redirect()->route('superadmin.profile')
            ->with('success', 'Profil berhasil diperbarui');
    }

    /**
     * Update SuperAdmin password.
     */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'current_password' => 'required|string',
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        // Verify current password
        if (!Hash::check($validated['current_password'], $user->password)) {
            return back()->withErrors([
                'current_password' => 'Password saat ini tidak sesuai',
            ]);
        }

        // Update password
        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('superadmin.profile')
            ->with('success', 'Password berhasil diperbarui');
    }
}
