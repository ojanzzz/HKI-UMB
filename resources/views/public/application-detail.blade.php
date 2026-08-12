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
                    DETAIL AJUAN HKI #{{ $application->id }}
                </span>
                <span class="bg-white/20 text-white text-[10px] font-bold px-2.5 py-1 rounded-full uppercase border border-white/20">
                    {{ strtoupper($application->application_type) }}
                </span>
                @if($application->status === 'paid' || $application->status === 'submitted_to_djki')
                    <span class="bg-emerald-400 text-emerald-950 text-[10px] font-extrabold px-2.5 py-1 rounded-full uppercase">
                        ✓ TERDAFTAR DJKI
                    </span>
                @else
                    <span class="bg-amber-400 text-amber-950 text-[10px] font-extrabold px-2.5 py-1 rounded-full uppercase">
                        PROSES VERIFIKASI
                    </span>
                @endif
            </div>
            <h1 class="text-xl font-extrabold text-white uppercase tracking-tight leading-tight">
                {{ $application->title }}
            </h1>
        </div>
        <div class="px-6 py-3 bg-slate-50 border-t border-slate-200">
            <span class="text-[10px] text-slate-500 font-mono">
                No. Permohonan DJKI:
                <strong class="text-slate-800 ml-1">
                    {{ $application->djki_application_number ?? ('PTN' . date('Ymd', strtotime($application->created_at)) . $application->id) }}
                </strong>
            </span>
        </div>
    </div>

    {{-- =========================================================
         IMAGE + DESCRIPTION (Proportional Grid)
    ========================================================== --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 items-start">

        {{-- Foto Produk (klik-to-enlarge) --}}
        @if($application->product_image_path)
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="bg-slate-50 border-b border-slate-200 px-4 py-2.5">
                        <span class="text-[10px] font-extrabold text-slate-600 uppercase tracking-wider flex items-center gap-1">
                            <span>📷</span> Foto Produk Invensi
                        </span>
                    </div>
                    <div class="p-3">
                        <div class="relative group cursor-pointer rounded-xl overflow-hidden border border-slate-200 bg-slate-100"
                             onclick="openImageLightbox('{{ asset('storage/' . $application->product_image_path) }}', '{{ $application->title }}')">
                            <img src="{{ asset('storage/' . $application->product_image_path) }}"
                                 alt="Foto Produk {{ $application->title }}"
                                 class="w-full h-52 object-cover object-center transition-opacity duration-200 group-hover:opacity-85">
                            <div class="absolute inset-0 flex items-end justify-center pb-3 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                <span class="text-white text-[10px] font-bold bg-slate-900/70 px-3 py-1 rounded-full backdrop-blur-sm">
                                    🔍 Klik untuk perbesar
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="lg:col-span-2 space-y-4">
        @else
            <div class="lg:col-span-3 space-y-4">
        @endif

            {{-- Deskripsi Invensi --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                <h2 class="text-sm font-extrabold text-slate-800 uppercase tracking-wider mb-3 flex items-center gap-2">
                    <span>📝</span>
                    <span>Deskripsi Invensi / Karya HKI</span>
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
            <span>Daftarkan HKI Anda Sekarang</span>
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
