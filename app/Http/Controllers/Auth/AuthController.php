<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Show login form.
     */
    public function showLoginForm()
    {

        return view('auth.login');
    }

    /**
     * Handle login request.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Redirect based on role
            if ($user->isSuperAdmin()) {
                return redirect()->intended(route('superadmin.dashboard'));
            }

            if ($user->isAdminLpptka()) {
                return redirect()->intended(route('lpptka.dashboard'));
            }

            if ($user->isAdminTpa()) {
                return redirect()->intended(route('tpa.dashboard'));
            }

            // Fallback - logout jika role tidak dikenali
            Auth::logout();
            return back()->withErrors([
                'email' => 'Role pengguna tidak valid.',
            ])->onlyInput('email');
        }

        return back()->withErrors([
            'email' => 'Email atau password tidak valid.',
        ])->onlyInput('email');
    }

    /**
     * Handle logout request.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
