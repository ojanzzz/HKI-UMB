<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForceProfileCompletion
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && $user->role === 'user') {
            $allowedRoutes = ['profile.complete', 'profile.save', 'profile.pending', 'logout'];
            $currentRouteName = $request->route() ? $request->route()->getName() : null;

            // NIK (Wajib), Phone (Wajib), Upload KTP (Wajib). NIP, NIM, dan Fakultas (Opsional).
            $isProfileIncomplete = empty($user->nik) || empty($user->phone_number) || empty($user->ktp_path);

            if ($isProfileIncomplete && !in_array($currentRouteName, ['profile.complete', 'profile.save', 'logout'])) {
                return redirect()->route('profile.complete')
                    ->with('warning', 'Silakan lengkapi NIK, No. WA, dan Upload KTP Anda terlebih dahulu.');
            }

            // 2. Cek apakah status akun masih 'pending' approval dari Admin
            if (!$isProfileIncomplete && $user->status === 'pending' && !in_array($currentRouteName, ['profile.pending', 'logout'])) {
                return redirect()->route('profile.pending')
                    ->with('info', 'Akun Anda sedang menunggu verifikasi/approval dari Administrator HKI UMB.');
            }
        }

        return $next($request);
    }
}
