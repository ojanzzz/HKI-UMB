@extends('layouts.app')

@section('title', 'Beranda - Direktorat Inovasi dan Kekayaan Intelektual (KI) UM Bima')

@section('content')
<!-- HERO SECTION: LEFT SLIDER BANNER & RIGHT PDKI SEARCH BOX (per UI DJKI Screenshot) -->
<section class="bg-gradient-to-r from-[#064E3B] to-[#047857] text-white py-8 px-6 md:px-12">
    <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-12 gap-8 items-stretch">
        
        <!-- LEFT SIDE: SLIDER BANNER CAROUSEL -->
        <div class="lg:col-span-7 relative group flex flex-col justify-between rounded-2xl overflow-hidden shadow-2xl border border-emerald-400/30 bg-emerald-950/40 backdrop-blur-sm min-h-[360px]">
            <div id="heroBannerCarousel" class="relative w-full h-full min-h-[360px] overflow-hidden">
                @if(isset($sliders) && $sliders->isNotEmpty())
                    @foreach($sliders as $index => $slider)
                        <div class="hero-slide absolute inset-0 transition-opacity duration-700 ease-in-out {{ $index === 0 ? 'opacity-100 z-10' : 'opacity-0 z-0' }}">
                            @if($slider->image_path)
                                <img src="{{ asset('storage/' . $slider->image_path) }}" alt="{{ $slider->title }}" class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-gradient-to-t from-emerald-950/90 via-emerald-950/40 to-transparent p-6 md:p-8 flex flex-col justify-end">
                                    <span class="bg-amber-500 text-slate-950 text-[10px] font-extrabold px-2.5 py-0.5 rounded uppercase tracking-wider w-fit mb-2">
                                        {{ $slider->badge ?? 'INFO INOVASI UM BIMA' }}
                                    </span>
                                    <h3 class="text-xl md:text-2xl font-extrabold text-white leading-tight uppercase">{{ $slider->title }}</h3>
                                    @if($slider->subtitle)
                                        <p class="text-xs text-emerald-100 mt-1 line-clamp-2">{{ $slider->subtitle }}</p>
                                    @endif
                                    @if($slider->link_url)
                                        <a href="{{ $slider->link_url }}" target="_blank" class="mt-3 inline-flex items-center text-xs font-bold text-amber-300 hover:text-amber-200 uppercase tracking-wider">
                                            Selengkapnya &rarr;
                                        </a>
                                    @endif
                                </div>
                            @else
                                <!-- Text-Only Slider Banner -->
                                <div class="w-full h-full bg-gradient-to-br from-[#065F46] via-[#047857] to-[#064E3B] p-8 flex flex-col justify-center space-y-4">
                                     <div class="inline-flex items-center space-x-2 bg-amber-500/20 border border-amber-400/40 text-amber-300 px-3 py-1 rounded text-xs font-extrabold tracking-wider uppercase w-fit">
                                         {{ $slider->badge ?? 'DIREKTORAT INOVASI DAN KEKAYAAN INTELEKTUAL (KI) UM BIMA' }}
                                     </div>
                                    <h2 class="text-2xl md:text-3xl font-extrabold text-white leading-tight">
                                        {{ $slider->title }}
                                    </h2>
                                    @if($slider->subtitle)
                                        <p class="text-xs md:text-sm text-emerald-100 leading-relaxed max-w-xl">
                                            {{ $slider->subtitle }}
                                        </p>
                                    @endif
                                    @if($slider->link_url)
                                        <a href="{{ $slider->link_url }}" target="_blank" class="inline-block bg-amber-500 hover:bg-amber-400 text-slate-950 px-4 py-2 rounded text-xs font-extrabold uppercase tracking-wider w-fit shadow-xs transition">
                                            Pelajari Selengkapnya &rarr;
                                        </a>
                                    @endif
                                </div>
                            @endif
                        </div>
                    @endforeach
                @else
                    <!-- Fallback Sliders jika belum ada slider dari Admin -->
                    <div class="hero-slide absolute inset-0 transition-opacity duration-700 ease-in-out opacity-100 z-10">
                        <div class="w-full h-full bg-gradient-to-br from-[#065F46] to-[#047857] p-8 flex flex-col justify-center space-y-4">
                            <div class="inline-flex items-center space-x-2 bg-amber-500/20 border border-amber-400/40 text-amber-300 px-3 py-1 rounded text-xs font-extrabold tracking-wider uppercase w-fit">
                                DIREKTORAT INOVASI DAN KEKAYAAN INTELEKTUAL (KI) UM BIMA
                            </div>
                            <h2 class="text-2xl md:text-3xl font-extrabold text-white leading-tight">
                                IP Marketplace & Pangkalan Data Kekayaan Intelektual UM BIMA
                            </h2>
                            <p class="text-xs md:text-sm text-emerald-100 leading-relaxed max-w-xl">
                                Memudahkan para pemilik Kekayaan Intelektual dalam mempromosikan, menjual, dan melisensikan karya intelektualnya kepada calon investor dan DJKI Kemenkumham.
                            </p>
                        </div>
                    </div>
                    <div class="hero-slide absolute inset-0 transition-opacity duration-700 ease-in-out opacity-0 z-0">
                        <div class="w-full h-full bg-gradient-to-br from-[#047857] to-[#064E3B] p-8 flex flex-col justify-center space-y-4">
                            <div class="inline-flex items-center space-x-2 bg-emerald-400/20 border border-emerald-400/40 text-emerald-200 px-3 py-1 rounded text-xs font-extrabold tracking-wider uppercase w-fit">
                                TERINTEGRASI SIMPAKI DJKI 24/7
                            </div>
                            <h2 class="text-2xl md:text-3xl font-extrabold text-white leading-tight">
                                Otomatisasi 8 Dokumen Paten & E-Signature Canvas HTML5
                            </h2>
                            <p class="text-xs md:text-sm text-emerald-100 leading-relaxed max-w-xl">
                                Dapatkan kemudahan penandatanganan dokumen secara digital dan unduhan paket ZIP 8 dokumen resmi siap submit ke DJKI.
                            </p>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Slider Controls -->
            <div class="absolute bottom-4 right-4 z-20 flex space-x-2">
                <button id="heroPrevBtn" class="w-8 h-8 bg-emerald-950/80 hover:bg-amber-500 text-white hover:text-slate-950 rounded-full flex items-center justify-center font-bold text-xs transition">❮</button>
                <button id="heroNextBtn" class="w-8 h-8 bg-emerald-950/80 hover:bg-amber-500 text-white hover:text-slate-950 rounded-full flex items-center justify-center font-bold text-xs transition">❯</button>
            </div>
        </div>

        <!-- RIGHT SIDE: PANGKALAN DATA KI SEARCH BOX (Exact DJKI Layout Screenshot) -->
        <div class="lg:col-span-5 bg-white text-slate-900 rounded-2xl p-6 md:p-8 shadow-2xl border border-slate-200 flex flex-col justify-between">
            <div>
                <h3 class="text-2xl font-extrabold text-slate-900 leading-tight uppercase tracking-tight">
                    Pangkalan Data Kekayaan Intelektual
                </h3>
                <p class="text-xs text-slate-500 mt-1">Cari data paten, merek, hak cipta di portal nasional DJKI Kemenkumham RI</p>

                <form action="https://pdki-indonesia.dgip.go.id/search" method="GET" target="_blank" class="mt-6 space-y-4 text-xs">
                    <div>
                        <label class="block font-bold text-slate-700 uppercase tracking-wide mb-1">Kata Kunci</label>
                        <input type="text" name="q" required placeholder="Kata Kunci..." class="w-full bg-slate-50 border border-slate-300 rounded-lg p-3 text-slate-900 focus:outline-none focus:border-emerald-600 font-medium">
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 uppercase tracking-wide mb-1">Kategori Kekayaan Intelektual</label>
                        <select name="type" class="w-full bg-slate-50 border border-slate-300 rounded-lg p-3 text-slate-900 focus:outline-none focus:border-emerald-600 font-medium">
                            <option value="merek">Merek</option>
                            <option value="paten">Paten & Paten Sederhana</option>
                            <option value="hakcipta">Hak Cipta</option>
                            <option value="desainindustri">Desain Industri</option>
                            <option value="indikasi_geografis">Indikasi Geografis</option>
                            <option value="dtst">DTST</option>
                            <option value="kik">KI Komunal</option>
                        </select>
                    </div>

                    <button type="submit" class="w-full bg-amber-500 hover:bg-amber-600 text-slate-950 font-extrabold py-3.5 px-4 rounded-lg uppercase tracking-wider transition shadow-md flex items-center justify-center space-x-2">
                        <span>CARI DATA PDKI</span>
                        <span>🔍</span>
                    </button>
                </form>
            </div>

            <div class="mt-4 pt-3 border-t border-slate-100 flex justify-between items-center text-[11px] text-slate-500">
                <span>Terhubung ke <strong class="text-emerald-700">pdki-indonesia.dgip.go.id</strong></span>
                <a href="https://www.dgip.go.id/" target="_blank" class="text-emerald-700 font-bold hover:underline">Portal DJKI &rarr;</a>
            </div>
        </div>

    </div>
</section>

<!-- SECTION TABEL DAFTAR SEMUA AJUAN PERMOHONAN (per Screenshot 1 UI) -->
<section class="max-w-7xl mx-auto px-6 py-10">
    <div class="bg-white rounded-2xl border border-slate-200 shadow-md overflow-hidden">
        
        <!-- Table Header Bar Deep Emerald Green -->
        <div class="bg-[#064E3B] text-white px-6 py-4 flex items-center justify-between">
            <h3 class="text-base font-extrabold uppercase tracking-wide flex items-center gap-2">
                <span>📋</span> DAFTAR SEMUA AJUAN PERMOHONAN KI UM BIMA
            </h3>
            <span class="text-xs bg-emerald-900 text-emerald-200 px-3 py-1 rounded font-semibold border border-emerald-700">
                Publik & Sivitas UM BIMA
            </span>
        </div>

        <!-- Filter Controls Bar (Tampilkan N & Live Search) -->
        <div class="p-6 bg-slate-50 border-b border-slate-200 flex flex-col md:flex-row justify-between items-start md:items-center gap-4 text-xs">
            <div class="flex items-center space-x-2">
                <span class="font-bold text-slate-700 uppercase">Tampilkan</span>
                <select id="tableEntriesSelect" class="border border-slate-300 rounded p-2 bg-white font-bold text-slate-800 focus:outline-none focus:border-emerald-600">
                    <option value="15">15</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                </select>
                <span class="font-bold text-slate-700 uppercase">permohonan</span>
            </div>

            <div class="flex items-center space-x-2 w-full md:w-auto">
                <span class="font-bold text-slate-700 uppercase whitespace-nowrap">cari data apapun di sini:</span>
                <input type="text" id="tableSearchInput" placeholder="jenis,nomor,status,fakultas,judul..." class="w-full md:w-72 border border-slate-300 rounded p-2 bg-white text-slate-900 focus:outline-none focus:border-emerald-600 font-medium">
            </div>
        </div>

        <!-- Table Data Ajuan Permohonan -->
        <div class="overflow-x-auto">
            <table class="w-full text-xs text-left text-slate-700" id="publicApplicationsTable">
                <thead class="bg-slate-100 uppercase text-[10px] text-slate-500 font-extrabold border-b border-slate-200">
                    <tr>
                        <th class="py-3.5 px-4 w-12 text-center">NO.</th>
                        <th class="py-3.5 px-4 w-28">JENIS</th>
                        <th class="py-3.5 px-4">JUDUL - STATUS</th>
                        <th class="py-3.5 px-4">NO. PERMOHONAN</th>
                        <th class="py-3.5 px-4 max-w-xs">DESKRIPSI</th>
                        <th class="py-3.5 px-4 w-24 text-center">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($publicApplications as $index => $app)
                        <tr class="hover:bg-emerald-50/50 transition-colors search-row">
                            <td class="py-4 px-4 text-center font-bold text-slate-800">{{ $index + 1 }}</td>
                            <td class="py-4 px-4">
                                <span class="bg-emerald-600 text-white text-[10px] font-extrabold px-2.5 py-1 rounded uppercase tracking-wider shadow-xs">
                                    {{ strtoupper($app->application_type) }}
                                </span>
                            </td>
                            <td class="py-4 px-4">
                                <div class="font-extrabold text-slate-900 uppercase tracking-wide">{{ $app->title }}</div>
                                <div class="text-[10px] mt-1">
                                    @if($app->status === 'paid' || $app->status === 'submitted_to_djki')
                                        <span class="text-emerald-700 font-bold bg-emerald-100 px-2 py-0.5 rounded border border-emerald-300">✓ TERDAFTAR DJKI</span>
                                    @else
                                        <span class="text-amber-700 font-bold bg-amber-100 px-2 py-0.5 rounded border border-amber-300">PROSES VERIFIKASI</span>
                                    @endif
                                </div>
                            </td>
                            <td class="py-4 px-4 font-mono font-bold text-slate-800">
                                {{ $app->djki_application_number ?? ('PTN' . date('Ymd', strtotime($app->created_at)) . $app->id) }}
                            </td>
                            <td class="py-4 px-4 text-slate-600 leading-relaxed">
                                {{ $app->description ?? ('Invensi mengenai ' . strtolower($app->title) . ' oleh sivitas akademika ' . ($app->user->faculty ?? 'UM BIMA') . '.') }}
                            </td>
             <td class="py-4 px-4 text-center">
                                 <a href="{{ route('public.applications.show', $app->id) }}" class="bg-emerald-700 hover:bg-emerald-800 text-white px-3.5 py-1.5 rounded text-[11px] font-bold uppercase tracking-wider transition shadow-xs">
                                     Detail
                                 </a>
                             </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-slate-500 font-medium">Belum ada ajuan permohonan KI yang terdaftar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-200 bg-slate-50">
            {{ $publicApplications->links() }}
        </div>
    </div>
