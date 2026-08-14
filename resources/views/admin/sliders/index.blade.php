@extends('layouts.dashboard')

@section('title', 'CRUD Slider Banner Homepage - Admin KI UM BIMA')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-8 space-y-8">
    <div class="border-b border-slate-200 pb-3 flex justify-between items-center">
        <div>
            <span class="bg-[#064E3B] text-white text-[10px] font-extrabold px-2.5 py-1 rounded uppercase tracking-wider">
                KONTEN HOMEPAGE
            </span>
            <h2 class="text-2xl font-extrabold text-slate-900 uppercase tracking-tight mt-1">CRUD Slider Banner Homepage</h2>
            <p class="text-xs text-slate-500">Kelola banner slider teks & gambar yang tampil di hero banner halaman depan.</p>
        </div>
    </div>

    <!-- Grid Form & List -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Form Tambah Slider -->
        <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-xs space-y-4">
            <h3 class="font-extrabold text-xs uppercase tracking-wider text-slate-900 border-b border-slate-200 pb-2 flex items-center justify-between">
                <span>Tambah Slider Baru</span>
                <span class="text-[10px] text-emerald-700 font-bold bg-emerald-50 px-2 py-0.5 rounded border border-emerald-200">TEKS / GAMBAR</span>
            </h3>

            <form action="{{ route('admin.sliders.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4 text-xs">
                @csrf
                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wide mb-1">Judul Banner <span class="text-red-600">*</span></label>
                    <input type="text" name="title" required placeholder="Contoh: IP Marketplace & Pangkalan Data" class="w-full border border-slate-300 rounded p-2 focus:outline-none focus:border-emerald-600 font-medium">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wide mb-1">Sub-Judul / Deskripsi Teks Banner</label>
                    <textarea name="subtitle" rows="3" placeholder="Masukkan deskripsi teks seperti pada halaman depan..." class="w-full border border-slate-300 rounded p-2 focus:outline-none focus:border-emerald-600 font-medium"></textarea>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wide mb-1">Badge Tag / Kategori</label>
                    <input type="text" name="badge" placeholder="Contoh: INFO INOVASI UM BIMA atau TERINTEGRASI SIMPAKI DJKI 24/7" class="w-full border border-slate-300 rounded p-2 focus:outline-none focus:border-emerald-600 font-medium">
                    <span class="text-[10px] text-slate-400 mt-0.5 block">Keterangan label kecil di bagian atas judul.</span>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wide mb-1">Gambar Banner (Opsional)</label>
                    <input type="file" name="image" accept="image/*" class="w-full border border-slate-300 rounded p-2 bg-slate-50">
                    <span class="text-[10px] text-slate-400 mt-0.5 block">Kosongkan jika ingin membuat **Slider Teks Gradient** seperti halaman depan.</span>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-bold text-slate-700 uppercase tracking-wide mb-1">Urutan (Order)</label>
                        <input type="number" name="order" value="0" min="0" class="w-full border border-slate-300 rounded p-2 focus:outline-none focus:border-emerald-600 font-medium">
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 uppercase tracking-wide mb-1">Link URL (Opsional)</label>
                        <input type="url" name="link_url" placeholder="https://..." class="w-full border border-slate-300 rounded p-2 focus:outline-none focus:border-emerald-600 font-medium">
                    </div>
                </div>

                <div class="flex items-center space-x-2 pt-1">
                    <input type="checkbox" id="is_active" name="is_active" value="1" checked class="rounded text-emerald-600 focus:ring-emerald-500">
                    <label for="is_active" class="font-bold text-slate-800 uppercase tracking-wide">Tampilkan di Homepage</label>
                </div>

                <button type="submit" class="w-full bg-[#064E3B] hover:bg-[#047857] text-white font-bold py-2.5 rounded text-xs uppercase tracking-wider transition shadow-sm">
                    + SIMPAN SLIDER BANNER
                </button>
            </form>
        </div>

        <!-- Tabel List Sliders -->
        <div class="lg:col-span-2 bg-white rounded-xl border border-slate-200 shadow-xs overflow-hidden">
            <div class="bg-[#064E3B] text-white px-6 py-4 flex justify-between items-center">
                <h3 class="font-extrabold uppercase text-xs tracking-wider">Daftar Slider Banners Active / Inactive</h3>
                <span class="text-[10px] bg-emerald-800 text-emerald-100 font-bold px-2 py-0.5 rounded border border-emerald-700">Total: {{ $sliders->count() }} Slider</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-xs text-left text-slate-700">
                    <thead class="bg-slate-100 uppercase text-[10px] text-slate-500 font-extrabold border-b border-slate-200">
                        <tr>
                            <th class="py-3 px-4">Tipe Banner</th>
                            <th class="py-3 px-4">Konten & Badge Tag</th>
                            <th class="py-3 px-4 text-center">Urutan</th>
                            <th class="py-3 px-4 text-center">Status</th>
                            <th class="py-3 px-4 text-center">Aksi (CRUD)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @forelse($sliders as $s)
                            <tr class="hover:bg-slate-50">
                                <td class="py-3 px-4">
                                    @if($s->image_path)
                                        <div class="space-y-1">
                                            <img src="{{ asset('storage/' . $s->image_path) }}" class="w-24 h-14 object-cover rounded border border-slate-200 shadow-xs">
                                            <span class="text-[9px] font-bold bg-blue-50 text-blue-700 border border-blue-200 px-1.5 py-0.5 rounded block text-center uppercase">GAMBAR</span>
                                        </div>
                                    @else
                                        <div class="w-24 h-14 bg-gradient-to-br from-[#065F46] to-[#047857] text-white rounded p-1.5 flex flex-col justify-center items-center text-center shadow-xs border border-emerald-700">
                                            <span class="text-[14px]">📝</span>
                                            <span class="text-[8px] font-extrabold uppercase tracking-wider text-amber-300">TEKS SLIDER</span>
                                        </div>
                                    @endif
                                </td>
                                <td class="py-3 px-4">
                                    <span class="bg-amber-100 text-amber-900 border border-amber-300 text-[9px] font-extrabold px-2 py-0.5 rounded uppercase inline-block mb-1">
                                        {{ $s->badge ?? 'INFO INOVASI UM BIMA' }}
                                    </span>
                                    <div class="font-bold text-slate-900 text-sm leading-tight">{{ $s->title }}</div>
                                    <div class="text-[11px] text-slate-600 line-clamp-2 mt-1">{{ $s->subtitle ?? '-' }}</div>
                                    @if($s->link_url)
                                        <a href="{{ $s->link_url }}" target="_blank" class="text-[10px] text-emerald-700 font-bold hover:underline block mt-1">🔗 {{ $s->link_url }}</a>
                                    @endif
                                </td>
                                <td class="py-3 px-4 text-center font-bold text-slate-800">
                                    #{{ $s->order }}
                                </td>
                                <td class="py-3 px-4 text-center">
                                    @if($s->is_active)
                                        <span class="bg-emerald-100 text-emerald-800 text-[10px] font-bold px-2.5 py-1 rounded-full border border-emerald-300 uppercase">AKTIF</span>
                                    @else
                                        <span class="bg-slate-100 text-slate-600 text-[10px] font-bold px-2.5 py-1 rounded-full border border-slate-300 uppercase">NON-AKTIF</span>
                                    @endif
                                </td>
                                <td class="py-3 px-4 text-center">
                                    <div class="flex justify-center gap-1.5">
                                        <!-- Edit Button -->
                                        <button type="button" onclick="openEditModal({{ json_encode($s) }})" class="bg-amber-500 hover:bg-amber-600 text-slate-950 px-2.5 py-1 rounded text-[10px] font-bold uppercase transition">
                                            EDIT
                                        </button>

                                        <!-- Toggle Button -->
                                        <form action="{{ route('admin.sliders.toggle', $s->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-2.5 py-1 rounded text-[10px] font-bold uppercase transition">
                                                TOGGLE
                                            </button>
                                        </form>

                                        <!-- Delete Button -->
                                        <form action="{{ route('admin.sliders.delete', $s->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('Hapus slider banner ini?')" class="bg-red-600 hover:bg-red-700 text-white px-2.5 py-1 rounded text-[10px] font-bold uppercase transition">
                                                HAPUS
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-6 text-center text-slate-500">Belum ada slider tersimpan. Banner default fallback akan ditampilkan di homepage.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Slider -->
<div id="editSliderModal" class="hidden fixed inset-0 z-50 bg-slate-950/60 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-xl max-w-lg w-full p-6 shadow-2xl border border-slate-200 space-y-4">
        <div class="flex justify-between items-center border-b border-slate-200 pb-3">
            <h3 class="font-extrabold text-sm uppercase tracking-wider text-slate-900">Edit Data Slider Banner</h3>
            <button onclick="closeEditModal()" class="text-slate-400 hover:text-red-600 text-xl font-bold">&times;</button>
        </div>

        <form id="editSliderForm" action="" method="POST" enctype="multipart/form-data" class="space-y-4 text-xs">
            @csrf
            @method('PUT')

            <div>
                <label class="block font-bold text-slate-700 uppercase tracking-wide mb-1">Judul Banner <span class="text-red-600">*</span></label>
                <input type="text" id="edit_title" name="title" required class="w-full border border-slate-300 rounded p-2 focus:outline-none focus:border-emerald-600 font-medium">
            </div>

            <div>
                <label class="block font-bold text-slate-700 uppercase tracking-wide mb-1">Sub-Judul / Deskripsi Teks</label>
                <textarea id="edit_subtitle" name="subtitle" rows="3" class="w-full border border-slate-300 rounded p-2 focus:outline-none focus:border-emerald-600 font-medium"></textarea>
            </div>

            <div>
                <label class="block font-bold text-slate-700 uppercase tracking-wide mb-1">Badge Tag / Kategori</label>
                <input type="text" id="edit_badge" name="badge" class="w-full border border-slate-300 rounded p-2 focus:outline-none focus:border-emerald-600 font-medium">
            </div>

            <div>
                <label class="block font-bold text-slate-700 uppercase tracking-wide mb-1">Ganti Gambar Banner (Opsional)</label>
                <input type="file" name="image" accept="image/*" class="w-full border border-slate-300 rounded p-2 bg-slate-50">
                <span class="text-[10px] text-slate-400 mt-0.5 block">Biarkan kosong jika tidak ingin mengubah gambar yang ada.</span>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wide mb-1">Urutan (Order)</label>
                    <input type="number" id="edit_order" name="order" min="0" class="w-full border border-slate-300 rounded p-2 focus:outline-none focus:border-emerald-600 font-medium">
                </div>
                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wide mb-1">Link URL (Opsional)</label>
                    <input type="url" id="edit_link_url" name="link_url" class="w-full border border-slate-300 rounded p-2 focus:outline-none focus:border-emerald-600 font-medium">
                </div>
            </div>

            <div class="flex items-center space-x-2 pt-1">
                <input type="checkbox" id="edit_is_active" name="is_active" value="1" class="rounded text-emerald-600 focus:ring-emerald-500">
                <label for="edit_is_active" class="font-bold text-slate-800 uppercase tracking-wide">Tampilkan di Homepage</label>
            </div>

            <div class="flex justify-end space-x-2 pt-3 border-t border-slate-200">
                <button type="button" onclick="closeEditModal()" class="bg-slate-200 hover:bg-slate-300 text-slate-800 px-4 py-2 rounded text-xs font-bold uppercase">
                    BATAL
                </button>
                <button type="submit" class="bg-[#064E3B] hover:bg-[#047857] text-white px-5 py-2 rounded text-xs font-bold uppercase tracking-wider transition">
                    UPDATE SLIDER
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function openEditModal(slider) {
        var form = document.getElementById('editSliderForm');
        form.action = "{{ url('/admin/sliders') }}/" + slider.id;

        document.getElementById('edit_title').value = slider.title || '';
        document.getElementById('edit_subtitle').value = slider.subtitle || '';
        document.getElementById('edit_badge').value = slider.badge || '';
        document.getElementById('edit_order').value = slider.order || 0;
        document.getElementById('edit_link_url').value = slider.link_url || '';
        document.getElementById('edit_is_active').checked = !!slider.is_active;

        document.getElementById('editSliderModal').classList.remove('hidden');
    }

    function closeEditModal() {
        document.getElementById('editSliderModal').classList.add('hidden');
    }
</script>
@endpush
@endsection

