<?php

namespace App\Http\Controllers\Lpptka;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Display Admin LPPTKA profile.
     */
    public function show()
    {
        $user = Auth::user()->load('person', 'roles');

        // Get LPPTKA statistics
        $stats = [
            'total_units' => \App\Models\Unit::count(),
            'pending_units' => \App\Models\Unit::pending()->count(),
            'approved_units' => \App\Models\Unit::approved()->count(),
            'active_accounts' => \App\Models\User::whereHas('roles', function ($q) {
                $q->where('role', 'admin_tpa');
            })->where('is_active', true)->count(),
        ];

        return view('lpptka.profile', compact('user', 'stats'));
    }

    /**
     * Update Admin LPPTKA profile.
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

        return redirect()->route('lpptka.profile')
            ->with('success', 'Profil berhasil diperbarui');
    }

    /**
     * Update Admin LPPTKA password.
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
            return redirect()->back()
                ->withErrors(['current_password' => 'Password saat ini tidak sesuai'])
                ->withInput();
        }

        // Update password
        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('lpptka.profile')
            ->with('success', 'Password berhasil diperbarui');
    }
}
