@extends('layouts.app')

@section('title', 'Panduan Pengajuan HKI - Sentra HKI UM BIMA')
@section('meta_description', 'Panduan lengkap alur pengajuan Hak Kekayaan Intelektual (HKI) di Universitas Muhammadiyah Bima. Mudah dipahami, langkah demi langkah.')

@section('content')

{{-- ============================================================
     HERO SECTION
============================================================ --}}
<div class="bg-gradient-to-br from-[#064E3B] via-[#065F46] to-[#047857] text-white py-16 px-4">
    <div class="max-w-4xl mx-auto text-center space-y-4">
        <span class="inline-block bg-amber-400 text-slate-900 text-[11px] font-extrabold px-4 py-1.5 rounded-full uppercase tracking-widest shadow-sm">
            PANDUAN PENGGUNAAN
        </span>
        <h1 class="text-3xl md:text-4xl font-extrabold uppercase tracking-tight leading-tight">
            Cara Mengajukan HKI<br class="hidden sm:block">
            <span class="text-amber-300">di Sentra HKI UM BIMA</span>
        </h1>
        <p class="text-emerald-100 text-sm max-w-2xl mx-auto leading-relaxed">
            Proses pengajuan Hak Kekayaan Intelektual (Paten, Hak Cipta, Merek, Desain Industri, dll) 
            di Universitas Muhammadiyah Bima melalui portal ini mudah, cepat, dan terintegrasi dengan DJKI Kemenkumham RI.
        </p>
    </div>
</div>

