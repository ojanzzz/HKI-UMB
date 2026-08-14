<?php

namespace Database\Seeders;

use App\Models\Faculty;
use App\Models\HkiApplicant;
use App\Models\HkiApplication;
use App\Models\HkiDocument;
use App\Models\Payment;
use App\Models\Popup;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use ZipArchive;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Clear Storage
        Storage::disk('public')->deleteDirectory('hki_documents');
        Storage::disk('public')->deleteDirectory('payments');
        Storage::disk('public')->deleteDirectory('receipts');
        Storage::disk('public')->deleteDirectory('zips');
        Storage::disk('public')->deleteDirectory('popups');
        Storage::disk('public')->deleteDirectory('ktp_files');

        // Create sample KTP file in storage
        Storage::disk('public')->put('ktp_files/sample_ktp.pdf', '%PDF-1.4 Dummy KTP File Content');

        // 2. Create Master Faculties / Unit Kerja
        $faculties = [
            ['name' => 'Fakultas Teknik', 'code' => 'FT', 'description' => 'Fakultas Teknik Universitas Muhammadiyah Bima'],
            ['name' => 'Fakultas Ilmu Komputer', 'code' => 'FIK', 'description' => 'Fakultas Ilmu Komputer & Informatika'],
            ['name' => 'Fakultas Ekonomi & Bisnis', 'code' => 'FEB', 'description' => 'Fakultas Ekonomi, Bisnis & Manajemen'],
            ['name' => 'Fakultas Hukum', 'code' => 'FH', 'description' => 'Fakultas Hukum & Pelindungan HKI'],
            ['name' => 'Fakultas Keguruan & Ilmu Pendidikan', 'code' => 'FKIP', 'description' => 'Fakultas Keguruan & Pendidikan Sains'],
            ['name' => 'Lembaga Penelitian & Pengabdian Masyarakat (LPPM)', 'code' => 'LPPM', 'description' => 'Lembaga Riset & Sentra HKI Terpadu'],
        ];

        foreach ($faculties as $fac) {
            Faculty::firstOrCreate(['name' => $fac['name']], $fac);
        }

        // 2b. Create Master Tipe Permohonan HKI
        $appTypes = [
            ['name' => 'Paten', 'code' => 'PATEN', 'description' => 'Invensi di bidang teknologi yang baru dan dapat diterapkan dalam industri.'],
            ['name' => 'Paten Sederhana', 'code' => 'PATEN_SEDERHANA', 'description' => 'Pengembangan inovasi atau produk/alat praktis baru.'],
            ['name' => 'Hak Cipta', 'code' => 'HAK_CIPTA', 'description' => 'Karya cipta ilmu pengetahuan, seni, sastra, program komputer, dan publikasi.'],
            ['name' => 'Merek', 'code' => 'MEREK', 'description' => 'Tanda nama, logo, atau simbol usaha/layanan.'],
            ['name' => 'Desain Industri', 'code' => 'DESAIN_INDUSTRI', 'description' => 'Kreasi bentuk, konfigurasi, atau komposisi garis/warna 3D atau 2D.'],
            ['name' => 'Rahasia Dagang', 'code' => 'RAHASIA_DAGANG', 'description' => 'Informasi teknologi/bisnis yang bersifat rahasia dan bernilai ekonomi.'],
            ['name' => 'Indikasi Geografis', 'code' => 'INDIKASI_GEOGRAFIS', 'description' => 'Tanda khas daerah asal produk/hasil alam lokal.'],
        ];

        foreach ($appTypes as $type) {
            \App\Models\ApplicationType::firstOrCreate(['code' => $type['code']], $type);
        }

        // 2c. Create Master Kategori Pengajuan HKI
        $appCategories = [
            ['name' => 'UMKM', 'code' => 'UMKM', 'description' => 'Usaha Mikro, Kecil, dan Menengah binaan.'],
            ['name' => 'Perguruan Tinggi', 'code' => 'PERGURUAN_TINGGI', 'description' => 'Dosen, peneliti, dan mahasiswa Universitas Muhammadiyah Bima.'],
            ['name' => 'Umum', 'code' => 'UMUM', 'description' => 'Masyarakat umum / perorangan non-akademisi.'],
            ['name' => 'Lembaga Litbang', 'code' => 'LITBANG', 'description' => 'Lembaga penelitian dan pengembangan industri.'],
        ];

        foreach ($appCategories as $cat) {
            \App\Models\ApplicationCategory::firstOrCreate(['code' => $cat['code']], $cat);
        }

        // 3. Create Users
        $admin = User::create([
            'name' => 'Administrator Direktorat Inovasi & KI UM Bima',
            'email' => 'admin@umb.ac.id',
            'role' => 'admin',
            'nik' => '5206010101880001',
            'nip' => '198809012019031002',
            'nim' => null,
            'ktp_path' => 'ktp_files/sample_ktp.pdf',
            'identity_number' => '5206010101880001',
            'faculty' => 'Lembaga Penelitian & Pengabdian Masyarakat (LPPM)',
            'phone_number' => '08111222333',
            'status' => 'approved',
            'password' => Hash::make('password123'),
        ]);

        $approvedUser = User::create([
            'name' => 'Dr. Ir. Budi Santoso, M.T.',
            'email' => 'budi.santoso@umb.ac.id',
            'role' => 'user',
            'nik' => '5206011504850002',
            'nip' => '198501012015041001',
            'nim' => null,
            'ktp_path' => 'ktp_files/sample_ktp.pdf',
            'identity_number' => '5206011504850002',
            'faculty' => 'Fakultas Teknik',
            'phone_number' => '081234567890',
            'status' => 'approved',
            'password' => Hash::make('password123'),
        ]);

        $pendingUser = User::create([
            'name' => 'Ahmad Rizal, S.Kom.',
            'email' => 'ahmad.rizal@umb.ac.id',
            'role' => 'user',
            'nik' => '5206012001990003',
            'nip' => null,
            'nim' => '41520010099',
            'ktp_path' => 'ktp_files/sample_ktp.pdf',
            'identity_number' => '5206012001990003',
            'faculty' => 'Fakultas Ilmu Komputer',
            'phone_number' => '081299998888',
            'status' => 'pending',
            'password' => Hash::make('password123'),
        ]);

        // 4. Create Welcome Popups
        Popup::create([
            'title' => 'Pembukaan Skema Inovasi & Paten UM BIMA Tahun 2026',
            'content' => "Selamat datang di Sistem Informasi HKI UM BIMA.\n\nSentra HKI UM BIMA membuka pendampingan pendaftaran Paten terintegrasi DJKI Kemenkumham RI secara gratis untuk seluruh Dosen dan Mahasiswa UM BIMA.",
            'is_active' => true,
        ]);

        // 5. Create Sample HKI Application
        $app = HkiApplication::create([
            'user_id' => $approvedUser->id,
            'title' => 'Sistem Sensor IOT Pengolahan Air Pintar Berbasis Deep Learning',
            'application_type' => 'paten',
            'status' => 'submitted_to_djki',
            'djki_application_number' => 'P00202600123',
            'simpaki_billing_code' => '820260801001',
            'billing_amount' => 500000.00,
            'applicant_name' => $approvedUser->name,
            'applicant_address' => 'Jl. Merdeka No. 1, Bima, Nusa Tenggara Barat 84138',
            'applicant_nik' => $approvedUser->nik,
            'applicant_nip' => $approvedUser->nip,
            'applicant_nim' => $approvedUser->nim,
            'applicant_faculty' => $approvedUser->faculty,
        ]);

        // 6. Generate 8 Mandatory Documents (PDFs)
        $docTypes = array_keys(\App\Http\Controllers\HkiApplicationController::TEMPLATES_MAP);

        foreach ($docTypes as $type) {
            $filename = 'hki_documents/' . $app->id . '/' . $type . '.docx';
            Storage::disk('public')->put($filename, 'Sample Word Document for ' . $type);

            HkiDocument::create([
                'hki_application_id' => $app->id,
                'document_type' => $type,
                'file_path' => $filename,
                'is_emeterai' => false,
                'form_data' => [
                    'original_name' => $type . '.docx',
                ],
            ]);
        }

        // 7. Generate ZIP Export Archive (ZipArchive)
        $disk = Storage::disk('public');
        $disk->makeDirectory('zips');
        $zipFileName = 'DJKI_HKI_App_' . $app->id . '_sample.zip';
        $zipFilePath = $disk->path('zips/' . $zipFileName);

        $zip = new ZipArchive();
        if ($zip->open($zipFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
            foreach ($app->documents as $doc) {
                $fileStoragePath = $disk->path($doc->file_path);
                if (file_exists($fileStoragePath)) {
                    $zip->addFile($fileStoragePath, strtoupper($doc->document_type) . '.docx');
                }
            }
            $zip->close();
        }

        $app->update(['zip_export_path' => 'zips/' . $zipFileName]);

        // Create sample hki_applicants for the sample application
        HkiApplicant::create([
            'hki_application_id' => $app->id,
            'applicant_name' => $approvedUser->name,
            'applicant_address' => 'Jl. Merdeka No. 1, Bima, Nusa Tenggara Barat 84138',
            'applicant_nik' => $approvedUser->nik,
            'applicant_nip' => $approvedUser->nip,
            'applicant_nim' => $approvedUser->nim,
            'applicant_faculty' => $approvedUser->faculty,
            'is_primary' => true,
        ]);

        HkiApplicant::create([
            'hki_application_id' => $app->id,
            'applicant_name' => 'Diah Ayu Wulandari',
            'applicant_address' => 'Jl. Merdeka No. 12, Mataram, NTB',
            'applicant_nik' => '5206011504850003',
            'applicant_nip' => '198809012019031002',
            'applicant_nim' => '41520010023',
            'applicant_faculty' => 'Fakultas Ilmu Komputer',
            'is_primary' => false,
        ]);

        // 8. Create Payment Proof & Generate Kuitansi PDF
        $proofPath = 'payments/' . $app->id . '/proof_transfer_sample.pdf';
        $sampleProofPdf = Pdf::loadHTML('<h3>Resi Transfer Pembayaran SIMPAKI DJKI</h3><p>Bank Mandiri - Rp 500.000</p>');
        Storage::disk('public')->put($proofPath, $sampleProofPdf->output());

        $payment = Payment::create([
            'hki_application_id' => $app->id,
            'user_id' => $approvedUser->id,
            'simpaki_code' => $app->simpaki_billing_code,
            'amount' => $app->billing_amount,
            'proof_of_payment' => $proofPath,
            'status' => 'verified_paid',
            'verified_at' => now(),
        ]);

        // Generate Kuitansi PDF
        $kuitansiPdf = Pdf::loadView('pdf.kuitansi', [
            'payment' => $payment,
            'application' => $app,
            'user' => $approvedUser,
        ]);
        $receiptPath = 'receipts/Kuitansi_' . $payment->id . '_sample.pdf';
        Storage::disk('public')->put($receiptPath, $kuitansiPdf->output());

        $payment->update(['receipt_pdf_path' => $receiptPath]);
    }
}
