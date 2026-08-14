@extends('layouts.dashboard')

@section('title', 'Verifikasi Akun Pemohon - Admin KI UM BIMA')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-8 space-y-6">
    <div class="border-b border-slate-200 pb-4">
        <span class="bg-red-600 text-white text-[10px] font-extrabold px-2.5 py-1 rounded uppercase tracking-wider">
            PANEL VERIFIKASI AKUN
        </span>
        <h2 class="text-2xl font-extrabold text-slate-900 uppercase tracking-tight mt-1">Verifikasi Akun Pemohon KI</h2>
        <p class="text-xs text-slate-500">Approve atau Reject pendaftaran pemohon baru yang telah melengkapi NIK, KTP, dan No. WA.</p>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-xs text-left text-slate-700">
                <thead class="bg-[#064E3B] text-white uppercase text-[10px] font-extrabold">
                    <tr>
                        <th class="py-3 px-6">Nama Pemohon</th>
                        <th class="py-3 px-6">NIK (Wajib)</th>
                        <th class="py-3 px-6">NIP / NIM (Opsional)</th>
                        <th class="py-3 px-6">KTP (Wajib)</th>
                        <th class="py-3 px-6">Fakultas / Unit</th>
                        <th class="py-3 px-6">WhatsApp</th>
                        <th class="py-3 px-6">Status Akun</th>
                        <th class="py-3 px-6 text-center">Aksi Admin</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($users as $u)
                        <tr class="hover:bg-slate-50">
                            <td class="py-3.5 px-6 font-bold text-slate-900">
                                {{ $u->name }}
                                <div class="text-[10px] text-slate-500 font-normal">{{ $u->email }}</div>
                            </td>
                            <td class="py-3.5 px-6 font-mono font-bold text-slate-900">{{ $u->nik ?? ($u->identity_number ?? '-') }}</td>
                            <td class="py-3.5 px-6 font-mono text-slate-700">
                                @if($u->nip) <span class="block">NIP: {{ $u->nip }}</span> @endif
                                @if($u->nim) <span class="block">NIM: {{ $u->nim }}</span> @endif
                                @if(!$u->nip && !$u->nim) - @endif
                            </td>
                            <td class="py-3.5 px-6 font-medium">
                                @if($u->ktp_path)
                                    <a href="{{ asset('storage/' . $u->ktp_path) }}" target="_blank" class="bg-emerald-100 hover:bg-emerald-200 text-emerald-900 font-extrabold px-2.5 py-1 rounded border border-emerald-300 transition text-[10px] inline-flex items-center gap-1">
                                        <span>🪪</span>
                                        <span>Lihat KTP</span>
                                    </a>
                                @else
                                    <span class="text-red-500 font-bold text-[10px]">Belum Upload KTP</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-6 font-medium text-slate-700">{{ $u->faculty ?? '-' }}</td>
                            <td class="py-3.5 px-6 text-slate-700 font-semibold">{{ $u->phone_number ?? '-' }}</td>
                            <td class="py-3.5 px-6">
                                @if($u->status === 'approved')
                                    <span class="bg-emerald-100 text-emerald-800 text-[10px] font-bold px-2 py-0.5 rounded border border-emerald-300 uppercase">✓ APPROVED</span>
                                @elseif($u->status === 'pending')
                                    <span class="bg-amber-100 text-amber-800 text-[10px] font-bold px-2 py-0.5 rounded border border-amber-300 uppercase">⏳ PENDING</span>
                                @else
                                    <span class="bg-red-100 text-red-800 text-[10px] font-bold px-2 py-0.5 rounded border border-red-300 uppercase">✖ REJECTED</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-6 text-center">
                                <div class="flex justify-center gap-2">
                                    @if($u->status !== 'approved')
                                        <form action="{{ route('admin.users.approve', $u->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" onclick="return confirm('Approve akun user ini?')" class="bg-emerald-600 hover:bg-emerald-700 text-white px-3 py-1 rounded text-[11px] font-bold uppercase shadow-xs">
                                                APPROVE
                                            </button>
                                        </form>
                                    @endif

                                    @if($u->status !== 'rejected')
                                        <form action="{{ route('admin.users.reject', $u->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" onclick="return confirm('Tolak akun user ini?')" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-[11px] font-bold uppercase shadow-xs">
                                                REJECT
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-8 text-center text-slate-500">Belum ada data pemohon.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-slate-200">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection
