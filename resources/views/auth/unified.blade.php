@extends('layouts.app')

@section('title', 'Masuk - Sistem Informasi KI UM BIMA')

@section('content')
@php
    $activeTab = $activeTab ?? 'login';
@endphp
<div class="min-h-[calc(100vh-200px)] flex items-center justify-center py-10 px-4">
    <div class="w-full max-w-5xl">
        <div class="bg-white rounded-3xl border border-slate-200 shadow-2xl overflow-hidden">
            <div class="grid grid-cols-1 lg:grid-cols-2">
                
                <!-- LEFT SIDE: Brand & Info -->
                <div class="bg-gradient-to-br from-[#064E3B] to-[#047857] p-8 md:p-10 flex flex-col justify-between text-white relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full -translate-y-1/2 translate-x-1/2"></div>
                    <div class="absolute bottom-0 left-0 w-48 h-48 bg-white/5 rounded-full translate-y-1/2 -translate-x-1/2"></div>
                    
                    <div class="relative z-10">
                        <div class="flex items-center space-x-3 mb-8">
                            <img src="{{ asset('logo/logo.png') }}" alt="Logo KI UMB" class="w-12 h-12 object-contain drop-shadow-md">
                            <div>
                                <h2 class="text-sm font-extrabold leading-tight tracking-tight">DIREKTORAT INOVASI & KI</h2>
                                <p class="text-[10px] text-emerald-200 font-bold uppercase tracking-widest">Universitas Muhammadiyah Bima</p>
                            </div>
                        </div>
                        
                        <h3 class="text-2xl md:text-3xl font-extrabold leading-tight mb-4">
                            Selamat Datang di<br>Portal KI UM BIMA
                        </h3>
                        <p class="text-sm text-emerald-100 leading-relaxed mb-8">
                            Akses sistem untuk mengajukan dan mengelola permohonan Kekayaan Intelektual (Paten, Hak Cipta, Desain Industri) ke DJKI Kemenkumham RI.
                        </p>
                    </div>

                    <div class="relative z-10 space-y-4">
                        <div class="flex items-start space-x-3">
                            <div class="w-8 h-8 bg-white/10 rounded-lg flex items-center justify-center shrink-0 mt-0.5">
                                <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            </div>
                            <div>
                                <h4 class="text-xs font-bold uppercase tracking-wider text-amber-300">Pengajuan Online</h4>
                                <p class="text-[11px] text-emerald-100 mt-0.5">Daftar Paten, Hak Cipta, dan Desain Industri secara digital</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-3">
                            <div class="w-8 h-8 bg-white/10 rounded-lg flex items-center justify-center shrink-0 mt-0.5">
                                <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                            </div>
                            <div>
                                <h4 class="text-xs font-bold uppercase tracking-wider text-amber-300">Terintegrasi DJKI</h4>
                                <p class="text-[11px] text-emerald-100 mt-0.5">Sinkronisasi data dengan Portal DJKI Kemenkumham RI</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-3">
                            <div class="w-8 h-8 bg-white/10 rounded-lg flex items-center justify-center shrink-0 mt-0.5">
                                <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            </div>
                            <div>
                                <h4 class="text-xs font-bold uppercase tracking-wider text-amber-300">Aman & Terpercaya</h4>
                                <p class="text-[11px] text-emerald-100 mt-0.5">Data terenkripsi dan verifikasi identitas resmi</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- RIGHT SIDE: Auth Forms -->
                <div class="p-6 md:p-10">
                    <!-- Tab Switcher -->
                    <div class="flex mb-8 bg-slate-100 rounded-xl p-1">
                        <button type="button" id="tab-login" onclick="switchTab('login')" class="flex-1 py-2.5 px-4 rounded-lg text-xs font-extrabold uppercase tracking-wider transition-all duration-200 {{ $activeTab === 'login' ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-500 hover:text-slate-700' }}">
                            Masuk
                        </button>
                        <button type="button" id="tab-register" onclick="switchTab('register')" class="flex-1 py-2.5 px-4 rounded-lg text-xs font-extrabold uppercase tracking-wider transition-all duration-200 {{ $activeTab === 'register' ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-500 hover:text-slate-700' }}">
                            Daftar Akun
                        </button>
                    </div>

                    <!-- Login Form -->
                    <div id="form-login">
                        <div class="mb-6">
                            <h3 class="text-lg font-extrabold text-slate-900 uppercase tracking-tight">Masuk ke Akun</h3>
                            <p class="text-xs text-slate-500 mt-1">Gunakan email dan password Anda</p>
                        </div>

                        <form id="loginForm" action="{{ route('login.post') }}" method="POST" class="space-y-4 text-xs">
                            @csrf
                            <input type="hidden" name="g-recaptcha-response" id="login-recaptcha-response">
                            <div>
                                <label for="login_email" class="block font-bold text-slate-700 uppercase tracking-wide mb-1">Email <span class="text-red-600">*</span></label>
                                <input type="email" id="login_email" name="email" value="{{ old('email') }}" required placeholder="email@umb.ac.id" class="w-full border border-slate-300 rounded-xl py-2.5 px-3.5 text-slate-900 focus:outline-none focus:border-emerald-600 font-medium bg-slate-50/50">
                                @error('email') <span class="text-red-600 font-semibold mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="login_password" class="block font-bold text-slate-700 uppercase tracking-wide mb-1">Password <span class="text-red-600">*</span></label>
                                <input type="password" id="login_password" name="password" required placeholder="••••••••" class="w-full border border-slate-300 rounded-xl py-2.5 px-3.5 text-slate-900 focus:outline-none focus:border-emerald-600 font-medium bg-slate-50/50">
                                @error('password') <span class="text-red-600 font-semibold mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div class="flex items-center justify-between">
                                <label class="flex items-center space-x-2 cursor-pointer">
                                    <input type="checkbox" name="remember" class="rounded text-emerald-600 focus:ring-emerald-500">
                                    <span class="text-slate-600 font-semibold">Ingat Saya</span>
                                </label>
                            </div>

                            <button type="submit" class="w-full bg-[#064E3B] hover:bg-[#047857] text-white py-3 px-4 rounded-xl font-bold text-xs uppercase tracking-wider transition shadow-md">
                                MASUK APLIKASI
                            </button>
                        </form>

                        <div class="relative flex py-4 items-center mb-4">
                            <div class="flex-grow border-t border-slate-200"></div>
                            <span class="flex-shrink mx-4 text-[10px] text-slate-400 font-bold uppercase tracking-wider">ATAU</span>
                            <div class="flex-grow border-t border-slate-200"></div>
                        </div>

                        <a href="{{ route('auth.google') }}" class="w-full bg-white hover:bg-slate-50 text-slate-800 border border-slate-300 font-bold py-2.5 px-4 rounded-xl transition shadow-xs flex items-center justify-center space-x-3 text-xs">
                            <svg class="w-4 h-4" viewBox="0 0 24 24">
                                <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                                <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                                <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/>
                                <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/>
                            </svg>
                            <span>Login dengan Google SSO</span>
                        </a>

                        <!-- Quick Auto-Fill Demo Akun untuk Testing -->
                        <div class="mt-6 bg-slate-50 border border-slate-200 p-4 rounded-xl space-y-2 text-xs">
                            <div class="font-extrabold text-slate-900 uppercase tracking-wide text-[10px] mb-2">Quick Login Testing:</div>
                            <div class="grid grid-cols-3 gap-2">
                                <button onclick="fillLogin('admin@umb.ac.id', 'password123')" class="bg-slate-200 hover:bg-slate-300 text-slate-800 p-2 rounded-lg text-[10px] font-bold uppercase text-center transition">Admin</button>
                                <button onclick="fillLogin('budi.santoso@umb.ac.id', 'password123')" class="bg-slate-200 hover:bg-slate-300 text-slate-800 p-2 rounded-lg text-[10px] font-bold uppercase text-center transition">User Approved</button>
                                <button onclick="fillLogin('ahmad.rizal@umb.ac.id', 'password123')" class="bg-slate-200 hover:bg-slate-300 text-slate-800 p-2 rounded-lg text-[10px] font-bold uppercase text-center transition">User Pending</button>
                            </div>
                        </div>
                    </div>

                    <!-- Register Form (Hidden by default) -->
                    <div id="form-register" class="hidden">
                        <div class="mb-6">
                            <h3 class="text-lg font-extrabold text-slate-900 uppercase tracking-tight">Daftar Akun Baru</h3>
                            <p class="text-xs text-slate-500 mt-1">Untuk sivitas akademika UM BIMA</p>
                        </div>

                        <form action="{{ route('register.post') }}" method="POST" enctype="multipart/form-data" id="registerForm" class="space-y-3 text-xs">
                            @csrf
                            <input type="hidden" name="g-recaptcha-response" id="register-recaptcha-response">
                            
                            <div>
                                <label for="reg_name" class="block font-bold text-slate-700 uppercase tracking-wide mb-1">Nama Lengkap <span class="text-red-600">*</span></label>
                                <input type="text" id="reg_name" name="name" required value="{{ old('name') }}" placeholder="Dr. Ahmad Dahlan, M.T." class="w-full border border-slate-300 rounded-xl py-2.5 px-3.5 text-slate-900 focus:outline-none focus:border-emerald-600 font-medium bg-slate-50/50">
                                @error('name') <span class="text-red-600 font-semibold mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                <div>
                                    <label for="reg_email" class="block font-bold text-slate-700 uppercase tracking-wide mb-1">Email <span class="text-red-600">*</span></label>
                                    <input type="email" id="reg_email" name="email" required value="{{ old('email') }}" placeholder="nama@umbima.ac.id" class="w-full border border-slate-300 rounded-xl py-2.5 px-3.5 text-slate-900 focus:outline-none focus:border-emerald-600 font-medium bg-slate-50/50">
                                    @error('email') <span class="text-red-600 font-semibold mt-1 block">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label for="reg_phone" class="block font-bold text-slate-700 uppercase tracking-wide mb-1">No. WA <span class="text-red-600">*</span></label>
                                    <input type="text" id="reg_phone" name="phone_number" required value="{{ old('phone_number') }}" placeholder="081234567890" class="w-full border border-slate-300 rounded-xl py-2.5 px-3.5 text-slate-900 focus:outline-none focus:border-emerald-600 font-medium bg-slate-50/50">
                                    @error('phone_number') <span class="text-red-600 font-semibold mt-1 block">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                <div>
                                    <label for="reg_identity" class="block font-bold text-slate-700 uppercase tracking-wide mb-1">NIK / NIP / NIM <span class="text-red-600">*</span></label>
                                    <input type="text" id="reg_identity" name="identity_number" required value="{{ old('identity_number') }}" placeholder="5206010101900001" class="w-full border border-slate-300 rounded-xl py-2.5 px-3.5 text-slate-900 focus:outline-none focus:border-emerald-600 font-medium bg-slate-50/50 font-mono">
                                    @error('identity_number') <span class="text-red-600 font-semibold mt-1 block">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label for="reg_faculty" class="block font-bold text-slate-700 uppercase tracking-wide mb-1">Fakultas <span class="text-red-600">*</span></label>
                                    <select id="reg_faculty" name="faculty" required class="w-full border border-slate-300 rounded-xl py-2.5 px-3.5 text-slate-900 focus:outline-none focus:border-emerald-600 font-medium bg-slate-50/50 bg-white">
                                        <option value="">-- Pilih --</option>
                                        @foreach($faculties as $f)
                                            <option value="{{ $f->name }}" {{ old('faculty') == $f->name ? 'selected' : '' }}>{{ $f->name }}</option>
                                        @endforeach
                                        @if($faculties->isEmpty())
                                            <option value="Fakultas Teknik & Ilmu Komputer" selected>Fakultas Teknik & Ilmu Komputer</option>
                                            <option value="Fakultas Hukum & Humaniora">Fakultas Hukum & Humaniora</option>
                                            <option value="Fakultas Ekonomi & Bisnis">Fakultas Ekonomi & Bisnis</option>
                                            <option value="Fakultas Keguruan & Ilmu Pendidikan">Fakultas Keguruan & Ilmu Pendidikan</option>
                                            <option value="Mitra UMKM / Umum">Mitra UMKM / Umum</option>
                                        @endif
                                    </select>
                                    @error('faculty') <span class="text-red-600 font-semibold mt-1 block">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div>
                                <label for="reg_ktp" class="block font-bold text-slate-700 uppercase tracking-wide mb-1">Scan KTP <span class="text-red-600">*</span></label>
                                <input type="file" id="reg_ktp" name="ktp_file" required accept="image/jpeg,image/png,image/jpg,application/pdf" class="w-full text-xs text-slate-600 border border-slate-300 rounded-xl bg-white p-2 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-[#064E3B] file:text-white hover:file:bg-[#047857]">
                                <p class="text-[10px] text-slate-500 mt-1">JPG, PNG, PDF (Maks 5MB)</p>
                                @error('ktp_file') <span class="text-red-600 font-semibold mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                <div>
                                    <label for="reg_password" class="block font-bold text-slate-700 uppercase tracking-wide mb-1">Password <span class="text-red-600">*</span></label>
                                    <input type="password" id="reg_password" name="password" required placeholder="Minimal 8 karakter" class="w-full border border-slate-300 rounded-xl py-2.5 px-3.5 text-slate-900 focus:outline-none focus:border-emerald-600 font-medium bg-slate-50/50">
                                    @error('password') <span class="text-red-600 font-semibold mt-1 block">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label for="reg_password_confirmation" class="block font-bold text-slate-700 uppercase tracking-wide mb-1">Konfirmasi <span class="text-red-600">*</span></label>
                                    <input type="password" id="reg_password_confirmation" name="password_confirmation" required placeholder="Ulangi password" class="w-full border border-slate-300 rounded-xl py-2.5 px-3.5 text-slate-900 focus:outline-none focus:border-emerald-600 font-medium bg-slate-50/50">
                                </div>
                            </div>

                            <button type="submit" class="w-full bg-[#064E3B] hover:bg-[#047857] text-white font-extrabold py-3 px-6 rounded-xl text-xs uppercase tracking-wider transition shadow-md flex items-center justify-center space-x-2 mt-2">
                                <span>DAFTAR AKUN</span>
                                <span>&rarr;</span>
                            </button>
                        </form>

                        <div class="relative flex py-4 items-center mb-4 mt-4">
                            <div class="flex-grow border-t border-slate-200"></div>
                            <span class="flex-shrink mx-4 text-[10px] text-slate-400 font-bold uppercase tracking-wider">ATAU</span>
                            <div class="flex-grow border-t border-slate-200"></div>
                        </div>

                        <a href="{{ route('auth.google') }}" class="w-full bg-white hover:bg-slate-50 text-slate-800 border border-slate-300 font-bold py-2.5 px-4 rounded-xl transition shadow-xs flex items-center justify-center space-x-3 text-xs">
                            <svg class="w-4 h-4" viewBox="0 0 24 24">
                                <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                                <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                                <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/>
                                <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/>
                            </svg>
                            <span>Daftar / Masuk dengan Google SSO</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
