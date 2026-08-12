@extends('layouts.app')

@section('title', 'Lengkapi Profil Pemohon - Sistem Informasi HKI UM BIMA')

@section('content')
<div class="max-w-xl mx-auto my-12 p-6 bg-white rounded-xl border border-slate-200 shadow-md">
    <div class="border-b border-slate-200 pb-4 mb-6">
        <span class="bg-amber-500 text-slate-950 font-extrabold text-[10px] px-2.5 py-1 rounded uppercase tracking-wider">
            LANGKAH 1: KELENGKAPAN PROFIL
        </span>
        <h2 class="text-xl font-extrabold text-slate-900 uppercase tracking-tight mt-2">Form Kelengkapan Identitas Pemohon</h2>
        <p class="text-xs text-slate-500 mt-1">Lengkapi data NIK, Upload KTP, dan Nomor WhatsApp agar Admin HKI UM BIMA dapat memverifikasi akun Anda.</p>
    </div>

    <form action="{{ route('profile.save') }}" method="POST" enctype="multipart/form-data" class="space-y-5 text-xs">
        @csrf

        <div>
            <label class="block font-bold text-slate-700 uppercase tracking-wide mb-1">Nama Lengkap (Dari Google/SSO)</label>
            <input type="text" value="{{ $user->name }}" readonly class="w-full bg-slate-100 border border-slate-300 rounded-md py-2 px-3 text-slate-600 font-semibold cursor-not-allowed">
        </div>

        <div>
            <label class="block font-bold text-slate-700 uppercase tracking-wide mb-1">Email UM BIMA / Google</label>
            <input type="email" value="{{ $user->email }}" readonly class="w-full bg-slate-100 border border-slate-300 rounded-md py-2 px-3 text-slate-600 font-semibold cursor-not-allowed">
        </div>

        <!-- NIK (WAJIB) -->
        <div>
            <label for="nik" class="block font-bold text-slate-700 uppercase tracking-wide mb-1">
                NIK (Nomor Induk Kependudukan) <span class="text-red-600 font-extrabold">* (WAJIB)</span>
            </label>
            <input type="text" id="nik" name="nik" value="{{ old('nik', $user->nik) }}" required placeholder="Contoh: 5206012304950001" class="w-full border border-slate-300 rounded-md py-2 px-3 text-slate-900 focus:outline-none focus:border-emerald-600 font-medium">
            @error('nik') <span class="text-red-600 font-semibold mt-1 block">{{ $message }}</span> @enderror
        </div>

        <!-- NIP (TIDAK WAJIB) -->
        <div>
            <label for="nip" class="block font-bold text-slate-700 uppercase tracking-wide mb-1">
                NIP (Nomor Induk Pegawai / Dosen) <span class="text-slate-400 font-normal">(Opsional / Tidak Wajib)</span>
            </label>
            <input type="text" id="nip" name="nip" value="{{ old('nip', $user->nip) }}" placeholder="Contoh: 198501012015041001" class="w-full border border-slate-300 rounded-md py-2 px-3 text-slate-900 focus:outline-none focus:border-emerald-600 font-medium">
            @error('nip') <span class="text-red-600 font-semibold mt-1 block">{{ $message }}</span> @enderror
        </div>

        <!-- NIM (TIDAK WAJIB) -->
        <div>
            <label for="nim" class="block font-bold text-slate-700 uppercase tracking-wide mb-1">
                NIM (Nomor Induk Mahasiswa) <span class="text-slate-400 font-normal">(Opsional / Tidak Wajib)</span>
            </label>
            <input type="text" id="nim" name="nim" value="{{ old('nim', $user->nim) }}" placeholder="Contoh: 41520010023" class="w-full border border-slate-300 rounded-md py-2 px-3 text-slate-900 focus:outline-none focus:border-emerald-600 font-medium">
            @error('nim') <span class="text-red-600 font-semibold mt-1 block">{{ $message }}</span> @enderror
        </div>

        <!-- UPLOAD KTP (WAJIB) -->
        <div>
            <label for="ktp" class="block font-bold text-slate-700 uppercase tracking-wide mb-1">
                Upload File KTP (Foto / Scan KTP) <span class="text-red-600 font-extrabold">* (WAJIB)</span>
            </label>
            <input type="file" id="ktp" name="ktp" required accept=".jpg,.jpeg,.png,.pdf" class="w-full text-xs text-slate-600 border border-slate-300 rounded-md p-2 bg-white file:mr-3 file:py-1 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-bold file:bg-[#064E3B] file:text-white hover:file:bg-[#047857]">
            <p class="text-[10px] text-slate-500 mt-1">Format yang didukung: JPG, PNG, atau PDF (Maks. 5MB)</p>
            @error('ktp') <span class="text-red-600 font-semibold mt-1 block">{{ $message }}</span> @enderror
        </div>

        <!-- FAKULTAS / UNIT KERJA (TIDAK WAJIB) -->
        <div>
            <label for="faculty" class="block font-bold text-slate-700 uppercase tracking-wide mb-1">
                Fakultas / Unit Kerja UM BIMA <span class="text-slate-400 font-normal">(Opsional / Tidak Wajib)</span>
            </label>
            @php
                $facultiesList = \App\Models\Faculty::orderBy('name')->get();
            @endphp
            <select id="faculty" name="faculty" class="w-full border border-slate-300 rounded-md py-2 px-3 text-slate-900 focus:outline-none focus:border-emerald-600 font-medium">
                <option value="">-- Pilih Fakultas / Unit (Jika ada) --</option>
                @foreach($facultiesList as $fac)
                    <option value="{{ $fac->name }}" {{ old('faculty', $user->faculty) == $fac->name ? 'selected' : '' }}>
                        {{ $fac->name }} ({{ $fac->code }})
                    </option>
                @endforeach
            </select>
            @error('faculty') <span class="text-red-600 font-semibold mt-1 block">{{ $message }}</span> @enderror
        </div>

        <!-- NO WA (WAJIB) -->
        <div>
            <label for="phone_number" class="block font-bold text-slate-700 uppercase tracking-wide mb-1">
                Nomor WhatsApp Aktif <span class="text-red-600 font-extrabold">* (WAJIB)</span>
            </label>
            <input type="text" id="phone_number" name="phone_number" value="{{ old('phone_number', $user->phone_number) }}" required placeholder="Contoh: 081234567890" class="w-full border border-slate-300 rounded-md py-2 px-3 text-slate-900 focus:outline-none focus:border-emerald-600 font-medium">
            @error('phone_number') <span class="text-red-600 font-semibold mt-1 block">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="w-full bg-[#064E3B] hover:bg-[#047857] text-white font-extrabold py-3 px-4 rounded-md text-xs uppercase tracking-wider transition shadow-md">
            SIMPAN & VERIFIKASI PROFIL
        </button>
    </form>
</div>
@endsection
