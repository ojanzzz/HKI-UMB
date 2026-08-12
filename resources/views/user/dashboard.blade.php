@extends('layouts.dashboard')

@section('title', 'Dashboard Pemohon HKI - Sentra HKI UM BIMA')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-8 space-y-8">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 border-b border-slate-200 pb-4">
        <div>
            <span class="bg-[#064E3B] text-white text-[10px] font-extrabold px-2.5 py-1 rounded uppercase tracking-wider">
                PORTAL PEMOHON
            </span>
            <h2 class="text-2xl font-extrabold text-slate-900 uppercase tracking-tight mt-1">Daftar Pengajuan Paten & HKI Saya</h2>
            <p class="text-xs text-slate-500">Satu akun dapat mengajukan beberapa permohonan HKI. Kelola draft dan lacak status dokumen Anda di sini.</p>
        </div>
        <a href="{{ route('applications.create') }}" class="bg-amber-500 hover:bg-amber-600 text-slate-950 px-5 py-2.5 rounded-lg text-xs font-extrabold uppercase tracking-wider transition shadow-xs flex items-center space-x-2">
            <span>+ AJUKAN PATEN / HKI BARU</span>
        </a>
    </div>

    @if($applications->isEmpty())
        <div class="bg-white rounded-2xl border border-slate-200 p-12 text-center shadow-xs space-y-3">
            <div class="w-16 h-16 bg-emerald-50 text-[#064E3B] rounded-2xl flex items-center justify-center mx-auto mb-4 text-3xl font-extrabold">
                📂
            </div>
            <h3 class="text-base font-extrabold text-slate-900 uppercase tracking-wide">Belum Ada Permohonan HKI</h3>
            <p class="text-xs text-slate-500 max-w-sm mx-auto">Anda belum mendaftarkan permohonan HKI. Klik tombol di bawah untuk membuat pengajuan pertama Anda.</p>
            <a href="{{ route('applications.create') }}" class="inline-block bg-[#064E3B] hover:bg-[#047857] text-white px-6 py-2.5 rounded-lg text-xs font-extrabold uppercase tracking-wider transition shadow-xs">
                + Ajukan Permohonan HKI Baru
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 gap-6">
            @foreach($applications as $app)
                <div class="bg-white rounded-2xl border border-slate-200 hover:border-emerald-600 shadow-xs hover:shadow-md transition-all duration-200 p-6 flex flex-col md:flex-row justify-between gap-6">
                    <div class="space-y-3 flex-1">
                        <div class="flex items-center gap-3 flex-wrap">
                            <span class="text-[11px] font-extrabold bg-[#064E3B] text-white px-3 py-1 rounded-md uppercase tracking-wider">
                                {{ strtoupper($app->application_type) }}
                            </span>
                            
                            <!-- Status Badge -->
                            @if($app->status === 'draft')
                                <span class="bg-amber-100 text-amber-800 border border-amber-300 text-[10px] font-extrabold px-2.5 py-1 rounded uppercase">
                                    📋 DRAFT (PENGISIAN DOKUMEN)
                                </span>
                            @elseif($app->status === 'submitted')
                                <span class="bg-blue-100 text-blue-800 border border-blue-300 text-[10px] font-extrabold px-2.5 py-1 rounded uppercase">
                                    ⏳ TERKIRIM (REVIEW ADMIN)
                                </span>
                            @elseif($app->status === 'billing_issued')
                                <span class="bg-purple-100 text-purple-800 border border-purple-300 text-[10px] font-extrabold px-2.5 py-1 rounded uppercase">
                                    💳 BILLING SIMPAKI DITERBITKAN
                                </span>
                            @elseif($app->status === 'payment_pending')
                                <span class="bg-amber-100 text-amber-800 border border-amber-300 text-[10px] font-extrabold px-2.5 py-1 rounded uppercase">
                                    ⏳ VERIFIKASI BUKTI BAYAR
                                </span>
                            @elseif($app->status === 'paid' || $app->status === 'submitted_to_djki')
                                <span class="bg-emerald-100 text-emerald-800 border border-emerald-300 text-[10px] font-extrabold px-2.5 py-1 rounded uppercase">
                                    ✓ TERDAFTAR & LUNAS DJKI
                                </span>
                            @else
                                <span class="bg-slate-100 text-slate-800 border border-slate-300 text-[10px] font-extrabold px-2.5 py-1 rounded uppercase">
                                    {{ strtoupper($app->status) }}
                                </span>
                            @endif

                            @if($app->djki_application_number)
                                <span class="text-[11px] font-mono font-bold text-slate-700 bg-slate-100 px-2.5 py-1 rounded border border-slate-200">
                                    NO. DJKI: {{ $app->djki_application_number }}
                                </span>
                            @endif
                        </div>

                        <h3 class="text-lg font-extrabold text-slate-900 uppercase tracking-wide">
                            {{ $app->title }}
                        </h3>

                        @if($app->description)
                            <p class="text-xs text-slate-600 line-clamp-2 leading-relaxed">
                                {{ $app->description }}
                            </p>
                        @endif

                        <div class="flex flex-wrap gap-4 text-xs text-slate-500 font-medium pt-1">
                            <div>Dokumen Terunggah: <strong class="text-emerald-800 font-bold">{{ $app->documents->count() }} / 8 Formulir</strong></div>
                            <div>Tanggal Buat: <strong class="text-slate-800">{{ $app->created_at->format('d M Y H:i') }}</strong></div>
                        </div>

                        @if($app->simpaki_billing_code)
                            <div class="bg-purple-50 border border-purple-200 p-3 rounded-xl text-xs text-purple-900">
                                <span class="font-bold">Kode Billing SIMPAKI DJKI:</span> <span class="font-mono font-bold text-purple-950">{{ $app->simpaki_billing_code }}</span> | 
                                <span class="font-bold">Tagihan PNBP:</span> Rp {{ number_format($app->billing_amount, 0, ',', '.') }}
                            </div>
                        @endif
                    </div>

                    <div class="flex flex-col justify-center gap-2 min-w-[200px]">
                        <a href="{{ route('applications.show', $app->id) }}" class="w-full bg-[#064E3B] hover:bg-[#047857] text-white font-extrabold text-xs py-3 px-4 rounded-xl transition text-center uppercase tracking-wider shadow-xs flex items-center justify-center space-x-1.5">
                            <span>KELOLA & BUKA DRAFT</span>
                            <span>&rarr;</span>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
