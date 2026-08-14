@extends('layouts.app')

@section('title', 'Detail Ajuan ' . strtoupper($application->application_type) . ' - UM BIMA')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 py-8 space-y-6">

    {{-- Back Button --}}
    <div>
        <a href="{{ route('home') }}" class="inline-flex items-center gap-1.5 bg-white hover:bg-slate-50 text-slate-700 font-bold px-4 py-2 rounded-xl text-xs uppercase tracking-wider transition border border-slate-200 shadow-xs">
            &larr; Kembali ke Beranda
        </a>
    </div>

    {{-- =========================================================
         HEADER CARD: Judul, Badge, No. DJKI
    ========================================================== --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="bg-gradient-to-r from-[#064E3B] to-[#047857] px-6 py-5">
            <div class="flex flex-wrap items-center gap-2 mb-3">
                <span class="bg-white/20 text-white text-[10px] font-extrabold px-2.5 py-1 rounded-full uppercase tracking-wider">
                    DETAIL AJUAN KI #{{ $application->id }}
                </span>
                <span class="bg-white/20 text-white text-[10px] font-bold px-2.5 py-1 rounded-full uppercase border border-white/20">
                    {{ strtoupper($application->application_type) }}
                </span>
                @if($application->status === 'paid' || $application->status === 'submitted_to_djki')
                    <span class="bg-emerald-400 text-emerald-950 text-[10px] font-extrabold px-2.5 py-1 rounded-full uppercase">
                        ✓ TERDAFTAR DJKI
                    </span>
                @endif
            </div>

            <h1 class="text-xl md:text-2xl font-extrabold text-white tracking-tight leading-tight">
                {{ $application->title }}
            </h1>

            <div class="flex flex-wrap items-center gap-4 text-xs text-white/80 mt-3 font-medium">
                <div class="flex items-center gap-1.5">
                    <span>👤</span>
                    <span>Pemohon: <strong class="text-white">{{ $application->user->name ?? 'Sivitas UM BIMA' }}</strong></span>
                </div>
                @if($application->user->faculty)
                    <div class="flex items-center gap-1.5">
                        <span>🏛️</span>
                        <span>Fakultas: <strong class="text-white">{{ $application->user->faculty }}</strong></span>
                    </div>
                @endif
                <div class="flex items-center gap-1.5">
                    <span>📅</span>
                    <span>Tgl Pengajuan: <strong class="text-white">{{ $application->created_at->format('d F Y') }}</strong></span>
                </div>
            </div>
        </div>

        {{-- Row Info --}}
        <div class="grid grid-cols-2 sm:grid-cols-4 divide-x divide-y sm:divide-y-0 divide-slate-100 bg-slate-50 text-xs font-semibold text-slate-600 border-t border-slate-200">
            <div class="p-4 text-center">
                <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Status Pengajuan</span>
                <span class="bg-emerald-100 text-emerald-900 border border-emerald-300 font-extrabold px-3 py-1 rounded-full text-[10px] uppercase">
                    {{ strtoupper(str_replace('_', ' ', $application->status)) }}
                </span>
            </div>
            <div class="p-4 text-center">
                <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">No. Permohonan DJKI</span>
                <span class="font-bold text-slate-900 font-mono">
                    {{ $application->djki_application_number ?? ('PTN' . date('Ymd', strtotime($application->created_at)) . $application->id) }}
                </span>
            </div>
            <div class="p-4 text-center">
                <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Kategori Pengajuan</span>
                <span class="font-bold text-slate-900 uppercase">
                    {{ $application->application_category ?? 'UMKM' }}
                </span>
            </div>
            <div class="p-4 text-center">
                <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Dokumen Lengkap</span>
                <span class="font-bold text-slate-900">
                    {{ $application->documents->count() }} / 8 Dokumen
                </span>
            </div>
        </div>
    </div>

    {{-- =========================================================
         BODY: Visual Preview Invensi + Deskripsi
    ========================================================== --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Left: Foto Produk Invensi (Visual Cards) --}}
        <div class="lg:col-span-1 space-y-4">
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 text-center space-y-3">
                <h2 class="text-xs font-extrabold text-slate-800 uppercase tracking-wider flex items-center justify-center gap-1.5">
                    <span>📷</span>
                    <span>Visual Produk Invensi</span>
                </h2>

                @if($application->product_image_path)
                    <div class="relative group cursor-pointer overflow-hidden rounded-xl border border-slate-200 shadow-xs bg-slate-50"
                         onclick="openImageLightbox('{{ asset('storage/' . $application->product_image_path) }}')">
                        <img src="{{ asset('storage/' . $application->product_image_path) }}" alt="Visual Invensi"
                             class="w-full h-52 object-cover group-hover:scale-105 transition-transform duration-300">
                        <div class="absolute inset-0 bg-slate-900/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center text-white text-xs font-bold gap-1">
                            <span>🔍</span> Klik Perbesar
                        </div>
                    </div>
                @else
                    <div class="w-full h-44 bg-slate-100 rounded-xl border-2 border-dashed border-slate-200 flex flex-col items-center justify-center text-slate-400 p-4 space-y-1">
                        <span class="text-3xl">🖼️</span>
                        <span class="text-[11px] font-bold text-slate-500">Tidak Ada Foto Produk</span>
                        <span class="text-[10px] text-slate-400 text-center">Pemohon tidak mengunggah foto visual produk invensi</span>
                    </div>
                @endif
            </div>
        </div>

        {{-- Right: Deskripsi Invensi --}}
        <div class="lg:col-span-2 space-y-4">
            {{-- Deskripsi Invensi --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                <h2 class="text-sm font-extrabold text-slate-800 uppercase tracking-wider mb-3 flex items-center gap-2">
                    <span>📝</span>
                    <span>Deskripsi Invensi / Karya KI</span>
                </h2>
                <p class="text-sm text-slate-700 leading-relaxed">
                    {{ $application->description ?? ('Invensi mengenai ' . strtolower($application->title) . ' oleh sivitas akademika ' . ($application->user->faculty ?? 'UM BIMA') . '.') }}
                </p>
            </div>
        </div>
    </div>

    {{-- =========================================================
         LIGHTBOX MODAL
    ========================================================== --}}
    <div id="imageLightboxModal" class="fixed inset-0 z-[100] bg-black/80 backdrop-blur-sm hidden items-center justify-center p-4">
        <div class="relative max-w-5xl max-h-[90vh] w-full flex items-center justify-center">
            <img id="lightboxImage" src="" alt="Foto Produk"
                 class="max-w-full max-h-[85vh] object-contain rounded-2xl shadow-2xl">
            <button onclick="closeImageLightbox()"
                    class="absolute top-3 right-3 bg-white/15 hover:bg-white/30 text-white p-2.5 rounded-full transition-colors backdrop-blur-sm border border-white/20">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>

    {{-- =========================================================
         DAFTAR PEMOHON & ANGGOTA
    ========================================================== --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="bg-slate-50 border-b border-slate-200 px-6 py-4 flex items-center justify-between">
            <h2 class="text-sm font-extrabold text-slate-900 uppercase tracking-wide flex items-center gap-2">
                <span>👥</span>
                <span>Daftar Pemohon & Anggota</span>
            </h2>
            <span class="text-[10px] font-bold text-slate-600 bg-white border border-slate-200 px-2.5 py-1 rounded-full">
                {{ $application->applicants->count() }} Orang
            </span>
        </div>

        <div class="divide-y divide-slate-100">
            @forelse($application->applicants as $idx => $applicant)
                <div class="flex items-center justify-between px-6 py-4">
                    <div class="flex items-center gap-3">
                        <span class="bg-[#064E3B] text-white text-[10px] font-extrabold w-7 h-7 rounded-full flex items-center justify-center shrink-0">
                            {{ $idx + 1 }}
                        </span>
                        <div>
                            <span class="font-extrabold text-slate-900 text-sm block">{{ $applicant->applicant_name }}</span>
                            <div class="flex flex-wrap gap-1.5 mt-0.5">
                                @if($applicant->is_primary)
                                    <span class="bg-emerald-100 text-emerald-800 text-[9px] font-bold px-2 py-0.5 rounded-full border border-emerald-200 uppercase">
                                        Pemohon Utama
                                    </span>
                                @endif
                                @if($applicant->applicant_nik)
                                    <span class="text-[10px] text-slate-500 font-mono">NIK: {{ $applicant->applicant_nik }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    @if($applicant->applicant_faculty)
                        <span class="text-[10px] text-slate-600 font-medium bg-slate-100 px-3 py-1 rounded-full border border-slate-200 hidden sm:block">
                            {{ $applicant->applicant_faculty }}
                        </span>
                    @endif
                </div>
            @empty
                <div class="text-center py-10 text-slate-400 text-sm">
                    <span class="text-2xl block mb-2">👤</span>
                    Belum ada data anggota / pemohon terdaftar.
                </div>
            @endforelse
        </div>
    </div>

    {{-- Footer CTA --}}
    <div class="flex justify-center pt-2 pb-6">
        <a href="{{ route('login') }}" class="bg-[#064E3B] hover:bg-[#047857] text-white font-extrabold px-8 py-3.5 rounded-2xl text-xs uppercase tracking-wider transition shadow-md flex items-center gap-2">
            <span>🔒</span>
            <span>Daftarkan KI Anda Sekarang</span>
        </a>
    </div>

</div>

@push('scripts')
<script>
    const lightboxModal = document.getElementById('imageLightboxModal');
    const lightboxImg = document.getElementById('lightboxImage');

    function openImageLightbox(imgSrc, altText) {
        lightboxImg.src = imgSrc;
        lightboxImg.alt = altText || 'Foto Produk';
        lightboxModal.classList.remove('hidden');
        lightboxModal.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }

    function closeImageLightbox() {
        lightboxModal.classList.add('hidden');
        lightboxModal.classList.remove('flex');
        lightboxImg.src = '';
        document.body.style.overflow = '';
    }

    if (lightboxModal) {
        lightboxModal.addEventListener('click', function(e) {
            if (e.target === lightboxModal) closeImageLightbox();
        });
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && lightboxModal && !lightboxModal.classList.contains('hidden')) {
            closeImageLightbox();
        }
    });
</script>
@endpush
@endsection