{{-- ============================================================
     ALUR UTAMA: 6 Langkah Visual Workflow
============================================================ --}}
<div class="max-w-6xl mx-auto px-4 sm:px-6 py-14 space-y-14">

    {{-- Section Title --}}
    <div class="text-center space-y-2">
        <h2 class="text-2xl font-extrabold text-slate-900 uppercase tracking-tight">
            Alur Pengajuan HKI — 6 Langkah Mudah
        </h2>
        <p class="text-sm text-slate-500 max-w-xl mx-auto">
            Ikuti langkah-langkah berikut untuk berhasil mendaftarkan Kekayaan Intelektual Anda melalui Sentra HKI UM BIMA.
        </p>
    </div>

    {{-- STEP CARDS --}}
    <div class="space-y-6">

        {{-- ---- STEP 1 ---- --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
            <div class="lg:col-span-1 flex justify-center lg:justify-start pt-1">
                <div class="w-14 h-14 bg-[#064E3B] text-white rounded-2xl flex items-center justify-center text-2xl font-black shadow-md shrink-0">
                    1
                </div>
            </div>
            <div class="lg:col-span-11 bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="bg-emerald-50 border-b border-emerald-200 px-6 py-4 flex items-center gap-3">
                    <span class="text-2xl">👤</span>
                    <div>
                        <h3 class="font-extrabold text-slate-900 text-base uppercase tracking-wide">Daftar & Login ke Portal</h3>
                        <p class="text-[11px] text-emerald-800 font-medium">Buat akun atau masuk menggunakan akun Google UM BIMA Anda</p>
                    </div>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                    <div class="bg-slate-50 rounded-xl p-4 border border-slate-200 space-y-2">
                        <span class="block text-xs font-extrabold text-[#064E3B] uppercase">Kunjungi Portal</span>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Buka <strong class="text-slate-900">hki.umb.ac.id</strong> di browser Anda. Klik tombol <strong>"Daftar Sekarang"</strong> atau <strong>"Masuk dengan Google"</strong>.
                        </p>
                    </div>
                    <div class="bg-slate-50 rounded-xl p-4 border border-slate-200 space-y-2">
                        <span class="block text-xs font-extrabold text-[#064E3B] uppercase">Lengkapi Profil</span>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Isi <strong>NIK (wajib)</strong>, nomor WA aktif, dan unggah foto <strong>KTP (wajib)</strong>. NIP/NIM dan Fakultas bersifat opsional.
                        </p>
                    </div>
                    <div class="bg-slate-50 rounded-xl p-4 border border-slate-200 space-y-2">
                        <span class="block text-xs font-extrabold text-[#064E3B] uppercase">Tunggu Verifikasi</span>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Admin Sentra HKI akan memverifikasi akun Anda. Notifikasi <strong>Email & WhatsApp</strong> otomatis dikirim saat akun disetujui.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Arrow --}}
        <div class="flex justify-center text-slate-300 text-3xl select-none">&#8595;</div>

        {{-- ---- STEP 2 ---- --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
            <div class="lg:col-span-1 flex justify-center lg:justify-start pt-1">
                <div class="w-14 h-14 bg-blue-600 text-white rounded-2xl flex items-center justify-center text-2xl font-black shadow-md shrink-0">
                    2
                </div>
            </div>
            <div class="lg:col-span-11 bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="bg-blue-50 border-b border-blue-200 px-6 py-4 flex items-center gap-3">
                    <span class="text-2xl">📋</span>
                    <div>
                        <h3 class="font-extrabold text-slate-900 text-base uppercase tracking-wide">Buat Pengajuan HKI Baru</h3>
                        <p class="text-[11px] text-blue-700 font-medium">Isi formulir 5 langkah yang sederhana dan interaktif</p>
                    </div>
                </div>
                <div class="p-6 space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-5 gap-2">
                        @foreach([
                            ['num' => '1', 'label' => 'Jenis KI', 'icon' => '🏷️', 'desc' => 'Pilih jenis HKI (Paten, Hak Cipta, Merek, dll) & Kategori Pengajuan'],
                            ['num' => '2', 'label' => 'Pemohon', 'icon' => '👤', 'desc' => 'Konfirmasi data NIK, email, WA, dan Fakultas Anda'],
                            ['num' => '3', 'label' => 'Detail', 'icon' => '📝', 'desc' => 'Isi judul invensi, deskripsi, dan upload foto produk'],
                            ['num' => '4', 'label' => 'Dokumen', 'icon' => '📁', 'desc' => 'Lihat daftar 8 template formulir resmi yang perlu diisi'],
                            ['num' => '5', 'label' => 'Kirim', 'icon' => '🚀', 'desc' => 'Simpan ke Draft — pengajuan berhasil dibuat!'],
                        ] as $s)
                            <div class="bg-blue-50 border border-blue-200 rounded-xl p-3 text-center space-y-1">
                                <div class="text-xl">{{ $s['icon'] }}</div>
                                <div class="font-extrabold text-[11px] text-blue-900 uppercase">{{ $s['num'] }}. {{ $s['label'] }}</div>
                                <div class="text-[10px] text-blue-700 leading-relaxed">{{ $s['desc'] }}</div>
                            </div>
                        @endforeach
                    </div>
                    <p class="text-xs text-slate-500 text-center">Klik <strong class="text-slate-800">"Ajukan Paten Baru"</strong> di dashboard, ikuti wizard 5 langkah, lalu klik <strong>"Simpan ke Draft"</strong>.</p>
                </div>
            </div>
        </div>

        {{-- Arrow --}}
        <div class="flex justify-center text-slate-300 text-3xl select-none">&#8595;</div>

        {{-- ---- STEP 3 ---- --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
            <div class="lg:col-span-1 flex justify-center lg:justify-start pt-1">
                <div class="w-14 h-14 bg-amber-500 text-white rounded-2xl flex items-center justify-center text-2xl font-black shadow-md shrink-0">
                    3
                </div>
            </div>
            <div class="lg:col-span-11 bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="bg-amber-50 border-b border-amber-200 px-6 py-4 flex items-center gap-3">
                    <span class="text-2xl">📥</span>
                    <div>
                        <h3 class="font-extrabold text-slate-900 text-base uppercase tracking-wide">Unduh & Isi 8 Formulir Dokumen</h3>
                        <p class="text-[11px] text-amber-800 font-medium">Template Word resmi disediakan langsung oleh Admin Sentra HKI</p>
                    </div>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-3">
                        <p class="text-xs text-slate-700 leading-relaxed">
                            Setelah draft tersimpan, buka halaman <strong>"Kelola Dokumen"</strong>. Setiap slot dokumen memiliki tombol <strong class="text-amber-600">📥 Unduh Template</strong> yang dapat langsung diunduh.
                        </p>
                        <div class="grid grid-cols-2 gap-2">
                            @foreach(['0. Data Dukung', '1. Daftar Inventor', '2. Deskripsi Paten', '3. Abstrak Invensi', '4. Klaim Invensi', '5. Gambar Invensi', '6. Pengalihan Hak', '7. Kepemilikan'] as $doc)
                                <div class="bg-amber-50 border border-amber-200 rounded-lg px-3 py-2 text-[11px] font-bold text-amber-900 flex items-center gap-1.5">
                                    <span>📄</span> {{ $doc }}
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="bg-slate-50 rounded-xl border border-slate-200 p-4 space-y-3 text-xs text-slate-700">
                        <p class="font-extrabold text-slate-900 uppercase text-[11px]">💡 Cara Mengisi Formulir:</p>
                        <ol class="space-y-2 list-decimal list-inside leading-relaxed">
                            <li>Klik tombol <span class="font-bold text-amber-700">📥 Unduh Template</span> pada setiap dokumen</li>
                            <li>Buka file Word (.docx) di Microsoft Word / Google Docs</li>
                            <li>Isi semua kolom sesuai data invensi/karya Anda</li>
                            <li>Simpan file di komputer Anda</li>
                        </ol>
                        <div class="bg-emerald-50 border border-emerald-200 rounded-lg p-3 text-[11px] text-emerald-800">
                            ✅ Anda <strong>tidak perlu mengisi semua</strong> sekaligus. Dapat diunggah satu per satu kapan saja.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Arrow --}}
        <div class="flex justify-center text-slate-300 text-3xl select-none">&#8595;</div>

        {{-- ---- STEP 4 ---- --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
            <div class="lg:col-span-1 flex justify-center lg:justify-start pt-1">
                <div class="w-14 h-14 bg-purple-600 text-white rounded-2xl flex items-center justify-center text-2xl font-black shadow-md shrink-0">
                    4
                </div>
            </div>
            <div class="lg:col-span-11 bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="bg-purple-50 border-b border-purple-200 px-6 py-4 flex items-center gap-3">
                    <span class="text-2xl">📤</span>
                    <div>
                        <h3 class="font-extrabold text-slate-900 text-base uppercase tracking-wide">Unggah Dokumen yang Sudah Diisi</h3>
                        <p class="text-[11px] text-purple-700 font-medium">Multi-format: PDF, Word, Gambar, ZIP — semua didukung</p>
                    </div>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-4 text-xs">
                    <div class="bg-purple-50 rounded-xl border border-purple-200 p-4 space-y-2">
                        <span class="block font-extrabold text-purple-900 uppercase text-[11px]">Format yang Didukung</span>
                        <div class="flex flex-wrap gap-1.5">
                            @foreach(['.pdf', '.docx', '.doc', '.png', '.jpg', '.jpeg', '.zip'] as $fmt)
                                <span class="bg-white border border-purple-300 text-purple-800 font-mono font-bold text-[10px] px-2 py-0.5 rounded">{{ $fmt }}</span>
                            @endforeach
                        </div>
                        <p class="text-purple-700 text-[10px]">Ukuran maksimum 15MB per file.</p>
                    </div>
                    <div class="bg-slate-50 rounded-xl border border-slate-200 p-4 space-y-2">
                        <span class="block font-extrabold text-slate-900 uppercase text-[11px]">Cara Mengunggah</span>
                        <ol class="space-y-1.5 list-decimal list-inside text-slate-600 leading-relaxed text-[11px]">
                            <li>Buka halaman detail draft pengajuan</li>
                            <li>Pilih file di bawah setiap kartu dokumen</li>
                            <li>Klik <span class="font-bold text-[#064E3B]">📤 Unggah Dokumen Saya</span></li>
                            <li>Status berubah jadi <span class="text-emerald-700 font-bold">✓ Terunggah</span></li>
                        </ol>
                    </div>
                    <div class="bg-emerald-50 rounded-xl border border-emerald-200 p-4 space-y-2">
                        <span class="block font-extrabold text-emerald-900 uppercase text-[11px]">Setelah Semua Lengkap</span>
                        <p class="text-[11px] text-emerald-800 leading-relaxed">
                            Saat <strong>8 / 8 dokumen</strong> terunggah, status permohonan otomatis berubah menjadi <strong>"Terkirim ke Admin"</strong> dan Admin segera mendapatkan notifikasi.
                        </p>
                        <div class="bg-white border border-emerald-300 rounded-lg p-2 text-center">
                            <span class="text-emerald-700 font-extrabold text-xs">✓ 8 / 8 Terunggah</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Arrow --}}
        <div class="flex justify-center text-slate-300 text-3xl select-none">&#8595;</div>

        {{-- ---- STEP 5 ---- --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
            <div class="lg:col-span-1 flex justify-center lg:justify-start pt-1">
                <div class="w-14 h-14 bg-orange-500 text-white rounded-2xl flex items-center justify-center text-2xl font-black shadow-md shrink-0">
                    5
                </div>
            </div>
            <div class="lg:col-span-11 bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="bg-orange-50 border-b border-orange-200 px-6 py-4 flex items-center gap-3">
                    <span class="text-2xl">🔍</span>
                    <div>
                        <h3 class="font-extrabold text-slate-900 text-base uppercase tracking-wide">Admin Mereview & Mendaftarkan ke DJKI</h3>
                        <p class="text-[11px] text-orange-700 font-medium">Proses ini ditangani oleh Admin Sentra HKI UM BIMA — Anda cukup menunggu</p>
                    </div>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6 text-xs">
                    <div class="space-y-3">
                        <p class="text-slate-700 leading-relaxed">
                            Admin akan memeriksa kelengkapan dan kesesuaian 8 dokumen Anda, lalu mengeksport paket ZIP untuk didaftarkan ke 
                            <strong class="text-slate-900">Portal DJKI Kemenkumham RI</strong>.
                        </p>
                        <div class="space-y-2">
                            @foreach([
                                ['icon' => '📦', 'text' => 'Export paket ZIP 8 dokumen'],
                                ['icon' => '🏛️', 'text' => 'Input Nomor Permohonan DJKI resmi'],
                                ['icon' => '💳', 'text' => 'Penerbitan Kode Billing SIMPAKI PNBP'],
                            ] as $item)
                                <div class="flex items-center gap-3 bg-orange-50 border border-orange-200 rounded-xl px-4 py-2.5">
                                    <span class="text-lg">{{ $item['icon'] }}</span>
                                    <span class="font-bold text-slate-800 text-[11px]">{{ $item['text'] }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="bg-slate-50 rounded-xl border border-slate-200 p-4 space-y-3">
                        <span class="block font-extrabold text-slate-900 uppercase text-[11px]">🔔 Notifikasi Otomatis Dikirim Via:</span>
                        <div class="grid grid-cols-3 gap-2 text-center text-[10px]">
                            <div class="bg-white border border-slate-200 rounded-xl p-3 space-y-1">
                                <div class="text-2xl">🔔</div>
                                <div class="font-bold text-slate-700">In-App</div>
                                <div class="text-slate-500">Notifikasi di dashboard</div>
                            </div>
                            <div class="bg-white border border-slate-200 rounded-xl p-3 space-y-1">
                                <div class="text-2xl">📧</div>
                                <div class="font-bold text-slate-700">Email</div>
                                <div class="text-slate-500">Ke email terdaftar</div>
                            </div>
                            <div class="bg-white border border-slate-200 rounded-xl p-3 space-y-1">
                                <div class="text-2xl">💬</div>
                                <div class="font-bold text-slate-700">WhatsApp</div>
                                <div class="text-slate-500">Ke nomor WA Anda</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Arrow --}}
        <div class="flex justify-center text-slate-300 text-3xl select-none">&#8595;</div>

        {{-- ---- STEP 6 ---- --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
            <div class="lg:col-span-1 flex justify-center lg:justify-start pt-1">
                <div class="w-14 h-14 bg-emerald-600 text-white rounded-2xl flex items-center justify-center text-2xl font-black shadow-md shrink-0">
                    6
                </div>
            </div>
            <div class="lg:col-span-11 bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="bg-emerald-50 border-b border-emerald-200 px-6 py-4 flex items-center gap-3">
                    <span class="text-2xl">💳</span>
                    <div>
                        <h3 class="font-extrabold text-slate-900 text-base uppercase tracking-wide">Pembayaran PNBP & Terima Kuitansi Resmi</h3>
                        <p class="text-[11px] text-emerald-700 font-medium">Bayar biaya SIMPAKI DJKI & unduh Kuitansi PDF Resmi Anda</p>
                    </div>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-4 text-xs">
                    <div class="bg-emerald-50 rounded-xl border border-emerald-200 p-4 space-y-2">
                        <span class="block font-extrabold text-emerald-900 uppercase text-[11px]">1. Terima Kode Billing</span>
                        <p class="text-emerald-800 leading-relaxed text-[11px]">
                            Admin menerbitkan Kode Billing SIMPAKI & nominal PNBP. Notifikasi dikirim via Email & WhatsApp.
                        </p>
                    </div>
                    <div class="bg-blue-50 rounded-xl border border-blue-200 p-4 space-y-2">
                        <span class="block font-extrabold text-blue-900 uppercase text-[11px]">2. Lakukan Pembayaran</span>
                        <p class="text-blue-800 leading-relaxed text-[11px]">
                            Transfer sesuai nominal ke rekening SIMPAKI DJKI, lalu unggah bukti transfer di portal HKI UM BIMA.
                        </p>
                    </div>
                    <div class="bg-slate-50 rounded-xl border border-slate-200 p-4 space-y-2">
                        <span class="block font-extrabold text-slate-900 uppercase text-[11px]">3. Kuitansi PDF Resmi</span>
                        <p class="text-slate-700 leading-relaxed text-[11px]">
                            Setelah Admin memverifikasi pembayaran, <strong>Kuitansi PDF Resmi</strong> otomatis diterbitkan dan dapat diunduh kapan saja.
                        </p>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- ============================================================
         STATUS TRACKER
    ============================================================ --}}
    <div class="space-y-5">
        <div class="text-center space-y-1">
            <h2 class="text-xl font-extrabold text-slate-900 uppercase tracking-tight">Status Permohonan</h2>
            <p class="text-sm text-slate-500">Lacak perkembangan pengajuan HKI Anda setiap saat di dashboard</p>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-3">
            @foreach([
                ['color' => 'amber', 'icon' => '📋', 'status' => 'Draft', 'desc' => 'Pengisian dokumen aktif'],
                ['color' => 'blue', 'icon' => '⏳', 'status' => 'Terkirim', 'desc' => 'Dokumen lengkap, menunggu admin'],
                ['color' => 'indigo', 'icon' => '🔍', 'status' => 'Under Review', 'desc' => 'Admin sedang memeriksa'],
                ['color' => 'orange', 'icon' => '💳', 'status' => 'Billing Issued', 'desc' => 'Kode billing diterbitkan'],
                ['color' => 'purple', 'icon' => '💰', 'status' => 'Menunggu Bayar', 'desc' => 'Bukti transfer diunggah'],
                ['color' => 'emerald', 'icon' => '✅', 'status' => 'Lunas & Terdaftar', 'desc' => 'Selesai! HKI terdaftar DJKI'],
            ] as $st)
                <div class="bg-{{ $st['color'] }}-50 border border-{{ $st['color'] }}-200 rounded-2xl p-4 text-center space-y-1.5">
                    <div class="text-2xl">{{ $st['icon'] }}</div>
                    <div class="font-extrabold text-[11px] text-{{ $st['color'] }}-900 uppercase leading-tight">{{ $st['status'] }}</div>
                    <div class="text-[10px] text-{{ $st['color'] }}-700 leading-relaxed">{{ $st['desc'] }}</div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- ============================================================
         INFO BOX DJKI
    ============================================================ --}}
    <div class="bg-gradient-to-r from-slate-900 to-slate-800 text-white rounded-2xl p-8 shadow-xl">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            <div class="space-y-3 max-w-2xl">
                <span class="inline-block bg-amber-400 text-slate-900 font-extrabold text-[11px] px-3 py-1 rounded-full uppercase tracking-wider">
                    DJKI KEMENKUMHAM RI
                </span>
                <h3 class="text-xl font-extrabold uppercase tracking-wide leading-tight">
                    Terintegrasi SIMPAKI DJKI
                </h3>
                <p class="text-sm text-slate-300 leading-relaxed">
                    Portal Sentra HKI UM BIMA terhubung langsung dengan sistem <strong class="text-white">SIMPAKI (Sistem Informasi Paten, Merek, Cipta dan Kekayaan Intelektual)</strong> milik Direktorat Jenderal Kekayaan Intelektual (DJKI) Kementerian Hukum RI, sehingga setiap pengajuan memiliki nomor permohonan resmi yang sah secara hukum.
                </p>
            </div>
            <div class="flex flex-col gap-3 shrink-0">
                <a href="https://simpaki.dgip.go.id" target="_blank"
                   class="bg-amber-400 hover:bg-amber-500 text-slate-900 px-6 py-3 rounded-xl font-extrabold text-xs uppercase tracking-wider transition flex items-center gap-2 justify-center shadow-md">
                    <span>🏛️</span> Portal SIMPAKI DJKI
                </a>
                <a href="{{ route('login') }}"
                   class="bg-white/15 hover:bg-white/25 text-white px-6 py-3 rounded-xl font-extrabold text-xs uppercase tracking-wider transition flex items-center gap-2 justify-center border border-white/20">
                    <span>🚀</span> Masuk & Ajukan Sekarang
                </a>
            </div>
        </div>
    </div>

    {{-- ============================================================
         FAQ SINGKAT
    ============================================================ --}}
    <div class="space-y-5">
        <h2 class="text-xl font-extrabold text-slate-900 uppercase tracking-tight text-center">Pertanyaan yang Sering Ditanyakan</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach([
                ['q' => 'Siapa yang bisa mengajukan HKI?', 'a' => 'Seluruh sivitas akademika UM BIMA — dosen, peneliti, mahasiswa aktif, dan tenaga kependidikan — serta mitra UMKM binaan UM BIMA.'],
                ['q' => 'Berapa lama proses verifikasi akun?', 'a' => 'Biasanya 1–3 hari kerja. Notifikasi persetujuan dikirim otomatis via Email dan WhatsApp.'],
                ['q' => 'Apa saja jenis HKI yang bisa diajukan?', 'a' => 'Paten, Paten Sederhana, Hak Cipta, Merek, Desain Industri, Indikasi Geografis, DTLST, dan Rahasia Dagang.'],
                ['q' => 'Apakah bisa mengajukan lebih dari satu HKI?', 'a' => 'Ya! Satu akun dapat mengajukan banyak permohonan HKI. Semua draft tersimpan di dashboard Anda.'],
                ['q' => 'Berapa biaya PNBP SIMPAKI DJKI?', 'a' => 'Biaya bervariasi tergantung jenis dan kategori pemohon (UMKM, Perguruan Tinggi, Umum). Admin akan memberitahu besaran tagihan secara resmi.'],
                ['q' => 'Bagaimana jika ada kesalahan dokumen?', 'a' => 'Dokumen dapat diganti kapan saja sebelum diverifikasi Admin. Cukup klik "Unggah Perubahan Dokumen" pada kartu yang bersangkutan.'],
            ] as $faq)
                <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-xs space-y-2 hover:border-emerald-300 transition-colors">
                    <h4 class="font-extrabold text-slate-900 text-sm flex items-start gap-2">
                        <span class="text-[#064E3B] shrink-0 mt-0.5">❓</span>
                        <span>{{ $faq['q'] }}</span>
                    </h4>
                    <p class="text-xs text-slate-600 leading-relaxed pl-6">{{ $faq['a'] }}</p>
                </div>
            @endforeach
        </div>
    </div>

    {{-- CTA Bottom --}}
    <div class="text-center py-6 space-y-4">
        <p class="text-slate-600 text-sm">Masih ada pertanyaan? Hubungi kami langsung.</p>
        <div class="flex flex-wrap justify-center gap-3">
            <a href="{{ route('faq') }}" class="bg-white border border-slate-200 hover:border-slate-300 text-slate-800 font-extrabold px-6 py-3 rounded-xl text-xs uppercase tracking-wider transition shadow-xs">
                Lihat FAQ Lengkap
            </a>
            <a href="{{ route('login') }}" class="bg-[#064E3B] hover:bg-[#047857] text-white font-extrabold px-8 py-3 rounded-xl text-xs uppercase tracking-wider transition shadow-md flex items-center gap-2">
                <span>🚀</span> Masuk & Mulai Ajukan
            </a>
        </div>
    </div>

</div>

@endsection
