@extends('layouts.dashboard')

@section('title', 'Master Tipe Permohonan KI - Admin KI UM BIMA')

@section('content')
<div class="max-w-7xl mx-auto space-y-8 py-4">
    <!-- Header Section -->
    <div class="border-b border-slate-200 pb-4 flex justify-between items-center">
        <div>
            <span class="bg-[#064E3B] text-white text-[10px] font-extrabold px-2.5 py-1 rounded uppercase tracking-wider">
                MASTER DATA ADMINISTRATOR
            </span>
            <h2 class="text-2xl font-extrabold text-slate-900 uppercase tracking-tight mt-1">Master Tipe Permohonan KI</h2>
            <p class="text-xs text-slate-500">Kelola opsi jenis permohonan KI (Paten, Hak Cipta, Merek, Desain Industri, dll) yang dapat dipilih pengguna saat mengajukan permohonan baru.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        
        <!-- LEFT: FORM TAMBAH TIPE PERMOHONAN KI BARU -->
        <div class="lg:col-span-5 bg-white rounded-2xl border border-slate-200 p-6 shadow-xs space-y-4">
            <h3 class="text-base font-extrabold text-slate-900 uppercase tracking-tight flex items-center gap-2 border-b border-slate-100 pb-3">
                <span>➕</span> TAMBAH TIPE PERMOHONAN KI
            </h3>

            <form action="{{ route('admin.application-types.store') }}" method="POST" class="space-y-4 text-xs">
                @csrf

                <div>
                    <label class="block font-bold text-slate-800 uppercase tracking-wide mb-1">
                        Nama Tipe Permohonan <span class="text-red-600">*</span>
                    </label>
                    <input type="text" name="name" required placeholder="Contoh: Paten Sederhana, Hak Cipta, Merek" class="w-full border border-slate-300 rounded-lg p-3 text-slate-900 font-medium focus:outline-none focus:border-emerald-600">
                </div>

                <div>
                    <label class="block font-bold text-slate-800 uppercase tracking-wide mb-1">
                        Kode Tipe <span class="text-red-600">*</span>
                    </label>
                    <input type="text" name="code" required placeholder="Contoh: PATEN, PATEN_SEDERHANA, HAK_CIPTA" class="w-full border border-slate-300 rounded-lg p-3 text-slate-900 font-mono font-medium focus:outline-none focus:border-emerald-600">
                </div>

                <div>
                    <label class="block font-bold text-slate-800 uppercase tracking-wide mb-1">Deskripsi / Keterangan</label>
                    <textarea name="description" rows="3" placeholder="Keterangan singkat permohonan KI..." class="w-full border border-slate-300 rounded-lg p-3 text-slate-900 font-medium focus:outline-none focus:border-emerald-600"></textarea>
                </div>

                <div class="flex items-center space-x-2 pt-2">
                    <input type="checkbox" id="is_active" name="is_active" value="1" checked class="w-4 h-4 text-emerald-700 rounded border-slate-300">
                    <label for="is_active" class="font-bold text-slate-800 uppercase text-xs">Aktifkan untuk Pilihan Pemohon</label>
                </div>

                <button type="submit" class="w-full bg-[#064E3B] hover:bg-[#047857] text-white font-extrabold py-3 px-4 rounded-lg text-xs uppercase tracking-wider transition shadow-xs flex items-center justify-center space-x-2">
                    <span>SIMPAN TIPE PERMOHONAN</span>
                    <span>💾</span>
                </button>
            </form>
        </div>

        <!-- RIGHT: TABEL MASTER DATA TIPE PERMOHONAN KI -->
        <div class="lg:col-span-7 bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
            <div class="bg-[#064E3B] text-white px-6 py-4 flex items-center justify-between">
                <h3 class="text-xs font-extrabold uppercase tracking-wider flex items-center gap-2">
                    <span>🏷️</span> DAFTAR TIPE PERMOHONAN KI TERHUBUNG
                </h3>
                <span class="text-[10px] bg-amber-500 text-slate-950 px-2.5 py-0.5 rounded font-extrabold uppercase">
                    TOTAL: {{ $types->count() }} TIPE
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-xs text-left text-slate-700">
                    <thead class="bg-slate-50 text-slate-900 border-b border-slate-200 uppercase text-[10px] font-extrabold">
                        <tr>
                            <th class="py-3 px-5">Nama Tipe KI</th>
                            <th class="py-3 px-5">Kode</th>
                            <th class="py-3 px-5">Status</th>
                            <th class="py-3 px-5 text-center">Aksi Admin</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @forelse($types as $t)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="py-3.5 px-5">
                                    <div class="font-bold text-slate-900 text-sm">{{ $t->name }}</div>
                                    @if($t->description)
                                        <div class="text-[11px] text-slate-500 line-clamp-1 mt-0.5">{{ $t->description }}</div>
                                    @endif
                                </td>
                                <td class="py-3.5 px-5 font-mono font-bold text-emerald-800 uppercase">{{ $t->code }}</td>
                                <td class="py-3.5 px-5">
                                    @if($t->is_active)
                                        <span class="bg-emerald-100 text-emerald-800 border border-emerald-300 font-extrabold text-[10px] px-2 py-0.5 rounded uppercase">AKTIF</span>
                                    @else
                                        <span class="bg-slate-100 text-slate-600 border border-slate-300 font-extrabold text-[10px] px-2 py-0.5 rounded uppercase">NON-AKTIF</span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-5 text-center">
                                    <form action="{{ route('admin.application-types.delete', $t->id) }}" method="POST" onsubmit="return confirm('Hapus tipe permohonan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold text-[11px] px-3 py-1 rounded transition shadow-xs">
                                            HAPUS
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-8 text-center text-slate-500 font-medium">Belum ada tipe permohonan KI yang ditambahkan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection
