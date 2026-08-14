<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    /**
     * Redirect ke halaman autentikasi Google SSO.
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Callback dari Google SSO.
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            $user = User::where('google_id', $googleUser->id)
                ->orWhere('email', $googleUser->email)
                ->first();

            if ($user) {
                $user->update([
                    'google_id' => $googleUser->id,
                    'avatar' => $googleUser->avatar ?? $user->avatar,
                ]);
            } else {
                $user = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'avatar' => $googleUser->avatar,
                    'role' => 'user',
                    'status' => 'pending', // Akun di-set ke pending sampai Admin approve
                    'password' => bcrypt(Str::random(16)),
                ]);
            }

            Auth::login($user);

            // Jika profil belum lengkap, redirect ke pengisian profil
            if (empty($user->identity_number) || empty($user->faculty) || empty($user->phone_number)) {
                return redirect()->route('profile.complete')
                    ->with('warning', 'Silakan lengkapi data profil (NIM/NIP/NIK, Fakultas, WA) untuk melanjutkan.');
            }

            // Jika masih status pending
            if ($user->status === 'pending') {
                return redirect()->route('profile.pending')
                    ->with('info', 'Akun Anda telah terdaftar dan sedang menunggu approval Admin.');
            }

            return redirect()->route('user.dashboard')->with('success', 'Selamat datang di Sistem Informasi KI UM BIMA!');

        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Gagal login via Google: ' . $e->getMessage());
        }
    }
}
