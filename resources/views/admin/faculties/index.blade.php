@extends('layouts.dashboard')

@section('title', 'Kelola Fakultas & Unit Kerja - Admin HKI UM BIMA')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-6 space-y-8">
    <!-- Header Page -->
    <div class="border-b border-slate-200 pb-4 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <span class="bg-[#064E3B] text-white text-[10px] font-extrabold px-2.5 py-1 rounded uppercase tracking-wider">
                MASTER DATA INSTITUSI
            </span>
            <h2 class="text-2xl font-extrabold text-slate-900 uppercase tracking-tight mt-1">Kelola Fakultas & Unit Kerja</h2>
            <p class="text-xs text-slate-500">Manajemen daftar fakultas dan unit kerja di Universitas Muhammadiyah Bima yang terhubung dengan akun pemohon HKI.</p>
        </div>
    </div>

    <!-- Grid Form & List Table -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left: Form Tambah Fakultas -->
        <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-xs space-y-4">
            <h3 class="font-extrabold text-xs uppercase tracking-wider text-slate-900 border-b border-slate-200 pb-3 flex items-center gap-2">
                <span>➕</span> Tambah Fakultas / Unit Kerja Baru
            </h3>

            <form action="{{ route('admin.faculties.store') }}" method="POST" class="space-y-4 text-xs">
                @csrf
                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wide mb-1">
                        Nama Fakultas / Unit <span class="text-red-600">*</span>
                    </label>
                    <input type="text" name="name" required placeholder="Contoh: Fakultas Kesehatan Masyarakat" class="w-full border border-slate-300 rounded-lg p-2.5 text-slate-900 focus:outline-none focus:border-emerald-600 font-medium">
                    @error('name')
                        <p class="text-red-600 text-[11px] mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wide mb-1">
                        Kode Singkatan <span class="text-slate-400 font-normal">(Opsional)</span>
                    </label>
                    <input type="text" name="code" placeholder="Contoh: FKM" class="w-full border border-slate-300 rounded-lg p-2.5 text-slate-900 focus:outline-none focus:border-emerald-600 font-medium uppercase">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wide mb-1">
                        Deskripsi / Keterangan
                    </label>
                    <textarea name="description" rows="3" placeholder="Deskripsi singkat unit kerja..." class="w-full border border-slate-300 rounded-lg p-2.5 text-slate-900 focus:outline-none focus:border-emerald-600 font-medium"></textarea>
                </div>

                <button type="submit" class="w-full bg-[#064E3B] hover:bg-[#047857] text-white font-extrabold py-2.5 rounded-lg text-xs uppercase tracking-wider transition shadow-sm flex items-center justify-center space-x-2">
                    <span>SIMPAN FAKULTAS</span>
                    <span>💾</span>
                </button>
            </form>
        </div>

        <!-- Right: Table List Fakultas & User Stats -->
        <div class="lg:col-span-2 bg-white rounded-xl border border-slate-200 shadow-xs overflow-hidden">
            <div class="bg-[#064E3B] text-white px-6 py-4 flex items-center justify-between">
                <h3 class="font-extrabold uppercase text-xs tracking-wider flex items-center gap-2">
                    <span>🏛️</span> DAFTAR FAKULTAS TERDAFTAR & AKUN USER
                </h3>
                <span class="text-[10px] bg-emerald-900 text-emerald-200 px-2.5 py-0.5 rounded font-bold border border-emerald-700">
                    TOTAL: {{ $faculties->count() }} UNIT
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-xs text-left text-slate-700">
                    <thead class="bg-slate-100 uppercase text-[10px] text-slate-500 font-extrabold border-b border-slate-200">
                        <tr>
                            <th class="py-3.5 px-4 w-12 text-center">NO.</th>
                            <th class="py-3.5 px-4">FAKULTAS / UNIT KERJA</th>
                            <th class="py-3.5 px-4 w-24 text-center">KODE</th>
                            <th class="py-3.5 px-4 w-32 text-center">TOTAL USER</th>
                            <th class="py-3.5 px-4 w-28 text-center">AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @forelse($faculties as $index => $fac)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="py-3.5 px-4 text-center font-bold text-slate-800">{{ $index + 1 }}</td>
                                <td class="py-3.5 px-4">
                                    <div class="font-bold text-slate-900">{{ $fac->name }}</div>
                                    @if($fac->description)
                                        <div class="text-[11px] text-slate-500 mt-0.5">{{ $fac->description }}</div>
                                    @endif
                                </td>
                                <td class="py-3.5 px-4 text-center">
                                    <span class="bg-slate-100 text-slate-700 font-mono font-bold px-2 py-0.5 rounded border border-slate-300 text-[10px]">
                                        {{ $fac->code ?? '-' }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-4 text-center">
                                    <span class="bg-emerald-100 text-emerald-800 font-extrabold px-2.5 py-1 rounded-full text-[11px] border border-emerald-300">
                                        👤 {{ $fac->users_count }} Pemohon
                                    </span>
                                </td>
                                <td class="py-3.5 px-4 text-center">
                                    <div class="flex justify-center items-center gap-2">
                                        <button onclick="openEditModal({{ $fac->id }}, '{{ addslashes($fac->name) }}', '{{ addslashes($fac->code ?? '') }}', '{{ addslashes($fac->description ?? '') }}')" class="bg-amber-500 hover:bg-amber-600 text-slate-950 px-2.5 py-1 rounded text-[10px] font-extrabold uppercase transition">
                                            Edit
                                        </button>
                                        <form action="{{ route('admin.faculties.delete', $fac->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('Hapus fakultas ini? User dengan fakultas ini tidak akan terhapus.')" class="bg-red-600 hover:bg-red-700 text-white px-2.5 py-1 rounded text-[10px] font-bold uppercase transition">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-6 text-center text-slate-500 font-medium">Belum ada data fakultas tersimpan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<!-- Modal Edit Fakultas -->
<div id="editFacultyModal" class="fixed inset-0 z-50 bg-slate-950/70 backdrop-blur-xs hidden items-center justify-center p-4">
    <div class="bg-white rounded-xl border border-slate-200 max-w-md w-full p-6 space-y-4 shadow-2xl">
        <div class="flex justify-between items-center border-b border-slate-200 pb-3">
            <h3 class="font-extrabold text-slate-900 text-sm uppercase">Edit Fakultas / Unit Kerja</h3>
            <button onclick="closeEditModal()" class="text-slate-400 hover:text-slate-600 font-bold text-lg">&times;</button>
        </div>

        <form id="editFacultyForm" method="POST" class="space-y-4 text-xs">
            @csrf
            <div>
                <label class="block font-bold text-slate-700 uppercase tracking-wide mb-1">Nama Fakultas / Unit</label>
                <input type="text" id="edit_name" name="name" required class="w-full border border-slate-300 rounded-lg p-2.5 text-slate-900 font-medium">
            </div>

            <div>
                <label class="block font-bold text-slate-700 uppercase tracking-wide mb-1">Kode Singkatan</label>
                <input type="text" id="edit_code" name="code" class="w-full border border-slate-300 rounded-lg p-2.5 text-slate-900 font-medium uppercase">
            </div>

            <div>
                <label class="block font-bold text-slate-700 uppercase tracking-wide mb-1">Deskripsi</label>
                <textarea id="edit_description" name="description" rows="3" class="w-full border border-slate-300 rounded-lg p-2.5 text-slate-900 font-medium"></textarea>
            </div>

            <div class="pt-3 border-t border-slate-200 flex justify-end space-x-2">
                <button type="button" onclick="closeEditModal()" class="bg-slate-100 text-slate-700 px-4 py-2 rounded text-xs font-bold uppercase">Batal</button>
                <button type="submit" class="bg-[#064E3B] text-white px-5 py-2 rounded text-xs font-extrabold uppercase">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function openEditModal(id, name, code, description) {
        document.getElementById('edit_name').value = name;
        document.getElementById('edit_code').value = code;
        document.getElementById('edit_description').value = description;
        document.getElementById('editFacultyForm').action = '/admin/faculties/' + id + '/update';
        
        const modal = document.getElementById('editFacultyModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeEditModal() {
        const modal = document.getElementById('editFacultyModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
</script>
@endpush
@endsection
