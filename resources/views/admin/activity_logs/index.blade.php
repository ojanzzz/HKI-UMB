@extends('layouts.dashboard')

@section('title', 'Log Aktivitas Sistem - Admin HKI UMB')

@section('content')
<div class="max-w-7xl mx-auto space-y-8 py-4">
    <!-- Header Section -->
    <div class="border-b border-slate-200 pb-4 flex justify-between items-center">
        <div>
            <span class="bg-[#064E3B] text-white text-[10px] font-extrabold px-2.5 py-1 rounded uppercase tracking-wider">
                AUDIT LOGS ADMINISTRATOR
            </span>
            <h2 class="text-2xl font-extrabold text-slate-900 uppercase tracking-tight mt-1">Log Aktivitas Sistem & Pengguna</h2>
            <p class="text-xs text-slate-500">Mencatat secara otomatis setiap aktivitas pengguna termasuk registrasi, login, IP address, pengisian dokumen, dan tindakan admin.</p>
        </div>
    </div>

    <!-- Filter & Search Bar -->
    <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-xs">
        <form action="{{ route('admin.activity-logs') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-xs">
            <div>
                <label class="block font-bold text-slate-700 uppercase mb-1">Cari Nama / Email / Deskripsi / IP</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Ketik kata kunci..." class="w-full border border-slate-300 rounded-lg p-2.5 text-slate-900 font-medium">
            </div>

            <div>
                <label class="block font-bold text-slate-700 uppercase mb-1">Filter Jenis Aksi (Action)</label>
                <select name="action" class="w-full border border-slate-300 rounded-lg p-2.5 text-slate-900 font-medium bg-white">
                    <option value="">Semua Aksi</option>
                    <option value="LOGIN" {{ request('action') == 'LOGIN' ? 'selected' : '' }}>LOGIN</option>
                    <option value="REGISTER" {{ request('action') == 'REGISTER' ? 'selected' : '' }}>REGISTER</option>
                    <option value="CREATE_APPLICATION" {{ request('action') == 'CREATE_APPLICATION' ? 'selected' : '' }}>CREATE APPLICATION</option>
                    <option value="UPLOAD_DOCUMENT" {{ request('action') == 'UPLOAD_DOCUMENT' ? 'selected' : '' }}>UPLOAD DOCUMENT</option>
                    <option value="VERIFY_USER" {{ request('action') == 'VERIFY_USER' ? 'selected' : '' }}>VERIFY USER</option>
                    <option value="BILLING_ISSUED" {{ request('action') == 'BILLING_ISSUED' ? 'selected' : '' }}>BILLING ISSUED</option>
                    <option value="PAYMENT_VERIFIED" {{ request('action') == 'PAYMENT_VERIFIED' ? 'selected' : '' }}>PAYMENT VERIFIED</option>
                </select>
            </div>

            <div class="flex items-end gap-2">
                <button type="submit" class="w-full bg-[#064E3B] hover:bg-[#047857] text-white font-extrabold py-2.5 px-4 rounded-lg uppercase tracking-wider transition">
                    FILTER LOGS
                </button>
                <a href="{{ route('admin.activity-logs') }}" class="bg-slate-200 hover:bg-slate-300 text-slate-800 font-extrabold py-2.5 px-3 rounded-lg uppercase transition">
                    RESET
                </a>
            </div>
        </form>
    </div>

    <!-- Activity Log Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-xs text-left text-slate-700">
                <thead class="bg-[#064E3B] text-white uppercase text-[10px] font-extrabold">
                    <tr>
                        <th class="py-3.5 px-5">Waktu (Timestamp)</th>
                        <th class="py-3.5 px-5">Pengguna (User Name & Email)</th>
                        <th class="py-3.5 px-5">Aksi (Action)</th>
                        <th class="py-3.5 px-5">Deskripsi Aktivitas</th>
                        <th class="py-3.5 px-5">IP Address</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($logs as $log)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="py-3.5 px-5 font-mono text-slate-600 whitespace-nowrap">
                                <div>{{ $log->created_at->format('d M Y H:i:s') }}</div>
                                <div class="text-[10px] text-slate-400">{{ $log->created_at->diffForHumans() }}</div>
                            </td>

                            <td class="py-3.5 px-5">
                                <div class="font-bold text-slate-900 text-xs">{{ $log->user_name }}</div>
                                <div class="text-[10px] text-slate-500 font-medium">{{ $log->user_email }}</div>
                            </td>

                            <td class="py-3.5 px-5">
                                @if($log->action === 'LOGIN')
                                    <span class="bg-blue-100 text-blue-800 border border-blue-300 font-mono font-bold text-[10px] px-2 py-0.5 rounded uppercase">LOGIN</span>
                                @elseif($log->action === 'REGISTER')
                                    <span class="bg-emerald-100 text-emerald-800 border border-emerald-300 font-mono font-bold text-[10px] px-2 py-0.5 rounded uppercase">REGISTER</span>
                                @elseif($log->action === 'CREATE_APPLICATION')
                                    <span class="bg-purple-100 text-purple-800 border border-purple-300 font-mono font-bold text-[10px] px-2 py-0.5 rounded uppercase">NEW APP</span>
                                @elseif($log->action === 'VERIFY_USER' || $log->action === 'PAYMENT_VERIFIED')
                                    <span class="bg-emerald-100 text-emerald-800 border border-emerald-300 font-mono font-bold text-[10px] px-2 py-0.5 rounded uppercase">{{ $log->action }}</span>
                                @else
                                    <span class="bg-amber-100 text-amber-900 border border-amber-300 font-mono font-bold text-[10px] px-2 py-0.5 rounded uppercase">{{ $log->action }}</span>
                                @endif
                            </td>

                            <td class="py-3.5 px-5 font-medium text-slate-800">
                                {{ $log->description }}
                            </td>

                            <td class="py-3.5 px-5 font-mono text-slate-600 whitespace-nowrap">
                                <div>{{ $log->ip_address }}</div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-slate-500 font-medium">Belum ada riwayat aktivitas sistem yang tercatat.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-slate-200">
            {{ $logs->links() }}
        </div>
    </div>
</div>
@endsection
