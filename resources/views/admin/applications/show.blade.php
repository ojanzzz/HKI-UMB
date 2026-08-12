@extends('layouts.dashboard')

@section('title', 'Review & Export ZIP - Admin HKI UM BIMA')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-8 space-y-8">

    <!-- Top Header Bar with Export ZIP CTA Button -->
    <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6">
        <div class="space-y-2">
            <div class="flex items-center gap-3">
                <span class="bg-[#064E3B] text-white text-[10px] font-extrabold px-2.5 py-0.5 rounded uppercase tracking-wider">
                    REVIEW PERMOHONAN HKI #{{ $application->id }}
                </span>
                <span class="bg-slate-100 text-slate-800 text-[10px] font-bold px-2 py-0.5 rounded border border-slate-200 uppercase">
                    {{ strtoupper($application->application_type) }}
                </span>
            </div>
            <h2 class="text-2xl font-extrabold text-slate-900 uppercase tracking-tight">{{ $application->title }}</h2>
            <p class="text-xs text-slate-600">
                Pemohon: <strong class="text-slate-900">{{ $application->applicants->first()?->applicant_name ?: $application->applicant_name ?: $application->user->name }}</strong> | 
                NIK: <strong class="text-slate-900">{{ $application->applicants->first()?->applicant_nik ?: ($application->user->nik ?? $application->user->identity_number ?? '-') }}</strong> | 
                NIP: <strong class="text-slate-900">{{ $application->applicants->first()?->applicant_nip ?: ($application->user->nip ?? '-') }}</strong> | 
                NIM: <strong class="text-slate-900">{{ $application->applicants->first()?->applicant_nim ?: ($application->user->nim ?? '-') }}</strong> | 
                Fakultas: <strong class="text-slate-900">{{ $application->applicants->first()?->applicant_faculty ?: ($application->user->faculty ?: '-') }}</strong> | 
                WA: <strong class="text-slate-900">{{ $application->user->phone_number ?: '-' }}</strong>
            </p>
        </div>

        @if($application->product_image_path)
            <div class="bg-slate-50 border border-slate-200 rounded-2xl p-4 flex items-center gap-4">
                <img src="{{ asset('storage/' . $application->product_image_path) }}" alt="Foto Produk" class="w-24 h-24 object-cover rounded-xl border border-slate-300 shadow-xs">
                <div>
                    <span class="text-[10px] font-extrabold bg-[#064E3B] text-white px-2 py-0.5 rounded uppercase">FOTO PRODUK INVENSI</span>
                    <h4 class="font-bold text-slate-900 text-xs mt-1">{{ $application->title }}</h4>
                    <a href="{{ asset('storage/' . $application->product_image_path) }}" target="_blank" class="text-xs text-emerald-700 font-extrabold underline hover:text-emerald-900 mt-1 inline-block">
                        Lihat Gambar Resolusi Penuh &rarr;
                    </a>
                </div>
            </div>
        @endif

        <!-- FITUR EXPORT ZIP (INTEGRASI DJKI) BUTTON -->
        <div class="flex flex-col sm:flex-row gap-3 w-full lg:w-auto">
            <a href="{{ route('admin.applications.export-zip', $application->id) }}" class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-md text-xs font-bold uppercase tracking-wider transition shadow-lg flex items-center justify-center space-x-2">
                <span>📦</span>
                <span>EXPORT ZIP 8 DOKUMEN (PORTAL DJKI)</span>
            </a>
        </div>
    </div>

    <!-- Detail Anggota / Pemohon Card -->
    <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm space-y-4">
        <div class="border-b border-slate-200 pb-3 flex justify-between items-center">
            <div class="flex items-center gap-2">
                <span class="bg-[#064E3B] text-white text-[10px] font-extrabold px-2.5 py-0.5 rounded uppercase tracking-wider">
                    DETAIL ANGGOTA
                </span>
                <h3 class="text-base font-extrabold text-slate-900 uppercase tracking-wide mt-1">Identitas Pemohon pada Permohonan HKI</h3>
            </div>
            <span class="text-[10px] font-bold text-slate-600 bg-slate-100 px-2.5 py-1 rounded border border-slate-200">
                {{ $application->applicants->count() }} Anggota
            </span>
        </div>

        @forelse($application->applicants as $idx => $applicant)
            <div class="border border-slate-200 rounded-xl p-4 space-y-3 applicant-card-{{ $idx }}">
                <div class="flex items-center justify-between border-b border-slate-100 pb-2">
                    <h4 class="font-extrabold text-slate-900 text-xs uppercase tracking-wider flex items-center gap-1.5">
                        <span>👤</span>
                        <span>Anggota #{{ $idx + 1 }}{{ $applicant->is_primary ? ' (Pemohon Utama)' : '' }}</span>
                    </h4>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-x-6 gap-y-3 text-xs">
                    <div class="md:col-span-2">
                        <span class="block text-slate-500 font-bold uppercase text-[10px]">Nama Lengkap</span>
                        <span class="font-extrabold text-slate-900 mt-0.5 block">{{ $applicant->applicant_name }}</span>
                    </div>
                    <div>
                        <span class="block text-slate-500 font-bold uppercase text-[10px]">Fakultas / Unit Kerja</span>
                        <span class="font-bold text-slate-900 mt-0.5 block">{{ $applicant->applicant_faculty ?: '-' }}</span>
                    </div>
                    <div class="md:col-span-3">
                        <span class="block text-slate-500 font-bold uppercase text-[10px]">Alamat</span>
                        <span class="font-bold text-slate-900 mt-0.5 block">{{ $applicant->applicant_address ?: '-' }}</span>
                    </div>
                    <div>
                        <span class="block text-slate-500 font-bold uppercase text-[10px]">NIK</span>
                        <span class="font-mono font-bold text-slate-900 mt-0.5 block">{{ $applicant->applicant_nik ?: '-' }}</span>
                    </div>
                    <div>
                        <span class="block text-slate-500 font-bold uppercase text-[10px]">NIP</span>
                        <span class="font-mono font-bold text-slate-900 mt-0.5 block">{{ $applicant->applicant_nip ?: '-' }}</span>
                    </div>
                    <div>
                        <span class="block text-slate-500 font-bold uppercase text-[10px]">NIM</span>
                        <span class="font-mono font-bold text-slate-900 mt-0.5 block">{{ $applicant->applicant_nim ?: '-' }}</span>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-4 text-slate-500 text-xs">
                Belum ada data anggota terdaftar.
            </div>
        @endforelse
    </div>

    <!-- Grid 8 Dokumen HKI -->
    <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm space-y-4">
        <div class="border-b border-slate-200 pb-3 flex justify-between items-center">
            <div>
                <h3 class="text-base font-extrabold text-slate-900 uppercase tracking-wide">Pemeriksaan 8 Dokumen HKI Pemohon</h3>
                <p class="text-xs text-slate-500">Pastikan seluruh dokumen formulir paten telah lengkap dan valid sebelum mendaftarkan ke portal DJKI.</p>
            </div>
            <span class="text-xs font-bold text-slate-700 bg-slate-100 px-3 py-1 rounded border border-slate-200">
                Terunggah: {{ $application->documents->count() }} / 8
            </span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs">
            @php
                $templatesMap = \App\Http\Controllers\HkiApplicationController::TEMPLATES_MAP;
            @endphp

            @foreach($templatesMap as $key => $info)
                @php $doc = $documentsMap->get($key); @endphp
                <div class="p-3.5 rounded-lg border border-slate-200 flex justify-between items-center bg-slate-50">
                    <div>
                        <div class="font-bold text-slate-900 uppercase">{{ $info['label'] }}</div>
                        <div class="text-[11px] mt-0.5">
                            @if($doc)
                                <span class="text-emerald-600 font-bold">✓ Tersedia ({{ $doc->form_data['original_name'] ?? basename($doc->file_path) }})</span>
                            @else
                                <span class="text-red-500 font-bold">✖ Belum Diunggah</span>
                            @endif
                        </div>
                    </div>

                    @if($doc)
                        <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" class="bg-[#064E3B] hover:bg-[#047857] text-white px-3 py-1.5 rounded text-[11px] font-bold uppercase tracking-wider">
                            UNDUH DOKUMEN
                        </a>
                    @endif
                </div>
            @endforeach
        </div>
    </div>

    <!-- Form Input DJKI Application Number & SIMPAKI Billing Code -->
    <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm space-y-4">
        <div class="border-b border-slate-200 pb-3">
            <span class="bg-purple-600 text-white text-[10px] font-extrabold px-2.5 py-0.5 rounded uppercase tracking-wider">
                INTEGRASI PORTAL DJKI & SIMPAKI
            </span>
            <h3 class="text-base font-extrabold text-slate-900 uppercase tracking-wide mt-1">Input Nomor DJKI & Kode Billing SIMPAKI</h3>
            <p class="text-xs text-slate-500">Setelah Admin mendaftarkan secara manual di portal resmi DJKI, masukkan Kode Billing SIMPAKI agar User dapat melakukan pembayaran.</p>
        </div>

        <form action="{{ route('admin.applications.input-djki', $application->id) }}" method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-4 text-xs">
            @csrf
            <div>
                <label class="block font-bold text-slate-700 uppercase tracking-wide mb-1">Nomor Permohonan DJKI</label>
                <input type="text" name="djki_application_number" value="{{ old('djki_application_number', $application->djki_application_number) }}" placeholder="Contoh: P00202600123" class="w-full border border-slate-300 rounded p-2 text-slate-900 font-medium">
            </div>

            <div>
                <label class="block font-bold text-slate-700 uppercase tracking-wide mb-1">Kode Billing SIMPAKI <span class="text-red-600">*</span></label>
                <input type="text" name="simpaki_billing_code" value="{{ old('simpaki_billing_code', $application->simpaki_billing_code) }}" required placeholder="Contoh: 820260801001" class="w-full border border-slate-300 rounded p-2 text-slate-900 font-medium">
            </div>

            <div>
                <label class="block font-bold text-slate-700 uppercase tracking-wide mb-1">Nominal Tagihan (Rp) <span class="text-red-600">*</span></label>
                <input type="number" name="billing_amount" value="{{ old('billing_amount', $application->billing_amount ?? 500000) }}" required placeholder="500000" class="w-full border border-slate-300 rounded p-2 text-slate-900 font-medium">
            </div>

            <div class="md:col-span-3 flex justify-end">
                <button type="submit" class="bg-[#064E3B] hover:bg-[#047857] text-white px-6 py-2.5 rounded text-xs font-bold uppercase tracking-wider transition">
                    SIMPAN NOMOR DJKI & KODE BILLING
                </button>
            </div>
        </form>
    </div>

    <!-- Verifikasi Pembayaran & Kuitansi PDF -->
    @if($application->payments->isNotEmpty())
        <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm space-y-4">
            <h3 class="text-base font-extrabold text-slate-900 uppercase tracking-wide border-b border-slate-200 pb-3">
                Verifikasi Bukti Transfer & Penerbitan Kuitansi PDF
            </h3>

            @foreach($application->payments as $pay)
                <div class="p-4 bg-slate-50 rounded-lg border border-slate-200 flex flex-col md:flex-row justify-between items-start md:items-center gap-4 text-xs">
                    <div class="space-y-1">
                        <div><strong>Kode Billing:</strong> <span class="font-mono font-bold">{{ $pay->simpaki_code }}</span></div>
                        <div><strong>Nominal:</strong> <span class="font-bold text-emerald-800">Rp {{ number_format($pay->amount, 0, ',', '.') }}</span></div>
                        <div><strong>Status Pembayaran:</strong> <span class="uppercase font-bold text-amber-700">{{ $pay->status }}</span></div>
                    </div>

                    <div class="flex items-center space-x-3">
                        <a href="{{ asset('storage/' . $pay->proof_of_payment) }}" target="_blank" class="bg-slate-200 hover:bg-slate-300 text-slate-800 px-3 py-1.5 rounded font-bold uppercase">
                            Lihat Resi Bayar
                        </a>

                        @if($pay->status === 'pending')
                            <form action="{{ route('admin.payments.verify', $pay->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="bg-emerald-700 hover:bg-emerald-800 text-white px-4 py-1.5 rounded font-bold uppercase tracking-wider">
                                    VERIFIKASI & TERBITKAN KUITANSI
                                </button>
                            </form>
                        @elseif($pay->receipt_pdf_path)
                            <a href="{{ asset('storage/' . $pay->receipt_pdf_path) }}" target="_blank" class="bg-emerald-800 hover:bg-emerald-900 text-white px-3 py-1.5 rounded font-bold uppercase">
                                Unduh Kuitansi PDF
                            </a>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif

</div>
@endsection
