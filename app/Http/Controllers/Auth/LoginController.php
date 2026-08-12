<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            return Auth::user()->isAdmin() 
                ? redirect()->route('admin.dashboard') 
                : redirect()->route('user.dashboard');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->has('remember'))) {
            $request->session()->regenerate();

            /** @var \App\Models\User $user */
            $user = Auth::user();

            // Catat Activity Log Login
            ActivityLog::log('LOGIN', 'Pengguna berhasil login ke portal HKI UM BIMA.', $user);

            if ($user->isAdmin()) {
                return redirect()->intended(route('admin.dashboard'))
                    ->with('success', 'Selamat datang di Panel Admin Sentra HKI UMB.');
            }

            // Jika profil user belum lengkap
            if (empty($user->nik) || empty($user->phone_number) || empty($user->ktp_path)) {
                return redirect()->route('profile.complete')
                    ->with('warning', 'Silakan lengkapi NIK, No. WA, dan Upload KTP terlebih dahulu.');
            }

            // Jika akun masih pending
            if ($user->status === 'pending') {
                return redirect()->route('profile.pending')
                    ->with('info', 'Akun Anda sedang menunggu verifikasi/approval dari Administrator HKI UMB.');
            }

            return redirect()->intended(route('user.dashboard'))
                ->with('success', 'Selamat datang, ' . $user->name . '!');
        }

        return redirect()->back()
            ->withInput($request->only('email'))
            ->with('error', 'Email atau password yang Anda masukkan salah.');
    }
}
