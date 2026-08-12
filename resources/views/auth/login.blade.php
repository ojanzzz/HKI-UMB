@extends('layouts.app')

@section('title', 'Login Sistem Informasi HKI UMB')

@section('content')
<div class="max-w-md mx-auto my-10 p-6 bg-white rounded-xl border border-slate-200 shadow-md">
    <div class="text-center mb-6">
        <div class="w-14 h-14 bg-[#002855] text-white rounded-lg mx-auto flex items-center justify-center font-extrabold text-xs mb-3 shadow-sm">
            DJKI<br>UMB
        </div>
        <h2 class="text-xl font-extrabold text-slate-900 uppercase tracking-tight">Login Portal HKI UMB</h2>
        <p class="text-xs text-slate-500 mt-1">Masuk dengan Email & Password atau Akun Google SSO</p>
    </div>

    <!-- Form Login Biasa (Email & Password) -->
    <form action="{{ route('login.post') }}" method="POST" class="space-y-4 text-xs mb-6">
        @csrf
        <div>
            <label for="email" class="block font-bold text-slate-700 uppercase tracking-wide mb-1">Email <span class="text-red-600">*</span></label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required placeholder="email@umb.ac.id" class="w-full border border-slate-300 rounded-md py-2.5 px-3 text-slate-900 focus:outline-none focus:border-red-600 font-medium">
            @error('email') <span class="text-red-600 font-semibold mt-1 block">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="password" class="block font-bold text-slate-700 uppercase tracking-wide mb-1">Password <span class="text-red-600">*</span></label>
            <input type="password" id="password" name="password" required placeholder="••••••••" class="w-full border border-slate-300 rounded-md py-2.5 px-3 text-slate-900 focus:outline-none focus:border-red-600 font-medium">
            @error('password') <span class="text-red-600 font-semibold mt-1 block">{{ $message }}</span> @enderror
        </div>

        <div class="flex items-center justify-between">
            <label class="flex items-center space-x-2 cursor-pointer">
                <input type="checkbox" name="remember" class="rounded text-red-600 focus:ring-red-500">
                <span class="text-slate-600 font-semibold">Ingat Saya</span>
            </label>
        </div>

        <button type="submit" class="w-full bg-[#002855] hover:bg-[#003366] text-white py-3 px-4 rounded-md font-bold text-xs uppercase tracking-wider transition shadow-sm">
            MASUK APLIKASI
        </button>
    </form>

    <div class="relative flex py-2 items-center mb-4">
        <div class="flex-grow border-t border-slate-200"></div>
        <span class="flex-shrink mx-4 text-[10px] text-slate-400 font-bold uppercase tracking-wider">ATAU AKSES GOOGLE SSO</span>
        <div class="flex-grow border-t border-slate-200"></div>
    </div>

    <!-- Tombol Google SSO -->
    <a href="{{ route('auth.google') }}" class="w-full bg-red-600 hover:bg-red-700 text-white py-2.5 px-4 rounded-md font-bold text-xs uppercase tracking-wider transition flex items-center justify-center space-x-3 shadow-xs mb-6">
        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
            <path d="M12.24 10.285V13.4h6.887c-.58 3.033-3.033 5.257-6.887 5.257-4.144 0-7.5-3.356-7.5-7.5s3.356-7.5 7.5-7.5c1.884 0 3.6.696 4.93 1.841l2.457-2.457C17.587 1.48 15.08 0 12.24 0 5.48 0 0 5.48 0 12.24s5.48 12.24 12.24 12.24c7.054 0 11.727-4.957 11.727-11.94 0-.796-.075-1.57-.215-2.315H12.24z"/>
        </svg>
        <span>LOGIN VIA GOOGLE SSO</span>
    </a>

    <!-- Quick Auto-Fill Demo Akun untuk Testing -->
    <div class="bg-slate-50 border border-slate-200 p-4 rounded-lg space-y-2 text-xs">
        <div class="font-extrabold text-slate-900 uppercase tracking-wide text-[11px] mb-1">⚡ Quick Login Testing (1-Click Fill):</div>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
            <button onclick="fillLogin('admin@umb.ac.id', 'password123')" class="bg-slate-200 hover:bg-slate-300 text-slate-800 p-2 rounded text-[10px] font-bold uppercase text-center transition">
                ADMIN
            </button>
            <button onclick="fillLogin('budi.santoso@umb.ac.id', 'password123')" class="bg-slate-200 hover:bg-slate-300 text-slate-800 p-2 rounded text-[10px] font-bold uppercase text-center transition">
                USER APPROVED
            </button>
            <button onclick="fillLogin('ahmad.rizal@umb.ac.id', 'password123')" class="bg-slate-200 hover:bg-slate-300 text-slate-800 p-2 rounded text-[10px] font-bold uppercase text-center transition">
                USER PENDING
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function fillLogin(email, password) {
        document.getElementById('email').value = email;
        document.getElementById('password').value = password;
    }
</script>
@endpush
@endsection
