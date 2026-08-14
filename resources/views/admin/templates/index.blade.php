@extends('layouts.dashboard')

@section('title', 'Manajemen Template Dokumen Pengajuan - Admin KI UM BIMA')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-8 space-y-8">
    <!-- Header Section -->
    <div class="border-b border-slate-200 pb-4 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <span class="bg-[#064E3B] text-white text-[10px] font-extrabold px-2.5 py-1 rounded uppercase tracking-wider">
                MANAJEMEN TEMPLATE PEMBERKASAN
            </span>
            <h2 class="text-2xl font-extrabold text-slate-900 uppercase tracking-tight mt-1">Kelola Template Dokumen Pengajuan KI</h2>
            <p class="text-xs text-slate-500">Unggah file fisik Word (.docx) atau PDF (.pdf) resmi yang akan diunduh dan diisi oleh pemohon pada saat pengajuan baru.</p>
        </div>
    </div>

    <!-- Table of 8 Document Templates -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="bg-[#064E3B] text-white px-6 py-4 flex items-center justify-between">
            <h3 class="text-xs font-extrabold uppercase tracking-wider flex items-center gap-2">
                <span>📁</span> DAFTAR 8 TEMPLATE DOKUMEN DITAMPILKAN KE PEMOHON
            </h3>
            <span class="text-[10px] bg-amber-500 text-slate-950 px-2.5 py-0.5 rounded font-extrabold uppercase">
                TOTAL: {{ $templates->count() }} TEMPLATE
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-xs text-left text-slate-700">
                <thead class="bg-slate-100 uppercase text-[10px] text-slate-500 font-extrabold border-b border-slate-200">
                    <tr>
                        <th class="py-4 px-5 w-12 text-center">NO</th>
                        <th class="py-4 px-5 w-48">KODE & FORMAT</th>
                        <th class="py-4 px-5">JUDUL & DESKRIPSI TEMPLATE</th>
                        <th class="py-4 px-5">FILE FISIK TERSIMPAN</th>
                        <th class="py-4 px-5 w-24 text-center">STATUS</th>
                        <th class="py-4 px-5 w-32 text-center">AKSI ADMIN</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($templates as $idx => $t)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-4 px-5 text-center font-bold text-slate-800">{{ $idx + 1 }}</td>
                            <td class="py-4 px-5">
                                <span class="bg-slate-900 text-white text-[10px] font-mono font-bold px-2 py-0.5 rounded uppercase block w-fit mb-1">
                                    {{ $t->code }}
                                </span>
                                <span class="text-[10px] font-bold text-emerald-800 bg-emerald-100 px-2 py-0.5 rounded border border-emerald-200 uppercase">
                                    .{{ strtoupper($t->file_type ?: 'DOCX') }}
                                </span>
                            </td>
                            <td class="py-4 px-5">
                                <div class="font-extrabold text-slate-900 text-sm tracking-tight">{{ $t->title }}</div>
                                <div class="text-[11px] text-slate-500 leading-relaxed mt-0.5">{{ $t->description ?: 'Belum ada deskripsi tambahan.' }}</div>
                            </td>
                            <td class="py-4 px-5">
                                @if($t->file_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($t->file_path))
                                    <div class="flex items-center gap-2">
                                        <span class="text-base">📄</span>
                                        <div class="truncate max-w-xs">
                                            <span class="font-mono text-[11px] font-bold text-slate-800 block truncate">{{ $t->file_name ?: basename($t->file_path) }}</span>
                                            <span class="text-[10px] text-slate-400">Diunggah Admin & Dynamic Download Active</span>
                                        </div>
                                    </div>
                                @else
                                    <div class="text-amber-700 bg-amber-50 border border-amber-200 p-2 rounded-lg text-[10px] font-medium leading-tight">
                                        ⚠️ File fisik custom belum diunggah.<br>
                                        <span class="text-slate-500 font-bold">(Menggunakan template generator otomatis)</span>
                                    </div>
                                @endif
                            </td>
                            <td class="py-4 px-5 text-center">
                                @if($t->is_active)
                                    <span class="bg-emerald-100 text-emerald-800 text-[10px] font-extrabold px-2.5 py-1 rounded-full uppercase border border-emerald-300">
                                        ✓ AKTIF
                                    </span>
                                @else
                                    <span class="bg-red-100 text-red-800 text-[10px] font-extrabold px-2.5 py-1 rounded-full uppercase border border-red-300">
                                        NON-AKTIF
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-5 text-center space-y-1.5">
                                <button onclick="openEditTemplateModal('{{ $t->id }}', '{{ addslashes($t->title) }}', '{{ addslashes($t->description) }}', {{ $t->is_active ? 'true' : 'false' }})"
                                        class="bg-blue-600 hover:bg-blue-700 text-white font-extrabold px-3 py-1.5 rounded-lg text-[10px] uppercase tracking-wider transition shadow-xs w-full flex items-center justify-center gap-1">
                                    <span>✏️</span>
                                    <span>EDIT / UPLOAD</span>
                                </button>
                                
                                @if($t->file_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($t->file_path))
                                    <a href="{{ asset('storage/' . $t->file_path) }}" target="_blank"
                                       class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold px-3 py-1 rounded-lg text-[10px] uppercase tracking-wider transition border border-slate-300 block text-center">
                                        👁️ PRATINJAU
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-slate-500 font-medium">Belum ada template dokumen terdaftar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Edit & Upload Replacement Template -->
<div id="editTemplateModal" class="fixed inset-0 z-50 bg-slate-950/60 backdrop-blur-xs hidden items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-2xl space-y-5 border border-slate-200">
        <div class="flex justify-between items-center border-b border-slate-200 pb-3">
            <h3 class="font-extrabold text-slate-900 text-sm uppercase tracking-wide flex items-center gap-2">
                <span>📄</span> UPLOAD & EDIT TEMPLATE DOKUMEN
            </h3>
            <button onclick="closeEditTemplateModal()" class="text-slate-400 hover:text-red-600 font-bold text-xl">&times;</button>
        </div>

        <form id="editTemplateForm" action="" method="POST" enctype="multipart/form-data" class="space-y-4 text-xs">
            @csrf

            <div>
                <label for="modalTitle" class="block font-bold text-slate-800 uppercase tracking-wide mb-1">Judul Template <span class="text-red-600">*</span></label>
                <input type="text" id="modalTitle" name="title" required class="w-full border border-slate-300 rounded-xl p-3 text-slate-900 font-medium focus:outline-none focus:border-blue-600">
            </div>

            <div>
                <label for="modalDescription" class="block font-bold text-slate-800 uppercase tracking-wide mb-1">Deskripsi / Petunjuk Pengisian</label>
                <textarea id="modalDescription" name="description" rows="3" class="w-full border border-slate-300 rounded-xl p-3 text-slate-900 font-medium focus:outline-none focus:border-blue-600"></textarea>
            </div>

            <div class="bg-blue-50/70 border border-blue-200 rounded-xl p-4 space-y-2">
                <label for="modalTemplateFile" class="block font-extrabold text-slate-900 uppercase text-xs">
                    📥 Upload File Template Resmi (.DOCX / .PDF)
                </label>
                <input type="file" id="modalTemplateFile" name="template_file" accept=".docx,.doc,.pdf" class="w-full text-xs text-slate-600 border border-slate-300 rounded-lg bg-white p-2 file:mr-3 file:py-1 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-bold file:bg-blue-600 file:text-white hover:file:bg-blue-700">
                <p class="text-[10px] text-slate-500">Format diizinkan: Word (.docx, .doc) atau PDF (.pdf), Maksimal 10MB. File ini akan diunduh oleh pemohon saat menekan tombol Unduh Template.</p>
            </div>

            <div class="flex items-center space-x-2 pt-1">
                <input type="checkbox" id="modalIsActive" name="is_active" value="1" class="w-4 h-4 text-emerald-700 rounded border-slate-300">
                <label for="modalIsActive" class="font-bold text-slate-800 uppercase text-xs">Tampilkan dan Aktifkan untuk Pemohon</label>
            </div>

            <div class="pt-3 flex justify-end gap-2 border-t border-slate-100">
                <button type="button" onclick="closeEditTemplateModal()" class="bg-slate-200 hover:bg-slate-300 text-slate-800 font-bold px-5 py-2.5 rounded-xl text-xs uppercase">
                    Batal
                </button>
                <button type="submit" class="bg-[#064E3B] hover:bg-[#047857] text-white font-extrabold px-6 py-2.5 rounded-xl text-xs uppercase tracking-wider transition shadow-sm">
                    Simpan Perubahan & Upload
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function openEditTemplateModal(id, title, description, isActive) {
        var form = document.getElementById('editTemplateForm');
        form.action = '/admin/templates/' + id + '/update';
        document.getElementById('modalTitle').value = title;
        document.getElementById('modalDescription').value = description;
        document.getElementById('modalIsActive').checked = isActive;
        
        document.getElementById('editTemplateModal').classList.remove('hidden');
        document.getElementById('editTemplateModal').classList.add('flex');
    }

    function closeEditTemplateModal() {
        document.getElementById('editTemplateModal').classList.add('hidden');
        document.getElementById('editTemplateModal').classList.remove('flex');
    }
</script>
@endpush
@endsection