</section>

<!-- MENU UTAMA & LAYANAN DJKI -->
<section class="max-w-7xl mx-auto px-6 py-8">
    <div class="mb-6 text-center">
        <h2 class="text-2xl font-extrabold text-slate-900 uppercase tracking-tight">Kategori Layanan Kekayaan Intelektual UM BIMA</h2>
        <p class="text-xs text-slate-500 mt-1">Pilih kategori permohonan KI yang ingin Anda daftarkan melalui Direktorat Inovasi dan Kekayaan Intelektual (KI) UM Bima</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Service 1: Paten -->
        <div class="bg-white rounded-xl border border-slate-200 hover:border-emerald-600 p-6 shadow-xs hover:shadow-md transition-all duration-200 flex flex-col justify-between group">
            <div>
                <div class="flex items-center justify-between gap-2 mb-4">
                    <div class="w-12 h-12 bg-emerald-50 text-emerald-700 rounded-lg flex items-center justify-center font-bold text-lg">
                        📜
                    </div>
                    <span class="text-[11px] font-bold bg-slate-100 text-slate-700 px-2.5 py-1 rounded border border-slate-200 uppercase tracking-wider">
                        UTAMA
                    </span>
                </div>
                <h3 class="text-base font-bold text-slate-900 group-hover:text-emerald-700 transition-colors mb-1.5 uppercase tracking-wide">
                    Paten & Paten Sederhana
                </h3>
                <p class="text-xs text-slate-500 leading-relaxed mb-4">
                    Pelindungan invensi teknologi, alat baru, metode, dan komposisi. Mendukung 8 dokumen wajib dan otomatisasi E-Signature.
                </p>
            </div>
            <a href="{{ route('login') }}" class="w-full bg-[#064E3B] hover:bg-[#047857] text-white font-bold text-xs py-2.5 px-3 rounded-md transition flex items-center justify-center uppercase tracking-wider">
                AJUKAN PATEN
            </a>
        </div>

        <!-- Service 2: Hak Cipta -->
        <div class="bg-white rounded-xl border border-slate-200 hover:border-emerald-600 p-6 shadow-sm hover:shadow-md transition-all duration-200 flex flex-col justify-between group">
            <div>
                <div class="flex items-center justify-between gap-2 mb-4">
                    <div class="w-12 h-12 bg-emerald-50 text-emerald-700 rounded-lg flex items-center justify-center font-bold text-lg">
                        💡
                    </div>
                    <span class="text-[11px] font-bold bg-slate-100 text-slate-700 px-2.5 py-1 rounded border border-slate-200 uppercase tracking-wider">
                        KARYA
                    </span>
                </div>
                <h3 class="text-base font-bold text-slate-900 group-hover:text-emerald-700 transition-colors mb-1.5 uppercase tracking-wide">
                    Hak Cipta Karya Ilmu
                </h3>
                <p class="text-xs text-slate-500 leading-relaxed mb-4">
                    Pelindungan ciptaan buku, jurnal, karya tulis ilmiah, program komputer, aplikasi, serta peta pendukung riset.
                </p>
            </div>
            <a href="{{ route('login') }}" class="w-full bg-[#064E3B] hover:bg-[#047857] text-white font-bold text-xs py-2.5 px-3 rounded-md transition flex items-center justify-center uppercase tracking-wider">
                AJUKAN HAK CIPTA
            </a>
        </div>

        <!-- Service 3: Desain Industri -->
        <div class="bg-white rounded-xl border border-slate-200 hover:border-emerald-600 p-6 shadow-sm hover:shadow-md transition-all duration-200 flex flex-col justify-between group">
            <div>
                <div class="flex items-center justify-between gap-2 mb-4">
                    <div class="w-12 h-12 bg-amber-50 text-amber-600 rounded-lg flex items-center justify-center font-bold text-lg">
                        🎨
                    </div>
                    <span class="text-[11px] font-bold bg-slate-100 text-slate-700 px-2.5 py-1 rounded border border-slate-200 uppercase tracking-wider">
                        BENTUK
                    </span>
                </div>
                <h3 class="text-base font-bold text-slate-900 group-hover:text-emerald-700 transition-colors mb-1.5 uppercase tracking-wide">
                    Desain Industri
                </h3>
                <p class="text-xs text-slate-500 leading-relaxed mb-4">
                    Pelindungan estetika bentuk 3 dimensi, rancangan produk fisik, kemasan industri, dan prototipe produk.
                </p>
            </div>
            <a href="{{ route('login') }}" class="w-full bg-[#064E3B] hover:bg-[#047857] text-white font-bold text-xs py-2.5 px-3 rounded-md transition flex items-center justify-center uppercase tracking-wider">
                AJUKAN DESAIN
            </a>
        </div>
    </div>
