@extends('layouts.dashboard')

@section('title', 'CRUD Welcome Popup Homepage - Admin HKI UMB')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-8 space-y-8">
    <div class="border-b border-slate-200 pb-3 flex justify-between items-center">
        <div>
            <span class="bg-[#002855] text-white text-[10px] font-extrabold px-2.5 py-1 rounded uppercase tracking-wider">
                KONTEN HOMEPAGE
            </span>
            <h2 class="text-2xl font-extrabold text-slate-900 uppercase tracking-tight mt-1">CRUD Welcome Popup Modal</h2>
            <p class="text-xs text-slate-500">Popup ini akan tampil di homepage publik untuk memberikan informasi pengumuman HKI.</p>
        </div>
    </div>

    <!-- Grid Form & List -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Form Tambah Popup -->
        <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-xs space-y-4">
            <h3 class="font-extrabold text-xs uppercase tracking-wider text-slate-900 border-b border-slate-200 pb-2">Tambah Popup Baru</h3>

            <form action="{{ route('admin.popups.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4 text-xs">
                @csrf
                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wide mb-1">Judul Pengumuman <span class="text-red-600">*</span></label>
                    <input type="text" name="title" required placeholder="Contoh: Pembukaan Skema Hibah Paten 2026" class="w-full border border-slate-300 rounded p-2 focus:outline-none focus:border-red-600 font-medium">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wide mb-1">Isi Konten Teks <span class="text-red-600">*</span></label>
                    <textarea name="content" rows="4" required placeholder="Tulis pengumuman di sini..." class="w-full border border-slate-300 rounded p-2 focus:outline-none focus:border-red-600 font-medium"></textarea>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wide mb-1">Gambar Poster (Opsional)</label>
                    <input type="file" name="image" accept="image/*" class="w-full border border-slate-300 rounded p-2 bg-slate-50">
                </div>

                <div class="flex items-center space-x-2 pt-1">
                    <input type="checkbox" id="is_active" name="is_active" value="1" checked class="rounded text-red-600 focus:ring-red-500">
                    <label for="is_active" class="font-bold text-slate-800 uppercase tracking-wide">Aktifkan Langsung di Homepage</label>
                </div>

                <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-2.5 rounded text-xs uppercase tracking-wider transition shadow-sm">
                    SIMPAN WELCOME POPUP
                </button>
            </form>
        </div>

        <!-- Tabel List Popups -->
        <div class="lg:col-span-2 bg-white rounded-xl border border-slate-200 shadow-xs overflow-hidden">
            <div class="bg-[#002855] text-white px-6 py-4">
                <h3 class="font-extrabold uppercase text-xs tracking-wider">Daftar Welcome Popup Active / Inactive</h3>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-xs text-left text-slate-700">
                    <thead class="bg-slate-100 uppercase text-[10px] text-slate-500 font-extrabold border-b border-slate-200">
                        <tr>
                            <th class="py-3 px-4">Poster</th>
                            <th class="py-3 px-4">Judul & Konten</th>
                            <th class="py-3 px-4">Status</th>
                            <th class="py-3 px-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @forelse($popups as $p)
                            <tr class="hover:bg-slate-50">
                                <td class="py-3 px-4">
                                    @if($p->image_path)
                                        <img src="{{ asset('storage/' . $p->image_path) }}" class="w-16 h-12 object-cover rounded border border-slate-200">
                                    @else
                                        <span class="text-slate-400 italic">No Image</span>
                                    @endif
                                </td>
                                <td class="py-3 px-4">
                                    <div class="font-bold text-slate-900">{{ $p->title }}</div>
                                    <div class="text-[11px] text-slate-500 line-clamp-2 mt-0.5">{{ $p->content }}</div>
                                </td>
                                <td class="py-3 px-4">
                                    @if($p->is_active)
                                        <span class="bg-emerald-100 text-emerald-800 text-[10px] font-bold px-2 py-0.5 rounded border border-emerald-300 uppercase">AKTIF</span>
                                    @else
                                        <span class="bg-slate-100 text-slate-600 text-[10px] font-bold px-2 py-0.5 rounded border border-slate-300 uppercase">NON-AKTIF</span>
                                    @endif
                                </td>
                                <td class="py-3 px-4 text-center">
                                    <div class="flex justify-center gap-2">
                                        <form action="{{ route('admin.popups.toggle', $p->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-2.5 py-1 rounded text-[10px] font-bold uppercase">
                                                TOGGLE
                                            </button>
                                        </form>

                                        <form action="{{ route('admin.popups.delete', $p->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('Hapus popup ini?')" class="bg-red-600 hover:bg-red-700 text-white px-2.5 py-1 rounded text-[10px] font-bold uppercase">
                                                HAPUS
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-6 text-center text-slate-500">Belum ada popup tersimpan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
