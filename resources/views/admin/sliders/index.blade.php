@extends('layouts.dashboard')

@section('title', 'CRUD Slider Banner Homepage - Admin HKI UM BIMA')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-8 space-y-8">
    <div class="border-b border-slate-200 pb-3 flex justify-between items-center">
        <div>
            <span class="bg-[#064E3B] text-white text-[10px] font-extrabold px-2.5 py-1 rounded uppercase tracking-wider">
                KONTEN HOMEPAGE
            </span>
            <h2 class="text-2xl font-extrabold text-slate-900 uppercase tracking-tight mt-1">CRUD Slider Banner Homepage</h2>
            <p class="text-xs text-slate-500">Kelola gambar banner slider yang tampil di sisi kiri hero banner halaman depan.</p>
        </div>
    </div>

    <!-- Grid Form & List -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Form Tambah Slider -->
        <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-xs space-y-4">
            <h3 class="font-extrabold text-xs uppercase tracking-wider text-slate-900 border-b border-slate-200 pb-2">Tambah Slider Baru</h3>

            <form action="{{ route('admin.sliders.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4 text-xs">
                @csrf
                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wide mb-1">Judul Banner <span class="text-red-600">*</span></label>
                    <input type="text" name="title" required placeholder="Contoh: IP Marketplace & Pangkalan Data" class="w-full border border-slate-300 rounded p-2 focus:outline-none focus:border-emerald-600 font-medium">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wide mb-1">Sub-Judul / Deskripsi Singkat</label>
                    <input type="text" name="subtitle" placeholder="Contoh: Memudahkan pemilik HKI mempromosikan karya..." class="w-full border border-slate-300 rounded p-2 focus:outline-none focus:border-emerald-600 font-medium">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wide mb-1">Gambar Banner Slider <span class="text-red-600">*</span></label>
                    <input type="file" name="image" required accept="image/*" class="w-full border border-slate-300 rounded p-2 bg-slate-50">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wide mb-1">Link URL Tujuan (Opsional)</label>
                    <input type="url" name="link_url" placeholder="https://..." class="w-full border border-slate-300 rounded p-2 focus:outline-none focus:border-emerald-600 font-medium">
                </div>

                <div class="flex items-center space-x-2 pt-1">
                    <input type="checkbox" id="is_active" name="is_active" value="1" checked class="rounded text-emerald-600 focus:ring-emerald-500">
                    <label for="is_active" class="font-bold text-slate-800 uppercase tracking-wide">Tampilkan di Homepage</label>
                </div>

                <button type="submit" class="w-full bg-[#064E3B] hover:bg-[#047857] text-white font-bold py-2.5 rounded text-xs uppercase tracking-wider transition shadow-sm">
                    SIMPAN SLIDER BANNER
                </button>
            </form>
        </div>

        <!-- Tabel List Sliders -->
        <div class="lg:col-span-2 bg-white rounded-xl border border-slate-200 shadow-xs overflow-hidden">
            <div class="bg-[#064E3B] text-white px-6 py-4">
                <h3 class="font-extrabold uppercase text-xs tracking-wider">Daftar Slider Banners Active / Inactive</h3>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-xs text-left text-slate-700">
                    <thead class="bg-slate-100 uppercase text-[10px] text-slate-500 font-extrabold border-b border-slate-200">
                        <tr>
                            <th class="py-3 px-4">Gambar</th>
                            <th class="py-3 px-4">Judul & Subtitle</th>
                            <th class="py-3 px-4">Status</th>
                            <th class="py-3 px-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @forelse($sliders as $s)
                            <tr class="hover:bg-slate-50">
                                <td class="py-3 px-4">
                                    <img src="{{ asset('storage/' . $s->image_path) }}" class="w-20 h-12 object-cover rounded border border-slate-200 shadow-xs">
                                </td>
                                <td class="py-3 px-4">
                                    <div class="font-bold text-slate-900">{{ $s->title }}</div>
                                    <div class="text-[11px] text-slate-500 line-clamp-1 mt-0.5">{{ $s->subtitle ?? '-' }}</div>
                                </td>
                                <td class="py-3 px-4">
                                    @if($s->is_active)
                                        <span class="bg-emerald-100 text-emerald-800 text-[10px] font-bold px-2 py-0.5 rounded border border-emerald-300 uppercase">AKTIF</span>
                                    @else
                                        <span class="bg-slate-100 text-slate-600 text-[10px] font-bold px-2 py-0.5 rounded border border-slate-300 uppercase">NON-AKTIF</span>
                                    @endif
                                </td>
                                <td class="py-3 px-4 text-center">
                                    <div class="flex justify-center gap-2">
                                        <form action="{{ route('admin.sliders.toggle', $s->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-2.5 py-1 rounded text-[10px] font-bold uppercase">
                                                TOGGLE
                                            </button>
                                        </form>

                                        <form action="{{ route('admin.sliders.delete', $s->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('Hapus slider banner ini?')" class="bg-red-600 hover:bg-red-700 text-white px-2.5 py-1 rounded text-[10px] font-bold uppercase">
                                                HAPUS
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-6 text-center text-slate-500">Belum ada slider tersimpan. Banner default fallback akan ditampilkan di homepage.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
