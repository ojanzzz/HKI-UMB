@extends('layouts.app')

@section('title', 'Menunggu Approval Admin - Sistem Informasi HKI UMB')

@section('content')
<div class="max-w-xl mx-auto my-12 p-8 bg-white rounded-xl border border-slate-200 shadow-md text-center">
    <div class="w-16 h-16 bg-amber-100 text-amber-600 rounded-full flex items-center justify-center mx-auto mb-4 text-2xl font-bold">
        ⏳
    </div>
    <span class="bg-amber-500 text-white text-[10px] font-extrabold px-3 py-1 rounded uppercase tracking-wider">
        STATUS AKUN: PENDING VERIFIKASI
    </span>
    <h2 class="text-xl font-extrabold text-slate-900 uppercase tracking-tight mt-3">Akun Anda Dalam Proses Pengawasan Admin</h2>
    <p class="text-xs text-slate-600 leading-relaxed mt-2 max-w-md mx-auto">
        Terima kasih telah melengkapi profil Anda, <span class="font-bold text-slate-900">{{ $user->name }}</span>. Administrator Sentra HKI UMB sedang melakukan pengecekan data identitas (<span class="font-semibold">{{ $user->identity_number }}</span> - {{ $user->faculty }}).
    </p>

    <div class="bg-slate-50 border border-slate-200 rounded-lg p-4 mt-6 text-left text-xs space-y-2">
        <div class="font-bold text-slate-800 uppercase tracking-wide">Detail Pengajuan Akun:</div>
        <div class="flex justify-between border-b border-slate-200 py-1 text-slate-600">
            <span>Nama:</span>
            <span class="font-bold text-slate-900">{{ $user->name }}</span>
        </div>
        <div class="flex justify-between border-b border-slate-200 py-1 text-slate-600">
            <span>NIM/NIP/NIK:</span>
            <span class="font-bold text-slate-900">{{ $user->identity_number }}</span>
        </div>
        <div class="flex justify-between border-b border-slate-200 py-1 text-slate-600">
            <span>Fakultas:</span>
            <span class="font-bold text-slate-900">{{ $user->faculty }}</span>
        </div>
        <div class="flex justify-between py-1 text-slate-600">
            <span>Nomor WhatsApp:</span>
            <span class="font-bold text-slate-900">{{ $user->phone_number }}</span>
        </div>
    </div>

    <div class="mt-6 text-xs text-slate-500">
        Setelah akun disetujui (Approved) oleh Admin, Anda akan otomatis dapat mengakses seluruh menu pengajuan HKI dan E-Signature.
    </div>

    <div class="mt-6 flex justify-center gap-3">
        <a href="{{ route('home') }}" class="bg-[#002855] hover:bg-[#003366] text-white px-5 py-2.5 rounded-md text-xs font-bold uppercase tracking-wider">
            KEMBALI KE BERANDA
        </a>
    </div>
</div>
@endsection
