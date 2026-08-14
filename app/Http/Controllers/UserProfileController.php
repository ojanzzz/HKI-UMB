<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Services\MultiChannelAlertService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserProfileController extends Controller
{
    public function showCompleteForm()
    {
        $user = Auth::user();
        return view('profile.complete', compact('user'));
    }

    public function saveProfile(Request $request)
    {
        $request->validate([
            'nik' => 'required|string|max:30',
            'nip' => 'nullable|string|max:30',
            'nim' => 'nullable|string|max:30',
            'ktp' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5000',
            'faculty' => 'nullable|string|max:255',
            'phone_number' => 'required|string|max:30',
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();

        $ktpPath = $request->file('ktp')->store('ktp_files/' . $user->id, 'public');

        $user->update([
            'nik' => $request->nik,
            'nip' => $request->nip,
            'nim' => $request->nim,
            'ktp_path' => $ktpPath,
            'identity_number' => $request->nik,
            'faculty' => $request->faculty,
            'phone_number' => $request->phone_number,
        ]);

        // Activity Log & Multi-Channel Alert ke Admin
        ActivityLog::log('REGISTER', 'Pengguna baru melengkapi profil NIK & KTP.', $user);

        MultiChannelAlertService::notifyAdmins(
            'NEW_USER_REGISTERED',
            'Pengguna Baru Melengkapi Registrasi',
            "Pengguna {$user->name} ({$user->email}, NIK: {$user->nik}) telah melengkapi profil dan dokumen KTP. Menunggu verifikasi Anda.",
            route('admin.users')
        );

        if ($user->status === 'pending') {
            return redirect()->route('profile.pending')
                ->with('success', 'Profil dan Dokumen KTP berhasil disimpan. Akun Anda saat ini menunggu verifikasi (Approve) oleh Admin KI UM BIMA.');
        }

        return redirect()->route('user.dashboard')->with('success', 'Profil berhasil diperbarui!');
    }

    public function showPendingNotice()
    {
        $user = Auth::user();
        return view('profile.pending', compact('user'));
    }

    /**
     * Tampilkan Form Edit Profil Pemohon.
     */
    public function editProfile()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    /**
     * Simpan Perubahan Profil Pemohon.
     */
    public function updateProfile(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'nik' => 'required|string|max:30',
            'nip' => 'nullable|string|max:30',
            'nim' => 'nullable|string|max:30',
            'ktp' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5000',
            'faculty' => 'nullable|string|max:255',
            'phone_number' => 'required|string|max:30',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $data = [
            'name' => $request->name,
            'nik' => $request->nik,
            'nip' => $request->nip,
            'nim' => $request->nim,
            'identity_number' => $request->nik,
            'faculty' => $request->faculty,
            'phone_number' => $request->phone_number,
        ];

        if ($request->hasFile('ktp')) {
            if ($user->ktp_path && Storage::disk('public')->exists($user->ktp_path)) {
                Storage::disk('public')->delete($user->ktp_path);
            }
            $data['ktp_path'] = $request->file('ktp')->store('ktp_files/' . $user->id, 'public');
        }

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        ActivityLog::log('UPDATE_PROFILE', 'Pengguna memperbarui data profil.', $user);

        return redirect()->back()->with('success', 'Data profil dan KTP berhasil diperbarui!');
    }
}
