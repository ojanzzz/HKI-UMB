@extends('layouts.app')

@section('title', 'Pendaftaran Akun Pemohon - Sistem Informasi KI UM BIMA')

@section('content')
<div class="max-w-2xl mx-auto my-10 p-6 md:p-8 bg-white rounded-2xl border border-slate-200 shadow-xl space-y-6">
    <!-- Header Title Banner -->
    <div class="border-b border-slate-200 pb-5 text-center space-y-2">
        <span class="bg-[#064E3B] text-white text-[10px] font-extrabold px-3 py-1 rounded-full uppercase tracking-wider">
            REGISTRASI PEMOHON BARU
        </span>
        <h2 class="text-2xl font-extrabold text-slate-900 uppercase tracking-tight">Form Pendaftaran Akun KI</h2>
        <p class="text-xs text-slate-500 max-w-md mx-auto">
            Daftarkan akun sivitas akademika (Dosen, Peneliti, Mahasiswa) atau mitra UMKM untuk mulai mengajukan Kekayaan Intelektual ke DJKI.
        </p>
    </div>

    <!-- Registration Form -->
    <form action="{{ route('register.post') }}" method="POST" enctype="multipart/form-data" id="registerForm" class="space-y-5 text-xs">
        @csrf
        <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response">

        <!-- 1. Nama Lengkap -->
        <div>
            <label for="name" class="block font-bold text-slate-800 uppercase tracking-wide mb-1">
                Nama Lengkap & Gelar <span class="text-red-600">*</span>
            </label>
            <input type="text" id="name" name="name" required value="{{ old('name') }}" placeholder="Contoh: Dr. Ahmad Dahlan, M.T." class="w-full border border-slate-300 rounded-xl p-3.5 text-slate-900 font-medium focus:outline-none focus:border-emerald-600 shadow-xs">
            @error('name')
                <span class="text-red-600 text-[11px] font-semibold mt-1 block">{{ $message }}</span>
            @enderror
        </div>

        <!-- 2. Email & Phone Number Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="email" class="block font-bold text-slate-800 uppercase tracking-wide mb-1">
                    Alamat Email <span class="text-red-600">*</span>
                </label>
                <input type="email" id="email" name="email" required value="{{ old('email') }}" placeholder="contoh: nama@umbima.ac.id" class="w-full border border-slate-300 rounded-xl p-3.5 text-slate-900 font-medium focus:outline-none focus:border-emerald-600 shadow-xs">
                @error('email')
                    <span class="text-red-600 text-[11px] font-semibold mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="phone_number" class="block font-bold text-slate-800 uppercase tracking-wide mb-1">
                    Nomor WhatsApp Aktif <span class="text-red-600">*</span>
                </label>
                <input type="text" id="phone_number" name="phone_number" required value="{{ old('phone_number') }}" placeholder="Contoh: 081234567890" class="w-full border border-slate-300 rounded-xl p-3.5 text-slate-900 font-medium focus:outline-none focus:border-emerald-600 shadow-xs">
                @error('phone_number')
                    <span class="text-red-600 text-[11px] font-semibold mt-1 block">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <!-- 3. NIK / NIP / NIM & Fakultas Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="identity_number" class="block font-bold text-slate-800 uppercase tracking-wide mb-1">
                    NIK / NIP / NIM <span class="text-red-600">*</span>
                </label>
                <input type="text" id="identity_number" name="identity_number" required value="{{ old('identity_number') }}" placeholder="Contoh: 5206010101900001" class="w-full border border-slate-300 rounded-xl p-3.5 text-slate-900 font-medium focus:outline-none focus:border-emerald-600 shadow-xs font-mono">
                @error('identity_number')
                    <span class="text-red-600 text-[11px] font-semibold mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="faculty" class="block font-bold text-slate-800 uppercase tracking-wide mb-1">
                    Fakultas / Unit Kerja <span class="text-red-600">*</span>
                </label>
                <select id="faculty" name="faculty" required class="w-full border border-slate-300 rounded-xl p-3.5 text-slate-900 font-medium focus:outline-none focus:border-emerald-600 shadow-xs bg-white">
                    <option value="">-- Pilih Fakultas / Unit Kerja --</option>
                    @foreach($faculties as $f)
                        <option value="{{ $f->name }}" {{ old('faculty') == $f->name ? 'selected' : '' }}>
                            {{ $f->name }}
                        </option>
                    @endforeach
                    @if($faculties->isEmpty())
                        <option value="Fakultas Teknik & Ilmu Komputer" selected>Fakultas Teknik & Ilmu Komputer</option>
                        <option value="Fakultas Hukum & Humaniora">Fakultas Hukum & Humaniora</option>
                        <option value="Fakultas Ekonomi & Bisnis">Fakultas Ekonomi & Bisnis</option>
                        <option value="Fakultas Keguruan & Ilmu Pendidikan">Fakultas Keguruan & Ilmu Pendidikan</option>
                        <option value="Mitra UMKM / Umum">Mitra UMKM / Umum</option>
                    @endif
                </select>
                @error('faculty')
                    <span class="text-red-600 text-[11px] font-semibold mt-1 block">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <!-- 4. Upload File KTP (Required) -->
        <div class="bg-emerald-50/60 border border-emerald-200 rounded-xl p-4 space-y-2">
            <label for="ktp_file" class="block font-extrabold text-slate-900 uppercase text-xs">
                📄 Upload Scan / Foto KTP <span class="text-red-600">*</span>
            </label>
            <input type="file" id="ktp_file" name="ktp_file" required accept="image/jpeg,image/png,image/jpg,application/pdf" class="w-full text-xs text-slate-600 border border-slate-300 rounded-lg bg-white p-2 file:mr-3 file:py-1 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-bold file:bg-[#064E3B] file:text-white hover:file:bg-[#047857]">
            <p class="text-[10px] text-slate-500">Format yang diizinkan: JPG, PNG, JPEG, PDF (Maksimal 5MB). Data KTP digunakan untuk proses verifikasi identitas resmi sivitas.</p>
            @error('ktp_file')
                <span class="text-red-600 text-[11px] font-semibold mt-1 block">{{ $message }}</span>
            @enderror
        </div>

        <!-- 5. Password & Confirmation Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="password" class="block font-bold text-slate-800 uppercase tracking-wide mb-1">
                    Password <span class="text-red-600">*</span>
                </label>
                <input type="password" id="password" name="password" required placeholder="Minimal 8 karakter" class="w-full border border-slate-300 rounded-xl p-3.5 text-slate-900 font-medium focus:outline-none focus:border-emerald-600 shadow-xs">
                @error('password')
                    <span class="text-red-600 text-[11px] font-semibold mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="password_confirmation" class="block font-bold text-slate-800 uppercase tracking-wide mb-1">
                    Konfirmasi Password <span class="text-red-600">*</span>
                </label>
                <input type="password" id="password_confirmation" name="password_confirmation" required placeholder="Ulangi password di atas" class="w-full border border-slate-300 rounded-xl p-3.5 text-slate-900 font-medium focus:outline-none focus:border-emerald-600 shadow-xs">
            </div>
        </div>

        <!-- Submit Button -->
        <div class="pt-3">
            <button type="submit" class="w-full bg-[#064E3B] hover:bg-[#047857] text-white font-extrabold py-3.5 px-6 rounded-xl text-xs uppercase tracking-wider transition shadow-md flex items-center justify-center space-x-2">
                <span>DAFTAR AKUN PEMOHON BARU</span>
                <span>&rarr;</span>
            </button>
        </div>
    </form>

    <!-- Footer SSO & Login Link -->
    <div class="border-t border-slate-200 pt-5 text-center space-y-4 text-xs">
        <div class="text-slate-500">
            Sudah memiliki akun?
            <a href="{{ route('login') }}" class="font-extrabold text-emerald-800 hover:text-emerald-900 underline">
                Masuk di Sini
            </a>
        </div>

        <div class="relative flex py-2 items-center">
            <div class="flex-grow border-t border-slate-200"></div>
            <span class="flex-shrink mx-4 text-[10px] font-extrabold text-slate-400 uppercase tracking-widest">ATAU MASUK TANPA DAFTAR</span>
            <div class="flex-grow border-t border-slate-200"></div>
        </div>

        <a href="{{ route('auth.google') }}" class="w-full bg-white hover:bg-slate-50 text-slate-800 border border-slate-300 font-bold py-3 px-4 rounded-xl transition shadow-xs flex items-center justify-center space-x-3 text-xs">
            <svg class="w-4 h-4" viewBox="0 0 24 24">
                <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/>
                <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/>
            </svg>
            <span>Daftar / Masuk Instan dengan Google SSO</span>
        </a>
    </div>
</div>

@push('scripts')
@if(config('services.recaptcha.site_key'))
<script src="https://www.google.com/recaptcha/api.js?render={{ config('services.recaptcha.site_key') }}"></script>
@endif
<script>
    @if(config('services.recaptcha.site_key'))
    document.getElementById('registerForm')?.addEventListener('submit', function(e) {
        var siteKey = @json(config('services.recaptcha.site_key'));
        if (siteKey && typeof grecaptcha !== 'undefined') {
            e.preventDefault();
            var form = this;
            grecaptcha.ready(function() {
                grecaptcha.execute(siteKey, {action: 'register'}).then(function(token) {
                    document.getElementById('g-recaptcha-response').value = token;
                    form.submit();
                }).catch(function(err) {
                    console.error('reCAPTCHA error:', err);
                    form.submit();
                });
            });
        }
    });
    @endif
</script>
@endpush
@endsection
