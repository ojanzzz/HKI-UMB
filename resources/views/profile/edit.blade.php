@extends('layouts.dashboard')

@section('title', 'Edit Profil Saya - Direktorat Inovasi & KI UM BIMA')

@section('content')
<div class="max-w-4xl mx-auto space-y-8 py-4">
    <!-- Header Section -->
    <div class="border-b border-slate-200 pb-4 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <span class="bg-[#064E3B] text-white text-[10px] font-extrabold px-2.5 py-1 rounded uppercase tracking-wider">
                AKUN PEMOHON KI
            </span>
            <h2 class="text-2xl font-extrabold text-slate-900 uppercase tracking-tight mt-1">Edit Profil Saya</h2>
            <p class="text-xs text-slate-500">Perbarui identitas NIK, NIP, NIM, dokumen KTP, nomor WhatsApp, fakultas, atau password akun Anda.</p>
        </div>
        <a href="{{ route('user.dashboard') }}" class="bg-slate-200 hover:bg-slate-300 text-slate-800 text-xs font-bold px-4 py-2 rounded-lg transition uppercase tracking-wider">
            &larr; Kembali ke Dashboard
        </a>
    </div>

    <!-- Edit Profile Card Form -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="bg-[#064E3B] text-white px-6 py-4 flex items-center justify-between">
            <h3 class="text-xs font-extrabold uppercase tracking-wider flex items-center gap-2">
                <span>👤</span> FORMULIR IDENTITAS SIVITAS UM BIMA
            </h3>
            <span class="text-[10px] bg-emerald-900 text-emerald-200 px-2.5 py-0.5 rounded font-bold border border-emerald-700 uppercase">
                STATUS AKUN: {{ strtoupper($user->status) }}
            </span>
        </div>

        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="p-6 md:p-8 space-y-6 text-xs">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nama Lengkap -->
                <div>
                    <label class="block font-bold text-slate-800 uppercase tracking-wide mb-1">
                        Nama Lengkap (Gelar) <span class="text-red-600">*</span>
                    </label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full border border-slate-300 rounded-lg p-3 text-slate-900 focus:outline-none focus:border-emerald-600 font-medium">
                    @error('name')
                        <p class="text-red-600 text-[11px] mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email (Readonly) -->
                <div>
                    <label class="block font-bold text-slate-800 uppercase tracking-wide mb-1">
                        Alamat Email Resmi <span class="text-slate-400 font-normal">(Terhubung SSO)</span>
                    </label>
                    <input type="email" value="{{ $user->email }}" readonly class="w-full border border-slate-200 bg-slate-100 rounded-lg p-3 text-slate-500 font-medium cursor-not-allowed">
                </div>

                <!-- NIK (WAJIB) -->
                <div>
                    <label class="block font-bold text-slate-800 uppercase tracking-wide mb-1">
                        NIK (Nomor Induk Kependudukan) <span class="text-red-600 font-extrabold">* (WAJIB)</span>
                    </label>
                    <input type="text" name="nik" value="{{ old('nik', $user->nik) }}" required placeholder="Contoh: 5206012304950001" class="w-full border border-slate-300 rounded-lg p-3 text-slate-900 focus:outline-none focus:border-emerald-600 font-medium">
                    @error('nik')
                        <p class="text-red-600 text-[11px] mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- NIP (OPSIONAL) -->
                <div>
                    <label class="block font-bold text-slate-800 uppercase tracking-wide mb-1">
                        NIP (Nomor Induk Pegawai / Dosen) <span class="text-slate-400 font-normal">(Opsional / Tidak Wajib)</span>
                    </label>
                    <input type="text" name="nip" value="{{ old('nip', $user->nip) }}" placeholder="Contoh: 198501012015041001" class="w-full border border-slate-300 rounded-lg p-3 text-slate-900 focus:outline-none focus:border-emerald-600 font-medium">
                    @error('nip')
                        <p class="text-red-600 text-[11px] mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- NIM (OPSIONAL) -->
                <div>
                    <label class="block font-bold text-slate-800 uppercase tracking-wide mb-1">
                        NIM (Nomor Induk Mahasiswa) <span class="text-slate-400 font-normal">(Opsional / Tidak Wajib)</span>
                    </label>
                    <input type="text" name="nim" value="{{ old('nim', $user->nim) }}" placeholder="Contoh: 41520010023" class="w-full border border-slate-300 rounded-lg p-3 text-slate-900 focus:outline-none focus:border-emerald-600 font-medium">
                    @error('nim')
                        <p class="text-red-600 text-[11px] mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- FAKULTAS / UNIT KERJA (OPSIONAL) -->
                <div>
                    <label class="block font-bold text-slate-800 uppercase tracking-wide mb-1">
                        Fakultas / Unit Kerja <span class="text-slate-400 font-normal">(Opsional / Tidak Wajib)</span>
                    </label>
                    <select name="faculty" class="w-full border border-slate-300 rounded-lg p-3 text-slate-900 focus:outline-none focus:border-emerald-600 font-medium bg-white">
                        <option value="">-- Pilih Fakultas / Unit (Jika Ada) --</option>
                        @php
                            $allFaculties = \App\Models\Faculty::orderBy('name')->get();
                        @endphp
                        @foreach($allFaculties as $fac)
                            <option value="{{ $fac->name }}" {{ old('faculty', $user->faculty) == $fac->name ? 'selected' : '' }}>{{ $fac->name }}</option>
                        @endforeach
                    </select>
                    @error('faculty')
                        <p class="text-red-600 text-[11px] mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- UPLOAD KTP (WAJIB / UPDATE) -->
                <div class="md:col-span-2 bg-slate-50 border border-slate-200 rounded-xl p-4 space-y-2">
                    <label class="block font-bold text-slate-800 uppercase tracking-wide">
                        Dokumen KTP (Foto / Scan KTP) <span class="text-red-600 font-extrabold">* (WAJIB)</span>
                    </label>
                    @if($user->ktp_path)
                        <div class="flex items-center justify-between bg-emerald-50 border border-emerald-300 p-2.5 rounded-lg">
                            <span class="text-emerald-800 font-bold">✓ KTP Terunggah di Sistem</span>
                            <a href="{{ asset('storage/' . $user->ktp_path) }}" target="_blank" class="bg-emerald-700 hover:bg-emerald-800 text-white font-extrabold px-3 py-1 rounded text-[11px]">
                                Lihat File KTP &rarr;
                            </a>
                        </div>
                    @endif
                    <input type="file" name="ktp" accept=".jpg,.jpeg,.png,.pdf" class="w-full text-xs text-slate-600 border border-slate-300 rounded-lg p-2 bg-white">
                    <p class="text-[10px] text-slate-500">Pilih file baru jika ingin mengganti KTP yang diunggah (.jpg, .png, .pdf maks 5MB)</p>
                    @error('ktp')
                        <p class="text-red-600 text-[11px] mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nomor WhatsApp / HP -->
                <div>
                    <label class="block font-bold text-slate-800 uppercase tracking-wide mb-1">
                        Nomor WhatsApp Aktif <span class="text-red-600">* (WAJIB)</span>
                    </label>
                    <input type="text" name="phone_number" value="{{ old('phone_number', $user->phone_number) }}" required placeholder="Contoh: 081234567890" class="w-full border border-slate-300 rounded-lg p-3 text-slate-900 focus:outline-none focus:border-emerald-600 font-medium">
                    @error('phone_number')
                        <p class="text-red-600 text-[11px] mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Role Status -->
                <div>
                    <label class="block font-bold text-slate-800 uppercase tracking-wide mb-1">
                        Peran Akun
                    </label>
                    <input type="text" value="{{ strtoupper($user->role) }}" readonly class="w-full border border-slate-200 bg-slate-100 rounded-lg p-3 text-slate-600 font-bold uppercase cursor-not-allowed">
                </div>
            </div>

            <div class="border-t border-slate-200 pt-6 mt-6 space-y-4">
                <h4 class="font-extrabold text-slate-900 text-xs uppercase tracking-wide">Ubah Password Akun (Opsional)</h4>
                <p class="text-[11px] text-slate-500">Kosongkan kolom password di bawah ini jika Anda tidak ingin mengubah kata sandi.</p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block font-bold text-slate-800 uppercase tracking-wide mb-1">Password Baru</label>
                        <input type="password" name="password" placeholder="Minimal 6 karakter..." class="w-full border border-slate-300 rounded-lg p-3 text-slate-900 focus:outline-none focus:border-emerald-600 font-medium">
                        @error('password')
                            <p class="text-red-600 text-[11px] mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block font-bold text-slate-800 uppercase tracking-wide mb-1">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" placeholder="Ulangi password baru..." class="w-full border border-slate-300 rounded-lg p-3 text-slate-900 focus:outline-none focus:border-emerald-600 font-medium">
                    </div>
                </div>
            </div>

            <div class="border-t border-slate-200 pt-6 flex justify-end space-x-3">
                <a href="{{ route('user.dashboard') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-5 py-2.5 rounded-lg font-bold uppercase tracking-wider transition">
                    BATAL
                </a>
                <button type="submit" class="bg-[#064E3B] hover:bg-[#047857] text-white px-6 py-2.5 rounded-lg font-extrabold uppercase tracking-wider transition shadow-sm flex items-center space-x-2">
                    <span>SIMPAN PERUBAHAN PROFIL</span>
                    <span>💾</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
