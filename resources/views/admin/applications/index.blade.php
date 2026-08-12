@extends('layouts.dashboard')

@section('title', 'Daftar Pengajuan HKI - Admin HKI UMB')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-8 space-y-6">
    <div class="border-b border-slate-200 pb-3 flex justify-between items-center">
        <div>
            <span class="bg-[#002855] text-white text-[10px] font-extrabold px-2.5 py-1 rounded uppercase tracking-wider">
                MANAJEMEN HKI
            </span>
            <h2 class="text-2xl font-extrabold text-slate-900 uppercase tracking-tight mt-1">Daftar Seluruh Permohonan HKI</h2>
            <p class="text-xs text-slate-500">Cek 8 dokumen, lakukan Export ZIP untuk portal DJKI, serta terbitkan Billing SIMPAKI.</p>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-xs text-left text-slate-700">
                <thead class="bg-[#002855] text-white uppercase text-[10px] font-extrabold">
                    <tr>
                        <th class="py-3 px-6">ID App</th>
                        <th class="py-3 px-6">Pemohon & Fakultas</th>
                        <th class="py-3 px-6">Judul Paten / Invensi</th>
                        <th class="py-3 px-6">8 Dokumen</th>
                        <th class="py-3 px-6">No. DJKI / SIMPAKI</th>
                        <th class="py-3 px-6">Status App</th>
                        <th class="py-3 px-6 text-center">Aksi Admin</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($applications as $app)
                        <tr class="hover:bg-slate-50">
                            <td class="py-3.5 px-6 font-bold text-slate-900">#{{ $app->id }}</td>
                             <td class="py-3.5 px-6">
                                 <div class="font-bold text-slate-900">{{ $app->applicants->first()?->applicant_name ?: ($app->applicant_name ?: $app->user->name) }}</div>
                                 <div class="text-[10px] text-slate-500">
                                     NIK: {{ $app->applicants->first()?->applicant_nik ?: ($app->user->nik ?? $app->user->identity_number ?? '-') }} | 
                                     NIP: {{ $app->applicants->first()?->applicant_nip ?: ($app->user->nip ?? '-') }} | 
                                     NIM: {{ $app->applicants->first()?->applicant_nim ?: ($app->user->nim ?? '-') }}
                                 </div>
                                 <div class="text-[10px] text-slate-500">{{ $app->applicants->first()?->applicant_faculty ?: ($app->user->faculty ?: '-') }} ({{ $app->applicants->count() }} anggota)</div>
                             </td>
                            <td class="py-3.5 px-6 font-bold text-slate-800">{{ $app->title }}</td>
                            <td class="py-3.5 px-6 font-bold text-blue-900">
                                {{ $app->documents->count() }} / 8 Terunggah
                            </td>
                            <td class="py-3.5 px-6">
                                @if($app->djki_application_number)
                                    <div class="font-bold text-slate-900">DJKI: {{ $app->djki_application_number }}</div>
                                @endif
                                @if($app->simpaki_billing_code)
                                    <div class="text-[10px] text-purple-700 font-semibold">SIMPAKI: {{ $app->simpaki_billing_code }}</div>
                                @endif
                                @if(!$app->djki_application_number && !$app->simpaki_billing_code)
                                    <span class="text-slate-400 italic">Belum Diinput</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-6">
                                <span class="bg-slate-100 text-slate-800 text-[10px] font-bold px-2 py-0.5 rounded border border-slate-200 uppercase">
                                    {{ $app->status }}
                                </span>
                            </td>
                            <td class="py-3.5 px-6 text-center">
                                <a href="{{ route('admin.applications.show', $app->id) }}" class="bg-[#002855] hover:bg-[#003366] text-white px-3.5 py-1.5 rounded text-[11px] font-bold uppercase tracking-wider shadow-xs">
                                    REVIEW & EXPORT ZIP &rarr;
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-slate-500">Belum ada permohonan HKI yang diajukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-slate-200">
            {{ $applications->links() }}
        </div>
    </div>
</div>
@endsection