</section>

<!-- Welcome Popup Modal (jika ada active popup) -->
@if(isset($activePopup) && $activePopup)
<div id="welcomePopupModal" class="fixed inset-0 z-50 bg-emerald-950/80 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-xl border border-slate-200 max-w-lg w-full overflow-hidden shadow-2xl">
        <div class="bg-[#064E3B] text-white px-6 py-4 flex justify-between items-center">
            <h3 class="text-sm font-bold uppercase tracking-wider flex items-center gap-2">
                <span>📢</span> {{ $activePopup->title }}
            </h3>
            <button onclick="closeWelcomePopup()" class="text-white hover:text-amber-400 font-extrabold text-lg">&times;</button>
        </div>
        <div class="p-6 space-y-4 text-xs text-slate-700 leading-relaxed">
            @if($activePopup->image_path)
                <img src="{{ asset('storage/' . $activePopup->image_path) }}" alt="{{ $activePopup->title }}" class="w-full h-48 object-cover rounded-lg border border-slate-200">
            @endif
            <div class="prose max-w-none">
                {!! nl2br(e($activePopup->content)) !!}
            </div>
        </div>
        <div class="bg-slate-50 border-t border-slate-200 px-6 py-3 flex justify-end">
            <button onclick="closeWelcomePopup()" class="bg-[#064E3B] hover:bg-[#047857] text-white px-5 py-2 rounded text-xs font-bold uppercase tracking-wider">
                TUTUP PENGUMUMAN
            </button>
        </div>
    </div>
