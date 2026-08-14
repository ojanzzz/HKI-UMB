@extends('layouts.app')

@section('title', 'FAQ Pertanyaan Umum - KI UM BIMA')

@section('content')
<div class="max-w-4xl mx-auto px-6 py-12 space-y-8">
    <div class="border-b border-slate-200 pb-4 text-center">
        <span class="bg-[#064E3B] text-white text-[10px] font-extrabold px-3 py-1 rounded uppercase tracking-wider">
            PUSAT BANTUAN & FAQ
        </span>
        <h2 class="text-3xl font-extrabold text-slate-900 uppercase tracking-tight mt-1">Pertanyaan Umum (FAQ) KI</h2>
        <p class="text-xs text-slate-500 mt-1">Temukan jawaban atas pertanyaan seputar pendaftaran Paten, E-Signature, dan SIMPAKI.</p>
    </div>

    <div class="space-y-4 text-xs">
        <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-xs">
            <h3 class="font-extrabold text-slate-900 text-sm uppercase mb-2">1. Apa saja 8 dokumen wajib untuk permohonan Paten?</h3>
            <p class="text-slate-600 leading-relaxed">
                4 Dokumen Teknis (Metode 1 Upload PDF): Deskripsi Paten, Abstrak Invensi, Klaim Invensi, dan Gambar Invensi.<br>
                4 Dokumen Administratif (Metode 2 Web-to-PDF & E-Signature): Data Dukung, Daftar Inventor, Surat Pernyataan Pengalihan Hak, dan Surat Pernyataan Kepemilikan.
            </p>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-xs">
            <h3 class="font-extrabold text-slate-900 text-sm uppercase mb-2">2. Bagaimana cara kerja E-Signature Canvas HTML5?</h3>
            <p class="text-slate-600 leading-relaxed">
                Anda cukup menggambar tanda tangan menggunakan mouse atau layar sentuh pada kanvas putih di form permohonan. Sistem akan mengubah gambar tanda tangan tersebut menjadi format digital dan secara otomatis menyisipkannya ke dalam template PDF Surat Pernyataan.
            </p>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-xs">
            <h3 class="font-extrabold text-slate-900 text-sm uppercase mb-2">3. Bagaimana alur pembayaran Kode Billing SIMPAKI DJKI?</h3>
            <p class="text-slate-600 leading-relaxed">
                Setelah dokumen Anda diverifikasi, Admin akan memasukkan Kode Billing SIMPAKI beserta nominalnya ke dalam sistem. Anda dapat mengunggah bukti transfer, dan setelah diverifikasi oleh Admin, sistem akan menerbitkan Kuitansi PDF Resmi.
            </p>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-xs">
            <h3 class="font-extrabold text-slate-900 text-sm uppercase mb-2">4. Mengapa akun saya berstatus 'Pending'?</h3>
            <p class="text-slate-600 leading-relaxed">
                Setiap pendaftar baru perlu melengkapi identitas (NIK/NIM/NIP, Fakultas, WA). Akun di-set ke status pending hingga Admin Direktorat Inovasi & KI UM Bima melakukan approval demi memastikan keabsahan sivitas akademika.
            </p>
        </div>
    </div>
</div>
@endsection
