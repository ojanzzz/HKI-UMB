<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            return Auth::user()->isAdmin() 
                ? redirect()->route('admin.dashboard') 
                : redirect()->route('user.dashboard');
        }
        return view('auth.unified', ['activeTab' => 'login', 'faculties' => \App\Models\Faculty::orderBy('name')->get()]);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $recaptchaSecret = config('services.recaptcha.secret_key');
        if (!empty($recaptchaSecret)) {
            $token = $request->input('g-recaptcha-response');
            if (empty($token)) {
                return redirect()->back()
                    ->withInput($request->only('email'))
                    ->with('error', 'Verifikasi reCAPTCHA gagal atau token tidak ditemukan. Silakan coba lagi.');
            }

            $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret' => $recaptchaSecret,
                'response' => $token,
                'remoteip' => $request->ip(),
            ]);

            $threshold = (float) config('services.recaptcha.score_threshold', 0.5);
            $success = $response->json('success', false);
            $score = (float) $response->json('score', 0);

            if (!$success || $score < $threshold) {
                return redirect()->back()
                    ->withInput($request->only('email'))
                    ->with('error', 'Verifikasi reCAPTCHA gagal (terdeteksi aktivitas mencurigakan). Silakan coba lagi.');
            }
        }

        if (Auth::attempt($credentials, $request->has('remember'))) {
            $request->session()->regenerate();

            /** @var \App\Models\User $user */
            $user = Auth::user();

            // Catat Activity Log Login
            ActivityLog::log('LOGIN', 'Pengguna berhasil login ke portal KI UM BIMA.', $user);

            if ($user->isAdmin()) {
                return redirect()->intended(route('admin.dashboard'))
                    ->with('success', 'Selamat datang di Panel Admin Direktorat Inovasi & KI UM Bima.');
            }

            // Jika profil user belum lengkap
            if (empty($user->identity_number) || empty($user->ktp_path) || empty($user->phone_number)) {
                return redirect()->route('profile.complete')
                    ->with('info', 'Silakan lengkapi profil Anda (NIK, Upload KTP, & Nomor WA) terlebih dahulu.');
            }

            // Jika akun masih pending
            if ($user->status === 'pending') {
                return redirect()->route('profile.pending')
                    ->with('info', 'Akun Anda sedang menunggu verifikasi/approval dari Administrator KI UM BIMA.');
            }

            return redirect()->intended(route('user.dashboard'))
                ->with('success', 'Selamat datang, ' . $user->name . '!');
        }

        return redirect()->back()
            ->withInput($request->only('email'))
            ->with('error', 'Email atau password yang Anda masukkan salah.');
    }
}
