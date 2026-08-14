<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Faculty;
use App\Models\User;
use App\Services\MultiChannelAlertService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class RegisterController extends Controller
{
    /**
     * Tampilkan formulir pendaftaran akun pemohon baru.
     */
    public function showRegistrationForm()
    {
        if (Auth::check()) {
            return redirect()->route('user.dashboard');
        }

        $faculties = Faculty::orderBy('name')->get();
        $activeTab = 'register';
        return view('auth.unified', compact('faculties', 'activeTab'));
    }

    /**
     * Proses pendaftaran akun pemohon baru.
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'identity_number' => 'required|string|max:50',
            'phone_number' => 'required|string|max:20',
            'faculty' => 'required|string|max:255',
            'ktp_file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.unique' => 'Email ini sudah terdaftar. Silakan gunakan email lain atau login.',
            'identity_number.required' => 'NIK / NIP / NIM wajib diisi.',
            'phone_number.required' => 'Nomor WhatsApp aktif wajib diisi.',
            'faculty.required' => 'Pilih Fakultas / Unit Kerja Anda.',
            'ktp_file.required' => 'File KTP wajib diunggah.',
            'ktp_file.mimes' => 'Format file KTP harus berupa JPG, PNG, JPEG, atau PDF.',
            'ktp_file.max' => 'Ukuran file KTP maksimal 5MB.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal terdiri dari 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $recaptchaSecret = config('services.recaptcha.secret_key');
        if (!empty($recaptchaSecret)) {
            $token = $request->input('g-recaptcha-response');
            if (empty($token)) {
                return redirect()->back()
                    ->withInput($request->except('ktp_file'))
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
                    ->withInput($request->except('ktp_file'))
                    ->with('error', 'Verifikasi reCAPTCHA gagal (terdeteksi aktivitas mencurigakan). Silakan coba lagi.');
            }
        }

        // Store KTP File in storage/app/public/ktp_files
        $ktpPath = $request->file('ktp_file')->store('ktp_files', 'public');

        // Create Applicant User (role = user, status = pending)
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
            'identity_number' => $request->identity_number,
            'nik' => $request->identity_number,
            'phone_number' => $request->phone_number,
            'faculty' => $request->faculty,
            'ktp_path' => $ktpPath,
            'status' => 'pending',
        ]);

        // Log Activity
        ActivityLog::log('REGISTER', "Pengguna mendaftar akun baru (#{$user->id}: {$user->name} - {$user->email}).", $user);

        // Notify Admins
        MultiChannelAlertService::notifyAdmins(
            'USER_REGISTERED',
            'Pendaftaran Akun Baru',
            "Pengguna baru {$user->name} ({$user->faculty}) telah mendaftar dan menunggu verifikasi Admin.",
            route('admin.users')
        );

        // Auto-login registered user and redirect to pending status notice page
        Auth::login($user);

        return redirect()->route('profile.pending')
            ->with('success', 'Pendaftaran akun berhasil! Data Anda sedang dalam proses verifikasi oleh Administrator KI UM Bima.');
    }
}
