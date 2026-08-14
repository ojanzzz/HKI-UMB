@extends('layouts.dashboard')

@section('title', 'Dokumen Permohonan KI - UM BIMA')

@section('content')
<div class="max-w-7xl mx-auto space-y-6 py-4">

    {{-- =========================================================
         HEADER BANNER: Judul, Meta Info, Tombol Kembali
    ========================================================== --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="bg-gradient-to-r from-[#064E3B] to-[#047857] px-8 py-5">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                <div>
                    <span class="inline-block bg-white/20 text-white text-[10px] font-extrabold px-2.5 py-1 rounded-full uppercase tracking-wider mb-2">
                        PERMOHONAN KI #{{ $application->id }}
                    </span>
                    <h2 class="text-xl font-extrabold text-white tracking-tight leading-tight">
                        {{ $application->title }}
                    </h2>
                    <div class="flex flex-wrap items-center gap-2 mt-2">
                        <span class="bg-white/20 text-white text-[10px] font-bold px-2 py-0.5 rounded-full uppercase">
                            {{ $application->application_type }}
                        </span>
                        @if($application->application_category)
                        <span class="bg-amber-400/90 text-slate-900 text-[10px] font-bold px-2 py-0.5 rounded-full uppercase">
                            {{ $application->application_category }}
                        </span>
                        @endif
                        <span class="text-white/70 text-[10px]">Dibuat: {{ $application->created_at->format('d M Y H:i') }}</span>
                    </div>
                </div>
                <a href="{{ route('user.dashboard') }}" class="shrink-0 bg-white/20 hover:bg-white/30 text-white text-xs font-bold px-4 py-2 rounded-xl transition uppercase tracking-wider border border-white/30">
                    &larr; Dashboard
                </a>
            </div>
        </div>

        {{-- Status Bar --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 divide-y sm:divide-y-0 sm:divide-x divide-slate-200 text-xs">
            <div class="px-6 py-4 space-y-1">
                <span class="block text-[10px] font-extrabold uppercase text-slate-500 tracking-wider">Status Permohonan</span>
                <div class="font-extrabold text-base">
                    @if($application->status === 'draft')
                        <span class="text-amber-600">📋 Pengisian Dokumen</span>
                    @elseif($application->status === 'submitted')
                        <span class="text-blue-600">⏳ Terkirim ke Admin</span>
                    @elseif($application->status === 'billing_issued')
                        <span class="text-orange-600">💳 Menunggu Pembayaran</span>
                    @elseif($application->status === 'paid' || $application->status === 'submitted_to_djki')
                        <span class="text-emerald-700">✓ Terdaftar & Lunas DJKI</span>
                    @else
                        <span class="text-slate-700 uppercase text-sm">{{ $application->status }}</span>
                    @endif
                </div>
            </div>
            <div class="px-6 py-4 space-y-1">
                <span class="block text-[10px] font-extrabold uppercase text-slate-500 tracking-wider">No. Permohonan DJKI</span>
                <div class="font-mono font-extrabold text-sm text-slate-900">
                    {{ $application->djki_application_number ?? '—' }}
                </div>
            </div>
            <div class="px-6 py-4 space-y-1">
                <span class="block text-[10px] font-extrabold uppercase text-slate-500 tracking-wider">Kode Billing SIMPAKI</span>
                <div class="font-mono font-extrabold text-sm text-slate-900">
                    @if($application->simpaki_billing_code)
                        {{ $application->simpaki_billing_code }}
                        <span class="text-slate-500 font-normal text-[11px]">(Rp {{ number_format($application->billing_amount, 0, ',', '.') }})</span>
                    @else
                        <span class="text-slate-400 font-normal">Belum Diterbitkan</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- =========================================================
         2-COLUMN: Foto Produk (kiri, 1/3) + Info Detail (kanan, 2/3)
    ========================================================== --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">

        {{-- FOTO PRODUK INVENSI --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="bg-slate-50 border-b border-slate-200 px-4 py-3">
                <h3 class="text-[11px] font-extrabold text-slate-700 uppercase tracking-wider flex items-center gap-1.5">
                    <span>📷</span> Foto Produk / Visual Invensi
                </h3>
            </div>
            <div class="p-4 space-y-3">
                @if($application->product_image_path)
                    <div class="rounded-xl overflow-hidden border border-slate-200 bg-slate-100">
                        <img src="{{ asset('storage/' . $application->product_image_path) }}"
                             alt="Foto Produk Invensi"
                             class="w-full h-48 object-cover object-center">
                    </div>
                @else
                    <div class="w-full h-48 bg-slate-100 rounded-xl border border-dashed border-slate-300 flex flex-col items-center justify-center text-slate-400 text-center p-4">
                        <span class="text-4xl mb-2">📷</span>
                        <span class="text-[11px] font-bold">Belum ada foto produk</span>
                        <span class="text-[10px] mt-0.5">Unggah gambar visual invensi Anda</span>
                    </div>
                @endif

                <form action="{{ route('applications.update-product-image', $application->id) }}" method="POST" enctype="multipart/form-data" class="space-y-2">
                    @csrf
                    <label class="block text-[10px] font-extrabold text-slate-600 uppercase tracking-wide">
                        {{ $application->product_image_path ? 'Ganti Foto' : 'Unggah Foto' }}
                    </label>
                    <input type="file" name="product_image" required accept="image/jpeg,image/png,image/jpg"
                           class="w-full text-[10px] text-slate-600 border border-slate-300 rounded-lg bg-white p-1.5 file:mr-2 file:py-1 file:px-2 file:rounded-md file:border-0 file:text-[10px] file:font-bold file:bg-[#064E3B] file:text-white hover:file:bg-[#047857] cursor-pointer">
                    <button type="submit" class="w-full bg-[#064E3B] hover:bg-[#047857] text-white font-extrabold py-2 px-3 rounded-lg text-[10px] uppercase tracking-wider transition flex items-center justify-center gap-1.5">
                        <span>{{ $application->product_image_path ? '🔄' : '📤' }}</span>
                        <span>{{ $application->product_image_path ? 'Ganti Foto Produk' : 'Unggah Foto Produk' }}</span>
                    </button>
                </form>
            </div>
        </div>

        {{-- INFO DETAIL: Kemajuan, Deskripsi --}}
        <div class="lg:col-span-2 space-y-4">
            {{-- Progress Dokumen --}}
            @php $uploadedCount = $application->documents->count(); @endphp
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-xs font-extrabold text-slate-800 uppercase tracking-wider">Kelengkapan Dokumen</h3>
                    <span class="text-xs font-bold {{ $uploadedCount >= 8 ? 'text-emerald-700' : 'text-amber-600' }}">
                        {{ $uploadedCount }} / 8 Terunggah
                    </span>
                </div>
                <div class="w-full bg-slate-200 rounded-full h-2.5 overflow-hidden">
                    <div class="h-full rounded-full transition-all duration-500 {{ $uploadedCount >= 8 ? 'bg-emerald-500' : 'bg-amber-500' }}"
                         style="width: {{ min(100, ($uploadedCount / 8) * 100) }}%"></div>
                </div>
                @if($uploadedCount < 8)
                <p class="text-[10px] text-slate-500 mt-2">Lengkapi {{ 8 - $uploadedCount }} dokumen lagi untuk mengajukan ke Admin.</p>
                @else
                <p class="text-[10px] text-emerald-700 font-bold mt-2">✓ Semua dokumen telah diunggah! Permohonan siap diajukan.</p>
                @endif
            </div>

            {{-- Deskripsi Invensi --}}
            @if($application->description)
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5">
                <h3 class="text-xs font-extrabold text-slate-800 uppercase tracking-wider mb-2 flex items-center gap-2">
                    <span>📝</span> Deskripsi Invensi
                </h3>
                <p class="text-xs text-slate-600 leading-relaxed">{{ $application->description }}</p>
            </div>
            @endif

            {{-- Petunjuk Pengisian --}}
            <div class="bg-[#064E3B] text-white rounded-2xl p-5 space-y-3">
                <div class="text-amber-400 font-extrabold text-[11px] uppercase tracking-wider flex items-center gap-1.5">
                    <span>💡</span> PETUNJUK PENGISIAN DOKUMEN
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 text-[11px]">
                    <div class="bg-white/10 rounded-xl p-3 border border-white/10">
                        <strong class="text-white block mb-1">1. Unduh Template</strong>
                        <span class="text-emerald-200">Klik <span class="text-amber-300 font-bold">📥 Unduh Template</span> pada setiap kartu dokumen di bawah.</span>
                    </div>
                    <div class="bg-white/10 rounded-xl p-3 border border-white/10">
                        <strong class="text-white block mb-1">2. Isi Offline</strong>
                        <span class="text-emerald-200">Buka & isi formulir Word (.docx) di komputer Anda.</span>
                    </div>
                    <div class="bg-white/10 rounded-xl p-3 border border-white/10">
                        <strong class="text-white block mb-1">3. Upload Dokumen</strong>
                        <span class="text-emerald-200">Pilih file lalu klik <span class="text-amber-300 font-bold">📤 Unggah</span>. Mendukung .pdf, .docx, .png, .zip.</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- =========================================================
         8 FORMULIR DOKUMEN PATEN / KI
    ========================================================== --}}
    <div class="space-y-4">
        <div class="flex items-center justify-between px-1">
            <h3 class="text-base font-extrabold text-slate-900 uppercase tracking-tight flex items-center gap-2">
                <span>📁</span> 8 Formulir Dokumen Permohonan
            </h3>
            <span class="text-xs font-bold {{ $application->documents->count() >= 8 ? 'text-emerald-700 bg-emerald-100 border-emerald-300' : 'text-amber-700 bg-amber-100 border-amber-300' }} border px-3 py-1 rounded-full">
                Terunggah: {{ $application->documents->count() }} / 8
            </span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            @foreach($templatesMap as $docKey => $info)
                @php $existingDoc = $documentsMap->get($docKey); @endphp
                <div class="bg-white rounded-2xl border {{ $existingDoc ? 'border-emerald-300' : 'border-slate-200' }} shadow-sm overflow-hidden hover:shadow-md transition-shadow">
                    {{-- Card Header --}}
                    <div class="flex items-center justify-between px-5 py-3 {{ $existingDoc ? 'bg-emerald-50 border-b border-emerald-200' : 'bg-slate-50 border-b border-slate-200' }}">
                        <h4 class="font-extrabold text-slate-900 text-sm flex items-center gap-1.5">
                            <span>📄</span>
                            <span>{{ $info['label'] }}</span>
                        </h4>
                        @if($existingDoc)
                            <span class="bg-emerald-600 text-white px-2.5 py-0.5 rounded-full font-extrabold text-[10px] uppercase flex items-center gap-1">
                                <span>✓</span><span>Terunggah</span>
                            </span>
                        @else
                            <span class="bg-amber-100 text-amber-800 border border-amber-300 px-2.5 py-0.5 rounded-full font-bold text-[10px] uppercase">
                                Belum Diunggah
                            </span>
                        @endif
                    </div>

                    <div class="p-5 space-y-4">
                        {{-- Unduh Template Word Resmi Admin --}}
                        <div class="flex items-center justify-between bg-blue-50 border border-blue-200 rounded-xl px-4 py-2.5">
                            <div class="text-xs">
                                <span class="font-extrabold text-slate-800 block">📋 Template Word Resmi Admin</span>
                                <span class="text-slate-500 text-[10px]">Unduh, isi, lalu unggah kembali</span>
                            </div>
                            <a href="{{ route('templates.download', $docKey) }}"
                               class="shrink-0 bg-amber-500 hover:bg-amber-600 text-slate-950 font-extrabold px-3.5 py-1.5 rounded-lg text-[10px] uppercase tracking-wider transition shadow-xs flex items-center gap-1">
                                <span>📥</span><span>Unduh</span>
                            </a>
                        </div>

                        {{-- Existing Uploaded File Info --}}
                        @if($existingDoc)
                            <div class="bg-emerald-50 border border-emerald-200 rounded-xl px-4 py-2.5 flex items-center justify-between gap-3">
                                <div class="min-w-0">
                                    <span class="font-bold text-emerald-900 text-xs truncate block" title="{{ $existingDoc->form_data['original_name'] ?? basename($existingDoc->file_path) }}">
                                        📄 {{ $existingDoc->form_data['original_name'] ?? basename($existingDoc->file_path) }}
                                    </span>
                                    <span class="text-[10px] text-emerald-600">{{ $existingDoc->updated_at->format('d M Y H:i') }}</span>
                                </div>
                                <a href="{{ asset('storage/' . $existingDoc->file_path) }}" target="_blank"
                                   class="shrink-0 text-emerald-700 hover:text-emerald-900 font-extrabold text-xs underline whitespace-nowrap">
                                    Lihat &rarr;
                                </a>
                            </div>
                        @endif

                        {{-- Upload Form --}}
                        <form action="{{ route('applications.upload-document', $application->id) }}" method="POST" enctype="multipart/form-data" class="space-y-2">
                            @csrf
                            <input type="hidden" name="document_type" value="{{ $docKey }}">
                            <label class="block text-[10px] font-extrabold text-slate-600 uppercase tracking-wide">
                                {{ $existingDoc ? '🔄 Ganti / Unggah Ulang Dokumen' : '📤 Unggah File Dokumen' }}
                            </label>
                            <input type="file" name="file" required
                                   accept=".pdf,.doc,.docx,.png,.jpg,.jpeg,.zip,.rar"
                                   class="w-full text-[11px] text-slate-600 border border-slate-300 rounded-lg bg-white p-2 file:mr-3 file:py-1 file:px-3 file:rounded-md file:border-0 file:text-[10px] file:font-bold file:bg-[#064E3B] file:text-white hover:file:bg-[#047857] cursor-pointer">
                            <p class="text-[9px] text-slate-400">Format: .pdf .docx .doc .png .jpg .zip (Maks. 15MB)</p>
                            <button type="submit"
                                    class="w-full {{ $existingDoc ? 'bg-blue-600 hover:bg-blue-700' : 'bg-[#064E3B] hover:bg-[#047857]' }} text-white font-extrabold py-2 px-4 rounded-lg text-xs uppercase tracking-wider transition flex items-center justify-center gap-1.5">
                                <span>{{ $existingDoc ? '🔄' : '📤' }}</span>
                                <span>{{ $existingDoc ? 'Unggah Perubahan Dokumen' : 'Unggah Dokumen Saya' }}</span>
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- =========================================================
         PEMBAYARAN SIMPAKI (Hanya tampil jika ada tagihan)
    ========================================================== --}}
    @if($application->simpaki_billing_code && $application->billing_amount)
        <div class="bg-white rounded-2xl border border-purple-200 shadow-sm overflow-hidden">
            <div class="bg-purple-700 px-6 py-4">
                <h3 class="text-sm font-extrabold text-white uppercase tracking-wider flex items-center gap-2">
                    <span>💳</span> Pembayaran PNBP SIMPAKI DJKI
                </h3>
            </div>
            <div class="p-6 space-y-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                    <div class="bg-purple-50 border border-purple-200 rounded-xl p-4 space-y-1">
                        <span class="text-[10px] font-bold text-purple-700 uppercase tracking-wider">Kode Billing SIMPAKI</span>
                        <div class="font-mono font-extrabold text-base text-purple-900">{{ $application->simpaki_billing_code }}</div>
                    </div>
                    <div class="bg-purple-50 border border-purple-200 rounded-xl p-4 space-y-1">
                        <span class="text-[10px] font-bold text-purple-700 uppercase tracking-wider">Nominal Tagihan</span>
                        <div class="font-extrabold text-base text-purple-900">Rp {{ number_format($application->billing_amount, 0, ',', '.') }}</div>
                    </div>
                </div>
                <form action="{{ route('applications.submit-payment', $application->id) }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                    @csrf
                    <label class="block text-xs font-extrabold text-slate-800 uppercase tracking-wide">Unggah Bukti Transfer Pembayaran</label>
                    <input type="file" name="proof_of_payment" required accept=".pdf,.png,.jpg,.jpeg"
                           class="w-full text-xs text-slate-600 border border-slate-300 rounded-lg p-2 bg-white cursor-pointer">
                    <button type="submit" class="bg-purple-700 hover:bg-purple-800 text-white font-extrabold py-2.5 px-6 rounded-xl uppercase tracking-wider text-xs transition flex items-center gap-2">
                        <span>📤</span>
                        <span>Kirim Bukti Pembayaran SIMPAKI</span>
                    </button>
                </form>
            </div>
        </div>
    @endif

</div>
@endsection
