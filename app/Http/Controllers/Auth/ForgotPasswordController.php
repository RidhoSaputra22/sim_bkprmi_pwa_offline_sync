<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\ResetPasswordMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Log;

class ForgotPasswordController extends Controller
{
    /**
     * Tampilkan form forgot password
     */
    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * Kirim email reset password
     */
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.exists' => 'Email tidak terdaftar dalam sistem.',
        ]);

        // Cek apakah sudah ada token yang aktif (dalam 1 jam terakhir)
        $existingToken = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        if ($existingToken && now()->diffInMinutes($existingToken->created_at) < 60) {
            return back()->with('info', 'Link reset password sudah dikirim ke email Anda. Silakan cek inbox atau spam folder.');
        }

        // dd($existingToken);
        // Generate token
        $token = Str::random(64);

        // Simpan atau update token

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'token' => Hash::make($token),
                'created_at' => now(),
            ]
        );

        // Kirim email
        $user = User::where('email', $request->email)->first();

        try {
            Mail::to($request->email)->send(new ResetPasswordMail($token, $user));

            return back()->with('success', 'Link reset password telah dikirim ke email Anda. Silakan cek inbox atau spam folder.');
        } catch (\Exception $e) {
            Log::error('Error sending reset password email: '.$e->getMessage());
            DB::table('password_reset_tokens')->where('email', $request->email)->delete();

            return back()->with('error', 'Gagal mengirim email. Silakan coba lagi atau hubungi administrator.');
        }
    }
}
