@extends('layouts.app')

@section('title', 'Tentang Direktorat Inovasi & KI - UM BIMA')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-10 space-y-8">
    <div class="border-b border-slate-200 pb-4">
        <span class="bg-[#064E3B] text-white text-[10px] font-extrabold px-2.5 py-1 rounded uppercase tracking-wider">
            PROFIL INSTITUSI
        </span>
        <h2 class="text-3xl font-extrabold text-slate-900 uppercase tracking-tight mt-1">Direktorat Inovasi dan Kekayaan Intelektual (KI) UM Bima</h2>
        <p class="text-xs text-slate-500 mt-1">Lembaga Pengelola & Pendamping Hak Kekayaan Intelektual Terintegrasi DJKI Kemenkumham RI.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
        <div class="space-y-4 text-xs text-slate-700 leading-relaxed">
            <h3 class="text-lg font-extrabold text-slate-900 uppercase tracking-wide">Visi & Misi Direktorat Inovasi & KI UM BIMA</h3>
            <p>
                Direktorat Inovasi dan Kekayaan Intelektual (KI) Universitas Muhammadiyah Bima (UM BIMA) bertugas untuk mendorong, mengelola, dan mengkomersialisasikan hasil riset dan inovasi yang dihasilkan oleh Dosen, Peneliti, dan Mahasiswa.
            </p>
            <div class="bg-emerald-50 border border-emerald-200 p-4 rounded-xl space-y-2">
                <div class="font-extrabold text-[#064E3B] uppercase">Layanan Utama Direktorat Inovasi & KI UM BIMA:</div>
                <ul class="list-disc list-inside space-y-1">
                    <li>Pendampingan Penyusunan Dokumen Spesifikasi Paten (Drafting Paten).</li>
                    <li>Fasilitasi Penilaian Kebaruan (Novelty Check) di Pangkalan Data KI.</li>
                    <li>Otomatisasi Dokumen Administratif & E-Signature Canvas HTML5.</li>
                    <li>Pengurusan Kode Billing SIMPAKI DJKI & Penerbitan Kuitansi Resmi.</li>
                    <li>Ekspor Paket ZIP 8 Dokumen untuk Portal E-Filing DJKI.</li>
                </ul>
            </div>
        </div>

        <div class="bg-[#064E3B] text-white p-8 rounded-2xl shadow-xl space-y-4">
            <h4 class="font-extrabold uppercase text-sm border-b border-emerald-700 pb-2">Informasi Kontak Direktorat Inovasi & KI</h4>
            <div class="space-y-2 text-xs text-emerald-100">
                <p><strong>Alamat Kantor:</strong><br>Gedung Rektorat UM BIMA Lt. 2<br>Jl. Anggrek No. 16, Kota Bima, Nusa Tenggara Barat</p>
                <p><strong>Email Respon Cepat:</strong><br>hki@umbima.ac.id</p>
                <p><strong>Jam Operasional:</strong><br>Senin - Jumat | 08.00 - 16.00 WITA</p>
            </div>
        </div>
    </div>
</div>
@endsection
