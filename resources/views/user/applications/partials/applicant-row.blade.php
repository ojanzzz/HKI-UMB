@php
    $name = old("applicants.{$index}.applicant_name", $applicant['applicant_name'] ?? '');
    $address = old("applicants.{$index}.applicant_address", $applicant['applicant_address'] ?? '');
    $nik = old("applicants.{$index}.applicant_nik", $applicant['applicant_nik'] ?? '');
    $nip = old("applicants.{$index}.applicant_nip", $applicant['applicant_nip'] ?? '');
    $nim = old("applicants.{$index}.applicant_nim", $applicant['applicant_nim'] ?? '');
    $faculty = old("applicants.{$index}.applicant_faculty", $applicant['applicant_faculty'] ?? '');
@endphp

<div id="applicantRow{{ $index }}" class="bg-white rounded-2xl border border-slate-200 p-5 space-y-4 shadow-xs applicant-row">
    <div class="flex items-center justify-between border-b border-slate-200 pb-3">
        <h4 class="font-extrabold text-slate-900 text-xs uppercase tracking-wider">
            Anggota #{{ $index + 1 }}
        </h4>
        @if($showRemove ?? false)
            <button type="button" onclick="removeApplicant({{ $index }})" class="bg-red-100 hover:bg-red-200 text-red-700 font-extrabold px-3 py-1 rounded-lg text-[10px] uppercase tracking-wider transition flex items-center gap-1">
                <span>&times;</span>
                <span>Hapus</span>
            </button>
        @endif
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <!-- Nama Lengkap (Required) -->
        <div>
            <label for="applicants_{{ $index }}_applicant_name" class="block font-bold text-slate-800 uppercase text-xs mb-1">
                Nama Lengkap <span class="text-red-600">*</span>
            </label>
            <input type="text" id="applicants_{{ $index }}_applicant_name" name="applicants[{{ $index }}][applicant_name]" value="{{ $name }}" required placeholder="Masukkan nama lengkap sesuai KTP" class="w-full border border-slate-300 rounded-xl p-3.5 text-slate-900 focus:outline-none focus:border-blue-600 font-medium text-xs">
            @error("applicants.{$index}.applicant_name")
                <p class="text-red-600 text-[11px] mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Alamat (Required) -->
        <div class="md:col-span-2">
            <label for="applicants_{{ $index }}_applicant_address" class="block font-bold text-slate-800 uppercase text-xs mb-1">
                Alamat <span class="text-red-600">*</span>
            </label>
            <textarea id="applicants_{{ $index }}_applicant_address" name="applicants[{{ $index }}][applicant_address]" required rows="2" placeholder="Masukkan alamat lengkap sesuai KTP" class="w-full border border-slate-300 rounded-xl p-3.5 text-slate-900 focus:outline-none focus:border-blue-600 font-medium text-xs resize-y">{{ $address }}</textarea>
            @error("applicants.{$index}.applicant_address")
                <p class="text-red-600 text-[11px] mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- NIK (Required) -->
        <div>
            <label for="applicants_{{ $index }}_applicant_nik" class="block font-bold text-slate-800 uppercase text-xs mb-1">
                NIK <span class="text-red-600">*</span>
            </label>
            <input type="text" id="applicants_{{ $index }}_applicant_nik" name="applicants[{{ $index }}][applicant_nik]" value="{{ $nik }}" required placeholder="Nomor Induk Kependudukan" class="w-full border border-slate-300 rounded-xl p-3.5 text-slate-900 focus:outline-none focus:border-blue-600 font-medium text-xs">
            @error("applicants.{$index}.applicant_nik")
                <p class="text-red-600 text-[11px] mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- NIP (Optional) -->
        <div>
            <label for="applicants_{{ $index }}_applicant_nip" class="block font-bold text-slate-800 uppercase text-xs mb-1">
                NIP <span class="text-slate-400 font-normal">(Opsional)</span>
            </label>
            <input type="text" id="applicants_{{ $index }}_applicant_nip" name="applicants[{{ $index }}][applicant_nip]" value="{{ $nip }}" placeholder="Nomor Induk Pegawai / Dosen" class="w-full border border-slate-300 rounded-xl p-3.5 text-slate-900 focus:outline-none focus:border-blue-600 font-medium text-xs">
            @error("applicants.{$index}.applicant_nip")
                <p class="text-red-600 text-[11px] mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- NIM (Optional) -->
        <div>
            <label for="applicants_{{ $index }}_applicant_nim" class="block font-bold text-slate-800 uppercase text-xs mb-1">
                NIM <span class="text-slate-400 font-normal">(Opsional)</span>
            </label>
            <input type="text" id="applicants_{{ $index }}_applicant_nim" name="applicants[{{ $index }}][applicant_nim]" value="{{ $nim }}" placeholder="Nomor Induk Mahasiswa" class="w-full border border-slate-300 rounded-xl p-3.5 text-slate-900 focus:outline-none focus:border-blue-600 font-medium text-xs">
            @error("applicants.{$index}.applicant_nim")
                <p class="text-red-600 text-[11px] mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Fakultas / Unit Kerja (Optional) -->
        <div>
            <label for="applicants_{{ $index }}_applicant_faculty" class="block font-bold text-slate-800 uppercase text-xs mb-1">
                Fakultas / Unit Kerja <span class="text-slate-400 font-normal">(Opsional)</span>
            </label>
            <select id="applicants_{{ $index }}_applicant_faculty" name="applicants[{{ $index }}][applicant_faculty]" class="w-full border border-slate-300 rounded-xl p-3.5 text-slate-900 focus:outline-none focus:border-blue-600 font-medium text-xs bg-white">
                <option value="">-- Pilih Fakultas / Unit --</option>
                @foreach($faculties as $fac)
                    <option value="{{ $fac->name }}" {{ old("applicants.{$index}.applicant_faculty", $faculty) == $fac->name ? 'selected' : '' }}>{{ $fac->name }}</option>
                @endforeach
            </select>
            @error("applicants.{$index}.applicant_faculty")
                <p class="text-red-600 text-[11px] mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>
</div>
