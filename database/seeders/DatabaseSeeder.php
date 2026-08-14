<?php

namespace Database\Seeders;

use App\Models\Popup;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Akun Admin Direktorat Inovasi & KI UM Bima
        User::create([
            'name' => 'Administrator Direktorat Inovasi & KI UM Bima',
            'email' => 'admin@umb.ac.id',
            'role' => 'admin',
            'identity_number' => '198809012019031002',
            'faculty' => 'Direktorat Inovasi & KI UM Bima',
            'phone_number' => '08111222333',
            'status' => 'approved',
            'password' => Hash::make('password123'),
        ]);

        // 2. Akun User (Pemohon HKI - Approved)
        User::create([
            'name' => 'Dr. Ir. Budi Santoso, M.T.',
            'email' => 'budi.santoso@umb.ac.id',
            'role' => 'user',
            'identity_number' => '198501012015041001',
            'faculty' => 'Fakultas Teknik',
            'phone_number' => '081234567890',
            'status' => 'approved',
            'password' => Hash::make('password123'),
        ]);

        // 3. Akun User (Pemohon Baru - Pending Approval)
        User::create([
            'name' => 'Ahmad Rizal, S.Kom.',
            'email' => 'ahmad.rizal@umb.ac.id',
            'role' => 'user',
            'identity_number' => '41520010099',
            'faculty' => 'Fakultas Ilmu Komputer',
            'phone_number' => '081299998888',
            'status' => 'pending',
            'password' => Hash::make('password123'),
        ]);

        // 4. Sample Welcome Popup
        Popup::create([
            'title' => 'Pembukaan Skema Inovasi & Paten UMB Tahun 2026',
            'content' => "Selamat datang di Sistem Informasi HKI Universitas Mercu Buana.\n\nSentra HKI UMB membuka pendampingan pendaftaran Paten terintegrasi DJKI Kemenkumham RI secara gratis untuk seluruh Dosen dan Mahasiswa UMB.",
            'is_active' => true,
        ]);
    }
}
