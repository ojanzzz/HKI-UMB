@extends('layouts.dashboard')

@section('title', 'Dashboard Admin - HKI UMB')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-8 space-y-8">
    <div class="border-b border-slate-200 pb-4">
        <span class="bg-red-600 text-white text-[10px] font-extrabold px-2.5 py-1 rounded uppercase tracking-wider">
            PANEL ADMINISTRATOR
        </span>
        <h2 class="text-2xl font-extrabold text-slate-900 uppercase tracking-tight mt-1">Dashboard Sentra HKI UMB</h2>
        <p class="text-xs text-slate-500">Kelola verifikasi akun, review 8 dokumen, export ZIP DJKI, dan pembayaran SIMPAKI.</p>
    </div>

    <!-- Metric Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
        <a href="{{ route('admin.users') }}" class="bg-white p-6 rounded-xl border border-slate-200 hover:border-red-500 shadow-xs hover:shadow-md transition-all">
            <div class="flex justify-between items-center">
                <div>
                    <div class="text-xs font-bold text-slate-500 uppercase">Pending Verification Akun</div>
                    <div class="text-3xl font-extrabold text-amber-600 mt-1">{{ $pendingUsersCount }}</div>
                </div>
                <div class="w-12 h-12 bg-amber-50 text-amber-600 rounded-lg flex items-center justify-center font-bold text-xl">👤</div>
            </div>
            <div class="mt-4 text-[11px] font-bold text-red-600 uppercase tracking-wider">Verifikasi Akun &rarr;</div>
        </a>

        <a href="{{ route('admin.applications') }}" class="bg-white p-6 rounded-xl border border-slate-200 hover:border-red-500 shadow-xs hover:shadow-md transition-all">
            <div class="flex justify-between items-center">
                <div>
                    <div class="text-xs font-bold text-slate-500 uppercase">Total Pengajuan HKI</div>
                    <div class="text-3xl font-extrabold text-[#002855] mt-1">{{ $totalApplicationsCount }}</div>
                </div>
                <div class="w-12 h-12 bg-blue-50 text-[#002855] rounded-lg flex items-center justify-center font-bold text-xl">📄</div>
            </div>
            <div class="mt-4 text-[11px] font-bold text-red-600 uppercase tracking-wider">Review Permohonan &rarr;</div>
        </a>

        <a href="{{ route('admin.applications') }}" class="bg-white p-6 rounded-xl border border-slate-200 hover:border-red-500 shadow-xs hover:shadow-md transition-all">
            <div class="flex justify-between items-center">
                <div>
                    <div class="text-xs font-bold text-slate-500 uppercase">Pending Pembayaran</div>
                    <div class="text-3xl font-extrabold text-purple-600 mt-1">{{ $pendingPaymentCount }}</div>
                </div>
                <div class="w-12 h-12 bg-purple-50 text-purple-600 rounded-lg flex items-center justify-center font-bold text-xl">💳</div>
            </div>
            <div class="mt-4 text-[11px] font-bold text-red-600 uppercase tracking-wider">Verifikasi Transfer &rarr;</div>
        </a>
    </div>

    <!-- Recent Applications Table -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="bg-[#002855] text-white px-6 py-4 flex justify-between items-center">
            <h3 class="font-extrabold uppercase text-xs tracking-wider">Permohonan HKI Terbaru</h3>
            <a href="{{ route('admin.applications') }}" class="text-xs text-blue-200 hover:text-white font-bold uppercase">Lihat Semua</a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-xs text-left text-slate-700">
                <thead class="bg-slate-100 uppercase text-[10px] text-slate-500 font-extrabold border-b border-slate-200">
                    <tr>
                        <th class="py-3 px-6">ID</th>
                        <th class="py-3 px-6">Pemohon / UMB</th>
                        <th class="py-3 px-6">Judul Invensi</th>
                        <th class="py-3 px-6">Status</th>
                        <th class="py-3 px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($recentApplications as $app)
                        <tr class="hover:bg-slate-50">
                            <td class="py-3.5 px-6 font-bold text-slate-900">#{{ $app->id }}</td>
                            <td class="py-3.5 px-6">
                                <div class="font-bold text-slate-900">{{ $app->user->name }}</div>
                                <div class="text-[10px] text-slate-500">{{ $app->user->identity_number }} - {{ $app->user->faculty }}</div>
                            </td>
                            <td class="py-3.5 px-6 font-bold text-slate-800">{{ $app->title }}</td>
                            <td class="py-3.5 px-6">
                                <span class="bg-slate-100 text-slate-800 text-[10px] font-bold px-2 py-0.5 rounded border border-slate-200 uppercase">
                                    {{ $app->status }}
                                </span>
                            </td>
                            <td class="py-3.5 px-6 text-right">
                                <a href="{{ route('admin.applications.show', $app->id) }}" class="bg-[#002855] hover:bg-[#003366] text-white px-3 py-1.5 rounded font-bold uppercase tracking-wider">
                                    REVIEW & EXPORT ZIP
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-6 text-center text-slate-500">Belum ada permohonan HKI masuk.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