</div>
@endif

@push('scripts')
<script>
    function closeWelcomePopup() {
        const modal = document.getElementById('welcomePopupModal');
        if (modal) modal.style.display = 'none';
    }

    // Hero Left Banner Auto-Slider JavaScript
    document.addEventListener('DOMContentLoaded', function () {
        const slides = document.querySelectorAll('.hero-slide');
        const prevBtn = document.getElementById('heroPrevBtn');
        const nextBtn = document.getElementById('heroNextBtn');
        let currentSlide = 0;

        function showSlide(index) {
            slides.forEach((slide, i) => {
                if (i === index) {
                    slide.classList.remove('opacity-0', 'z-0');
                    slide.classList.add('opacity-100', 'z-10');
                } else {
                    slide.classList.remove('opacity-100', 'z-10');
                    slide.classList.add('opacity-0', 'z-0');
                }
            });
        }

        if (slides.length > 1) {
            nextBtn.addEventListener('click', function () {
                currentSlide = (currentSlide + 1) % slides.length;
                showSlide(currentSlide);
            });

            prevBtn.addEventListener('click', function () {
                currentSlide = (currentSlide - 1 + slides.length) % slides.length;
                showSlide(currentSlide);
            });

            setInterval(() => {
                currentSlide = (currentSlide + 1) % slides.length;
                showSlide(currentSlide);
            }, 6000);
        }

        // Live Filter Tabel "Daftar Semua Ajuan Permohonan"
        const searchInput = document.getElementById('tableSearchInput');
        const tableRows = document.querySelectorAll('#publicApplicationsTable tbody .search-row');

        if (searchInput) {
            searchInput.addEventListener('input', function () {
                const term = this.value.toLowerCase();
                tableRows.forEach(row => {
                    const text = row.innerText.toLowerCase();
                    row.style.display = text.includes(term) ? '' : 'none';
                });
            });
        }
    });
</script>
@endpush
@endsection