@if(config('services.recaptcha.site_key'))
<script src="https://www.google.com/recaptcha/api.js?render={{ config('services.recaptcha.site_key') }}"></script>
@endif
<script>
    function switchTab(tab) {
        const loginForm = document.getElementById('form-login');
        const registerForm = document.getElementById('form-register');
        const loginTab = document.getElementById('tab-login');
        const registerTab = document.getElementById('tab-register');

        if (tab === 'login') {
            loginForm.classList.remove('hidden');
            registerForm.classList.add('hidden');
            loginTab.classList.add('bg-white', 'text-slate-900', 'shadow-sm');
            loginTab.classList.remove('text-slate-500', 'hover:text-slate-700');
            registerTab.classList.remove('bg-white', 'text-slate-900', 'shadow-sm');
            registerTab.classList.add('text-slate-500', 'hover:text-slate-700');
        } else {
            loginForm.classList.add('hidden');
            registerForm.classList.remove('hidden');
            registerTab.classList.add('bg-white', 'text-slate-900', 'shadow-sm');
            registerTab.classList.remove('text-slate-500', 'hover:text-slate-700');
            loginTab.classList.remove('bg-white', 'text-slate-900', 'shadow-sm');
            loginTab.classList.add('text-slate-500', 'hover:text-slate-700');
        }
    }

    function fillLogin(email, password) {
        document.getElementById('login_email').value = email;
        document.getElementById('login_password').value = password;
    }

    @if(config('services.recaptcha.site_key'))
    document.getElementById('loginForm')?.addEventListener('submit', function(e) {
        var siteKey = @json(config('services.recaptcha.site_key'));
        if (siteKey && typeof grecaptcha !== 'undefined') {
            e.preventDefault();
            var form = this;
            grecaptcha.ready(function() {
                grecaptcha.execute(siteKey, {action: 'login'}).then(function(token) {
                    document.getElementById('login-recaptcha-response').value = token;
                    form.submit();
                }).catch(function(err) {
                    console.error('reCAPTCHA error:', err);
                    form.submit();
                });
            });
        }
    });

    document.getElementById('registerForm')?.addEventListener('submit', function(e) {
        var siteKey = @json(config('services.recaptcha.site_key'));
        if (siteKey && typeof grecaptcha !== 'undefined') {
            e.preventDefault();
            var form = this;
            grecaptcha.ready(function() {
                grecaptcha.execute(siteKey, {action: 'register'}).then(function(token) {
                    document.getElementById('register-recaptcha-response').value = token;
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