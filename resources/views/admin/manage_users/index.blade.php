@extends('layouts.dashboard')

@section('title', 'Manajemen User & Admin - Admin HKI UMB')

@section('content')
<div class="max-w-7xl mx-auto space-y-8 py-4">
    <!-- Header Section -->
    <div class="border-b border-slate-200 pb-4 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <span class="bg-[#064E3B] text-white text-[10px] font-extrabold px-2.5 py-1 rounded uppercase tracking-wider">
                ADMINISTRATOR CONTROL PANEL
            </span>
            <h2 class="text-2xl font-extrabold text-slate-900 uppercase tracking-tight mt-1">Manajemen User & Administrator</h2>
            <p class="text-xs text-slate-500">Tambah admin baru, reset password akun, edit profil & peran, serta kelola status pengguna.</p>
        </div>
        <button onclick="document.getElementById('addAdminModal').classList.remove('hidden')" class="bg-amber-500 hover:bg-amber-600 text-slate-950 px-5 py-2.5 rounded-lg text-xs font-extrabold uppercase tracking-wider transition shadow-xs flex items-center space-x-2">
            <span>+ TAMBAH ADMINISTRATOR BARU</span>
        </button>
    </div>

    <!-- Filter & Search Bar -->
    <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-xs">
        <form action="{{ route('admin.manage-users') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 text-xs">
            <div>
                <label class="block font-bold text-slate-700 uppercase mb-1">Cari Nama / Email / NIK</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Ketik pencarian..." class="w-full border border-slate-300 rounded-lg p-2.5 text-slate-900 font-medium">
            </div>

            <div>
                <label class="block font-bold text-slate-700 uppercase mb-1">Filter Peran (Role)</label>
                <select name="role" class="w-full border border-slate-300 rounded-lg p-2.5 text-slate-900 font-medium bg-white">
                    <option value="">Semua Peran</option>
                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Administrator (ADMIN)</option>
                    <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>Pemohon (USER)</option>
                </select>
            </div>

            <div>
                <label class="block font-bold text-slate-700 uppercase mb-1">Filter Status Akun</label>
                <select name="status" class="w-full border border-slate-300 rounded-lg p-2.5 text-slate-900 font-medium bg-white">
                    <option value="">Semua Status</option>
                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>APPROVED</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>PENDING</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>REJECTED</option>
                </select>
            </div>

            <div class="flex items-end gap-2">
                <button type="submit" class="w-full bg-[#064E3B] hover:bg-[#047857] text-white font-extrabold py-2.5 px-4 rounded-lg uppercase tracking-wider transition">
                    CARI & FILTER
                </button>
                <a href="{{ route('admin.manage-users') }}" class="bg-slate-200 hover:bg-slate-300 text-slate-800 font-extrabold py-2.5 px-3 rounded-lg uppercase transition">
                    RESET
                </a>
            </div>
        </form>
    </div>

    <!-- Table Users -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-xs text-left text-slate-700">
                <thead class="bg-[#064E3B] text-white uppercase text-[10px] font-extrabold">
                    <tr>
                        <th class="py-3.5 px-5">Pengguna</th>
                        <th class="py-3.5 px-5">Peran</th>
                        <th class="py-3.5 px-5">NIK / NIP / NIM</th>
                        <th class="py-3.5 px-5">Dokumen KTP</th>
                        <th class="py-3.5 px-5">Fakultas / No. WA</th>
                        <th class="py-3.5 px-5">Status</th>
                        <th class="py-3.5 px-5 text-center">Aksi Admin</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($users as $u)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="py-3.5 px-5">
                                <div class="font-extrabold text-slate-900 text-sm flex items-center gap-2">
                                    <div class="w-7 h-7 bg-amber-500 text-slate-950 rounded-full font-bold flex items-center justify-center text-xs shrink-0">
                                        {{ strtoupper(substr($u->name, 0, 1)) }}
                                    </div>
                                    <span>{{ $u->name }}</span>
                                </div>
                                <div class="text-[11px] text-slate-500 font-medium pl-9">{{ $u->email }}</div>
                            </td>

                            <td class="py-3.5 px-5">
                                @if($u->role === 'admin')
                                    <span class="bg-purple-100 text-purple-900 border border-purple-300 font-extrabold text-[10px] px-2.5 py-0.5 rounded uppercase">
                                        ADMINISTRATOR
                                    </span>
                                @else
                                    <span class="bg-slate-100 text-slate-800 border border-slate-300 font-bold text-[10px] px-2.5 py-0.5 rounded uppercase">
                                        PEMOHON (USER)
                                    </span>
                                @endif
                            </td>

                            <td class="py-3.5 px-5">
                                <div class="font-mono font-bold text-slate-900">NIK: {{ $u->nik ?? ($u->identity_number ?? '-') }}</div>
                                @if($u->nip) <div class="font-mono text-[10px] text-slate-500">NIP: {{ $u->nip }}</div> @endif
                                @if($u->nim) <div class="font-mono text-[10px] text-slate-500">NIM: {{ $u->nim }}</div> @endif
                            </td>

                            <td class="py-3.5 px-5">
                                @if($u->ktp_path)
                                    <a href="{{ asset('storage/' . $u->ktp_path) }}" target="_blank" class="bg-emerald-100 hover:bg-emerald-200 text-emerald-900 font-extrabold px-2.5 py-1 rounded border border-emerald-300 text-[10px] inline-flex items-center gap-1">
                                        <span>🪪</span>
                                        <span>Lihat KTP</span>
                                    </a>
                                @else
                                    <span class="text-slate-400 font-semibold text-[10px]">-</span>
                                @endif
                            </td>

                            <td class="py-3.5 px-5">
                                <div class="font-semibold text-slate-800">{{ $u->faculty ?? '-' }}</div>
                                <div class="text-[10px] text-slate-500 font-medium">WA: {{ $u->phone_number ?? '-' }}</div>
                            </td>

                            <td class="py-3.5 px-5">
                                @if($u->status === 'approved')
                                    <span class="bg-emerald-100 text-emerald-800 border border-emerald-300 text-[10px] font-bold px-2 py-0.5 rounded uppercase">✓ APPROVED</span>
                                @elseif($u->status === 'pending')
                                    <span class="bg-amber-100 text-amber-800 border border-amber-300 text-[10px] font-bold px-2 py-0.5 rounded uppercase">⏳ PENDING</span>
                                @else
                                    <span class="bg-red-100 text-red-800 border border-red-300 text-[10px] font-bold px-2 py-0.5 rounded uppercase">✖ REJECTED</span>
                                @endif
                            </td>

                            <td class="py-3.5 px-5 text-center">
                                <div class="flex items-center justify-center gap-1.5">
                                    <!-- Edit User Button -->
                                    <button onclick="openEditModal({{ json_encode($u) }})" class="bg-blue-600 hover:bg-blue-700 text-white px-2.5 py-1 rounded text-[10px] font-bold uppercase transition" title="Edit Profil & Peran">
                                        ✏️ Edit
                                    </button>

                                    <!-- Reset Password Button -->
                                    <button onclick="openResetPasswordModal({{ $u->id }}, '{{ $u->name }}')" class="bg-amber-500 hover:bg-amber-600 text-slate-950 px-2.5 py-1 rounded text-[10px] font-bold uppercase transition" title="Reset Password Akun">
                                        🔑 Password
                                    </button>

                                    <!-- Delete Button -->
                                    @if(auth()->id() !== $u->id)
                                        <form action="{{ route('admin.manage-users.delete', $u->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun {{ $u->name }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-2 py-1 rounded text-[10px] font-bold uppercase transition" title="Hapus Akun">
                                                🗑️
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-slate-500 font-medium">Tidak ada data pengguna ditemukan.</td>
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

<!-- 1. MODAL TAMBAH ADMINISTRATOR BARU -->
<div id="addAdminModal" class="hidden fixed inset-0 z-50 bg-slate-950/60 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-lg w-full p-6 space-y-4 shadow-2xl border border-slate-200 text-xs">
        <div class="flex justify-between items-center border-b border-slate-200 pb-3">
            <h3 class="font-extrabold text-sm text-slate-900 uppercase">➕ Tambah Akun Administrator Baru</h3>
            <button onclick="document.getElementById('addAdminModal').classList.add('hidden')" class="text-slate-400 hover:text-red-600 text-xl font-bold">&times;</button>
        </div>

        <form action="{{ route('admin.manage-users.store-admin') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block font-bold text-slate-800 uppercase mb-1">Nama Lengkap Administrator <span class="text-red-600">*</span></label>
                <input type="text" name="name" required placeholder="Contoh: Admin Sentra HKI 2" class="w-full border border-slate-300 rounded-lg p-2.5 text-slate-900 font-medium">
            </div>

            <div>
                <label class="block font-bold text-slate-800 uppercase mb-1">Alamat Email <span class="text-red-600">*</span></label>
                <input type="email" name="email" required placeholder="admin2@umb.ac.id" class="w-full border border-slate-300 rounded-lg p-2.5 text-slate-900 font-medium">
            </div>

            <div>
                <label class="block font-bold text-slate-800 uppercase mb-1">Kata Sandi (Password) <span class="text-red-600">*</span></label>
                <input type="password" name="password" required placeholder="Minimal 6 karakter" class="w-full border border-slate-300 rounded-lg p-2.5 text-slate-900 font-medium">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block font-bold text-slate-800 uppercase mb-1">NIK Admin</label>
                    <input type="text" name="nik" placeholder="NIK (opsional)" class="w-full border border-slate-300 rounded-lg p-2.5 text-slate-900 font-medium">
                </div>

                <div>
                    <label class="block font-bold text-slate-800 uppercase mb-1">No. WhatsApp</label>
                    <input type="text" name="phone_number" placeholder="0812xxxx" class="w-full border border-slate-300 rounded-lg p-2.5 text-slate-900 font-medium">
                </div>
            </div>

            <div class="pt-3 border-t border-slate-100 flex justify-end space-x-2">
                <button type="button" onclick="document.getElementById('addAdminModal').classList.add('hidden')" class="bg-slate-200 text-slate-800 px-4 py-2 rounded-lg font-bold uppercase">Batal</button>
                <button type="submit" class="bg-[#064E3B] hover:bg-[#047857] text-white px-5 py-2 rounded-lg font-extrabold uppercase">Buat Akun Admin</button>
            </div>
        </form>
    </div>
</div>

<!-- 2. MODAL EDIT USER / ADMIN -->
<div id="editUserModal" class="hidden fixed inset-0 z-50 bg-slate-950/60 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-lg w-full p-6 space-y-4 shadow-2xl border border-slate-200 text-xs">
        <div class="flex justify-between items-center border-b border-slate-200 pb-3">
            <h3 class="font-extrabold text-sm text-slate-900 uppercase">✏️ Edit Data & Peran Akun</h3>
            <button onclick="document.getElementById('editUserModal').classList.add('hidden')" class="text-slate-400 hover:text-red-600 text-xl font-bold">&times;</button>
        </div>

        <form id="editUserForm" method="POST" class="space-y-4">
            @csrf

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block font-bold text-slate-800 uppercase mb-1">Nama Lengkap <span class="text-red-600">*</span></label>
                    <input type="text" id="edit_name" name="name" required class="w-full border border-slate-300 rounded-lg p-2.5 text-slate-900 font-medium">
                </div>

                <div>
                    <label class="block font-bold text-slate-800 uppercase mb-1">Email <span class="text-red-600">*</span></label>
                    <input type="email" id="edit_email" name="email" required class="w-full border border-slate-300 rounded-lg p-2.5 text-slate-900 font-medium">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block font-bold text-slate-800 uppercase mb-1">Peran Akun (Role) <span class="text-red-600">*</span></label>
                    <select id="edit_role" name="role" required class="w-full border border-slate-300 rounded-lg p-2.5 text-slate-900 font-bold bg-white">
                        <option value="user">PEMOHON (USER)</option>
                        <option value="admin">ADMINISTRATOR</option>
                    </select>
                </div>

                <div>
                    <label class="block font-bold text-slate-800 uppercase mb-1">Status Akun <span class="text-red-600">*</span></label>
                    <select id="edit_status" name="status" required class="w-full border border-slate-300 rounded-lg p-2.5 text-slate-900 font-bold bg-white">
                        <option value="approved">APPROVED (DISETUJUI)</option>
                        <option value="pending">PENDING (VERIFIKASI)</option>
                        <option value="rejected">REJECTED (DITOLAK)</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-3">
                <div>
                    <label class="block font-bold text-slate-800 uppercase mb-1">NIK</label>
                    <input type="text" id="edit_nik" name="nik" class="w-full border border-slate-300 rounded-lg p-2 text-slate-900 font-medium">
                </div>
                <div>
                    <label class="block font-bold text-slate-800 uppercase mb-1">NIP</label>
                    <input type="text" id="edit_nip" name="nip" class="w-full border border-slate-300 rounded-lg p-2 text-slate-900 font-medium">
                </div>
                <div>
                    <label class="block font-bold text-slate-800 uppercase mb-1">NIM</label>
                    <input type="text" id="edit_nim" name="nim" class="w-full border border-slate-300 rounded-lg p-2 text-slate-900 font-medium">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block font-bold text-slate-800 uppercase mb-1">Fakultas / Unit</label>
                    <select id="edit_faculty" name="faculty" class="w-full border border-slate-300 rounded-lg p-2 text-slate-900 font-medium bg-white">
                        <option value="">-- Pilih Fakultas --</option>
                        @foreach($faculties as $fac)
                            <option value="{{ $fac->name }}">{{ $fac->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block font-bold text-slate-800 uppercase mb-1">Nomor WhatsApp</label>
                    <input type="text" id="edit_phone_number" name="phone_number" class="w-full border border-slate-300 rounded-lg p-2.5 text-slate-900 font-medium">
                </div>
            </div>

            <div class="pt-3 border-t border-slate-100 flex justify-end space-x-2">
                <button type="button" onclick="document.getElementById('editUserModal').classList.add('hidden')" class="bg-slate-200 text-slate-800 px-4 py-2 rounded-lg font-bold uppercase">Batal</button>
                <button type="submit" class="bg-[#064E3B] hover:bg-[#047857] text-white px-5 py-2 rounded-lg font-extrabold uppercase">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<!-- 3. MODAL RESET PASSWORD AKUN -->
<div id="resetPasswordModal" class="hidden fixed inset-0 z-50 bg-slate-950/60 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-md w-full p-6 space-y-4 shadow-2xl border border-slate-200 text-xs">
        <div class="flex justify-between items-center border-b border-slate-200 pb-3">
            <h3 class="font-extrabold text-sm text-slate-900 uppercase">🔑 Reset Password Akun</h3>
            <button onclick="document.getElementById('resetPasswordModal').classList.add('hidden')" class="text-slate-400 hover:text-red-600 text-xl font-bold">&times;</button>
        </div>

        <form id="resetPasswordForm" method="POST" class="space-y-4">
            @csrf

            <p class="text-slate-600">
                Masukkan kata sandi baru untuk akun <strong id="reset_user_name_label" class="text-slate-900"></strong>:
            </p>

            <div>
                <label class="block font-bold text-slate-800 uppercase mb-1">Password Baru <span class="text-red-600">*</span></label>
                <input type="password" name="password" required minlength="6" placeholder="Minimal 6 karakter" class="w-full border border-slate-300 rounded-lg p-2.5 text-slate-900 font-medium">
            </div>

            <div>
                <label class="block font-bold text-slate-800 uppercase mb-1">Konfirmasi Password Baru <span class="text-red-600">*</span></label>
                <input type="password" name="password_confirmation" required minlength="6" placeholder="Ulangi password baru" class="w-full border border-slate-300 rounded-lg p-2.5 text-slate-900 font-medium">
            </div>

            <div class="pt-3 border-t border-slate-100 flex justify-end space-x-2">
                <button type="button" onclick="document.getElementById('resetPasswordModal').classList.add('hidden')" class="bg-slate-200 text-slate-800 px-4 py-2 rounded-lg font-bold uppercase">Batal</button>
                <button type="submit" class="bg-amber-500 hover:bg-amber-600 text-slate-950 px-5 py-2 rounded-lg font-extrabold uppercase">Reset Password</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openEditModal(user) {
        document.getElementById('edit_name').value = user.name || '';
        document.getElementById('edit_email').value = user.email || '';
        document.getElementById('edit_role').value = user.role || 'user';
        document.getElementById('edit_status').value = user.status || 'pending';
        document.getElementById('edit_nik').value = user.nik || '';
        document.getElementById('edit_nip').value = user.nip || '';
        document.getElementById('edit_nim').value = user.nim || '';
        document.getElementById('edit_faculty').value = user.faculty || '';
        document.getElementById('edit_phone_number').value = user.phone_number || '';
        
        document.getElementById('editUserForm').action = '/admin/manage-users/' + user.id + '/update';
        document.getElementById('editUserModal').classList.remove('hidden');
    }

    function openResetPasswordModal(userId, userName) {
        document.getElementById('reset_user_name_label').innerText = userName;
        document.getElementById('resetPasswordForm').action = '/admin/manage-users/' + userId + '/reset-password';
        document.getElementById('resetPasswordModal').classList.remove('hidden');
    }
</script>
@endsection
