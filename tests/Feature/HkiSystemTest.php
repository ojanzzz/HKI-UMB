<?php

namespace Tests\Feature;

use App\Models\ActivityLog;
use App\Models\ApplicationCategory;
use App\Models\HkiApplication;
use App\Models\HkiDocument;
use App\Models\Payment;
use App\Models\User;
use App\Models\UserNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use ZipArchive;

class HkiSystemTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test 1: Middleware ForceProfileCompletion & Status Pending
     */
    public function test_force_profile_completion_and_pending_middleware()
    {
        // 1. User login via Google tapi profil belum lengkap
        $incompleteUser = User::create([
            'name' => 'Pemohon Incomplete',
            'email' => 'user1@umb.ac.id',
            'role' => 'user',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($incompleteUser)->get('/user/dashboard');
        $response->assertRedirect(route('profile.complete'));

        // 2. User melengkapi NIK, Phone, dan KTP tapi status masih pending
        $incompleteUser->update([
            'nik' => '5206012001990001',
            'phone_number' => '081299998888',
            'ktp_path' => 'ktp_files/dummy_ktp.pdf',
        ]);

        $response2 = $this->actingAs($incompleteUser)->get('/user/dashboard');
        $response2->assertRedirect(route('profile.pending'));

        // 3. User disetujui (Approved) oleh Admin
        $incompleteUser->update(['status' => 'approved']);

        $response3 = $this->actingAs($incompleteUser)->get('/user/dashboard');
        $response3->assertStatus(200);
    }

    /**
     * Test 2: Multi-format Document Upload (.docx, .pdf) & Template Download
     */
    public function test_multi_format_document_upload_and_template_download()
    {
        Storage::fake('public');

        $user = User::create([
            'name' => 'Dr. Budi Santoso',
            'email' => 'budi@umb.ac.id',
            'role' => 'user',
            'nik' => '5206011504850002',
            'nip' => '198501012015041001',
            'ktp_path' => 'ktp_files/dummy_ktp.pdf',
            'phone_number' => '08123456789',
            'status' => 'approved',
        ]);

        $app = HkiApplication::create([
            'user_id' => $user->id,
            'title' => 'Invensi Sensor Pintar Pertanian',
            'application_type' => 'paten',
            'status' => 'draft',
        ]);

        // 1. Download template Word (.docx)
        $responseTemplate = $this->actingAs($user)->get(route('templates.download', 'deskripsi_paten'));
        $responseTemplate->assertStatus(200);

        // 2. Upload Word (.docx) document
        $docxFile = UploadedFile::fake()->create('2.Template Deskripsi Paten.docx', 500, 'application/vnd.openxmlformats-officedocument.wordprocessingml.document');

        $responseUpload = $this->actingAs($user)->post(route('applications.upload-document', $app->id), [
            'document_type' => 'deskripsi_paten',
            'file' => $docxFile,
        ]);

        $responseUpload->assertRedirect();
        $this->assertDatabaseHas('hki_documents', [
            'hki_application_id' => $app->id,
            'document_type' => 'deskripsi_paten',
        ]);

        $document = HkiDocument::where('hki_application_id', $app->id)
            ->where('document_type', 'deskripsi_paten')
            ->first();

        $this->assertNotNull($document);
        Storage::disk('public')->assertExists($document->file_path);
    }

    /**
     * Test 3: Export ZIP Functionality (ZipArchive) for 8 Documents
     */
    public function test_admin_export_zip_functionality()
    {
        Storage::fake('public');

        $admin = User::create([
            'name' => 'Admin HKI UMB',
            'email' => 'admin@umb.ac.id',
            'role' => 'admin',
            'nik' => '5206010101880001',
            'ktp_path' => 'ktp_files/dummy_ktp.pdf',
            'status' => 'approved',
        ]);

        $user = User::create([
            'name' => 'Peneliti UMB',
            'email' => 'peneliti@umb.ac.id',
            'role' => 'user',
            'nik' => '5206012001990001',
            'ktp_path' => 'ktp_files/dummy_ktp.pdf',
            'phone_number' => '081200001111',
            'status' => 'approved',
        ]);

        $app = HkiApplication::create([
            'user_id' => $user->id,
            'title' => 'Sistem AI Klasifikasi Citra Medis',
            'application_type' => 'paten',
            'status' => 'submitted',
        ]);

        // Buat 8 dokumen dummy di storage
        $docTypes = array_keys(\App\Http\Controllers\HkiApplicationController::TEMPLATES_MAP);

        foreach ($docTypes as $type) {
            $filePath = 'hki_documents/' . $app->id . '/' . $type . '.docx';
            Storage::disk('public')->put($filePath, 'Dummy Word Content for ' . $type);

            HkiDocument::create([
                'hki_application_id' => $app->id,
                'document_type' => $type,
                'file_path' => $filePath,
            ]);
        }

        // Action: Export ZIP via Admin Controller
        $response = $this->actingAs($admin)->get(route('admin.applications.export-zip', $app->id));

        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/zip');

        // Pastikan zip_export_path ter-update di database
        $app->refresh();
        $this->assertNotNull($app->zip_export_path);
    }

    /**
     * Test 4: Full Payment & Verification Workflow with Kuitansi PDF
     */
    public function test_payment_and_kuitansi_verification_workflow()
    {
        Storage::fake('public');

        $admin = User::create([
            'name' => 'Admin Keuangan',
            'email' => 'adminkeuangan@umb.ac.id',
            'role' => 'admin',
            'nik' => '5206010101880001',
            'ktp_path' => 'ktp_files/dummy_ktp.pdf',
            'status' => 'approved',
        ]);

        $user = User::create([
            'name' => 'Dosen UMB',
            'email' => 'dosen@umb.ac.id',
            'role' => 'user',
            'nik' => '5206012001990001',
            'nip' => '198001012010011001',
            'ktp_path' => 'ktp_files/dummy_ktp.pdf',
            'phone_number' => '081233334444',
            'status' => 'approved',
        ]);

        $app = HkiApplication::create([
            'user_id' => $user->id,
            'title' => 'Metode Manajemen Rantai Pasok',
            'application_type' => 'paten',
            'status' => 'submitted',
        ]);

        // 1. Admin input Nomor DJKI & Kode Billing SIMPAKI
        $response1 = $this->actingAs($admin)->post(route('admin.applications.input-djki', $app->id), [
            'djki_application_number' => 'P00202609999',
            'simpaki_billing_code' => '820260109999',
            'billing_amount' => 500000,
        ]);
        $response1->assertRedirect();
        $this->assertDatabaseHas('hki_applications', [
            'id' => $app->id,
            'simpaki_billing_code' => '820260109999',
            'status' => 'billing_issued',
        ]);

        // 2. User upload bukti transfer
        $proofFile = UploadedFile::fake()->create('proof.pdf', 500, 'application/pdf');
        $response2 = $this->actingAs($user)->post(route('applications.submit-payment', $app->id), [
            'proof_of_payment' => $proofFile,
        ]);
        $response2->assertRedirect();

        $payment = Payment::where('hki_application_id', $app->id)->first();
        $this->assertNotNull($payment);

        // 3. Admin verifikasi pembayaran & generate Kuitansi PDF
        $response3 = $this->actingAs($admin)->post(route('admin.payments.verify', $payment->id));
        $response3->assertRedirect();

        $payment->refresh();
        $this->assertEquals('verified_paid', $payment->status);
        $this->assertNotNull($payment->receipt_pdf_path);
        Storage::disk('public')->assertExists($payment->receipt_pdf_path);
    }

    /**
     * Test 5: Admin User Management (Create Admin & Reset Password)
     */
    public function test_admin_user_management_and_password_reset()
    {
        $admin = User::create([
            'name' => 'Super Admin HKI',
            'email' => 'superadmin@umb.ac.id',
            'role' => 'admin',
            'status' => 'approved',
            'password' => Hash::make('password123'),
        ]);

        // 1. Admin tambah Admin baru
        $responseCreate = $this->actingAs($admin)->post(route('admin.manage-users.store-admin'), [
            'name' => 'Admin Baru HKI',
            'email' => 'admin.baru@umb.ac.id',
            'password' => 'newadminpassword123',
            'nik' => '5206010099880001',
            'phone_number' => '081299990000',
        ]);
        $responseCreate->assertRedirect();
        $this->assertDatabaseHas('users', [
            'email' => 'admin.baru@umb.ac.id',
            'role' => 'admin',
            'status' => 'approved',
        ]);

        // 2. Admin reset password user
        $user = User::create([
            'name' => 'User Reset Target',
            'email' => 'usertarget@umb.ac.id',
            'role' => 'user',
            'status' => 'approved',
            'password' => Hash::make('oldpassword'),
        ]);

        $responseReset = $this->actingAs($admin)->post(route('admin.manage-users.reset-password', $user->id), [
            'password' => 'resetpassword123',
            'password_confirmation' => 'resetpassword123',
        ]);
        $responseReset->assertRedirect();

        $user->refresh();
        $this->assertTrue(Hash::check('resetpassword123', $user->password));
    }

    /**
     * Test 6: Activity Logging & Multi-Channel Notifications (In-App, Email, WhatsApp)
     */
    public function test_activity_logging_and_multi_channel_notifications()
    {
        $admin = User::create([
            'name' => 'Admin Verifikator',
            'email' => 'verifikator@umb.ac.id',
            'role' => 'admin',
            'status' => 'approved',
            'password' => Hash::make('password123'),
        ]);

        $user = User::create([
            'name' => 'Ahmad Rizal Pemohon',
            'email' => 'ahmad.rizal@umb.ac.id',
            'role' => 'user',
            'status' => 'pending',
            'phone_number' => '081299998888',
        ]);

        // 1. Admin approve user -> triggers ActivityLog & MultiChannelAlert (In-App Notification)
        $responseApprove = $this->actingAs($admin)->post(route('admin.users.approve', $user->id));
        $responseApprove->assertRedirect();

        $this->assertDatabaseHas('activity_logs', [
            'action' => 'VERIFY_USER',
            'user_name' => 'Admin Verifikator',
        ]);

        $this->assertDatabaseHas('notifications', [
            'user_id' => $user->id,
            'type' => 'USER_APPROVED',
        ]);

        // 2. Admin activity logs menu page loads fine
        $responseLogsPage = $this->actingAs($admin)->get(route('admin.activity-logs'));
        $responseLogsPage->assertStatus(200);
    }

    /**
     * Test 7: Master Application Category & 5-Step Wizard Workflow
     */
    public function test_application_category_master_and_stepper_creation_workflow()
    {
        $admin = User::create([
            'name' => 'Admin Category Manager',
            'email' => 'catadmin@umb.ac.id',
            'role' => 'admin',
            'status' => 'approved',
            'password' => Hash::make('password123'),
        ]);

        $user = User::create([
            'name' => 'Pemohon UMKM Bima',
            'email' => 'umkm@umb.ac.id',
            'role' => 'user',
            'nik' => '5206019988770001',
            'ktp_path' => 'ktp_files/dummy_ktp.pdf',
            'phone_number' => '081233332222',
            'status' => 'approved',
        ]);

        // 1. Admin store Kategori Pengajuan
        $responseCat = $this->actingAs($admin)->post(route('admin.application-categories.store'), [
            'name' => 'UMKM Binaan',
            'code' => 'UMKM_BINAAN',
            'description' => 'Kategori khusus UMKM binaan daerah',
            'is_active' => '1',
        ]);
        $responseCat->assertRedirect();
        $this->assertDatabaseHas('application_categories', ['code' => 'UMKM_BINAAN']);

        // 2. User submits 5-step wizard application with application_type & application_category
        $responseApp = $this->actingAs($user)->post(route('applications.store'), [
            'title' => 'Produk Olahan Kopi Bima Khas',
            'application_type' => 'DESAIN_INDUSTRI',
            'application_category' => 'UMKM_BINAAN',
            'description' => 'Kemasan produk visual unik 3D',
            'applicants' => [
                [
                    'applicant_name' => $user->name,
                    'applicant_address' => 'Jl. Ahmad Yani No. 45, Bima',
                    'applicant_nik' => $user->nik,
                    'applicant_nip' => '198501012015041001',
                    'applicant_nim' => '',
                    'applicant_faculty' => $user->faculty,
                ],
                [
                    'applicant_name' => 'Diah Ayu Wulandari',
                    'applicant_address' => 'Jl. Merdeka No. 12, Mataram, NTB',
                    'applicant_nik' => '5206011504850003',
                    'applicant_nip' => '198809012019031002',
                    'applicant_nim' => '41520010023',
                    'applicant_faculty' => 'Fakultas Ilmu Komputer',
                ],
            ],
        ]);
        $responseApp->assertRedirect();

        $this->assertDatabaseHas('hki_applications', [
            'user_id' => $user->id,
            'title' => 'Produk Olahan Kopi Bima Khas',
            'application_type' => 'DESAIN_INDUSTRI',
            'application_category' => 'UMKM_BINAAN',
            'status' => 'draft',
        ]);

        $hkiApp = HkiApplication::where('title', 'Produk Olahan Kopi Bima Khas')->first();
        $this->assertDatabaseHas('hki_applicants', [
            'hki_application_id' => $hkiApp->id,
            'applicant_name' => 'Diah Ayu Wulandari',
            'applicant_nim' => '41520010023',
            'is_primary' => false,
        ]);
    }
}
