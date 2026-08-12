<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\HkiApplicant;
use App\Models\HkiApplication;
use App\Models\HkiDocument;
use App\Models\Payment;
use App\Services\MultiChannelAlertService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class HkiApplicationController extends Controller
{
    /**
     * Map tipe dokumen ke nama file template Word (.docx).
     */
    public const TEMPLATES_MAP = [
        'data_dukung' => ['file' => '0. Data dukung.docx', 'label' => '0. Data Dukung'],
        'daftar_inventor' => ['file' => '1. Template daftar inventor.docx', 'label' => '1. Daftar Inventor'],
        'deskripsi_paten' => ['file' => '2. Template Deskripsi Paten.docx', 'label' => '2. Deskripsi Paten'],
        'abstrak' => ['file' => '3. Template abstrak.docx', 'label' => '3. Abstrak Invensi'],
        'klaim' => ['file' => '4. Template klaim.docx', 'label' => '4. Klaim Invensi'],
        'gambar_invensi' => ['file' => '5. Template Gambar Invensi.docx', 'label' => '5. Gambar Invensi'],
        'pernyataan_pengalihan_hak' => ['file' => '6. Surat Pernyataan Pengalihan Hak.docx', 'label' => '6. Surat Pernyataan Pengalihan Hak'],
        'pernyataan_kepemilikan' => ['file' => '7. Template Surat Pernyataan Kepemilikan.docx', 'label' => '7. Surat Pernyataan Kepemilikan'],
    ];

    /**
     * Dashboard Pengajuan User.
     */
    public function index()
    {
        $applications = HkiApplication::where('user_id', Auth::id())
            ->with(['documents', 'payments', 'applicants'])
            ->latest()
            ->get();

        return view('user.dashboard', compact('applications'));
    }

    /**
     * Form Buat Pengajuan HKI Baru.
     */
    public function create()
    {
        return view('user.applications.create');
    }

    /**
     * Simpan Permohonan HKI awal & Foto Produk Invensi.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'application_type' => 'required|string',
            'application_category' => 'nullable|string',
            'description' => 'nullable|string',
            'product_image' => 'nullable|image|mimes:jpg,jpeg,png|max:5000',
            'applicants' => 'required|array|min:1',
            'applicants.*.applicant_name' => 'required|string|max:255',
            'applicants.*.applicant_address' => 'required|string',
            'applicants.*.applicant_nik' => 'required|string|max:30',
            'applicants.*.applicant_nip' => 'nullable|string|max:50',
            'applicants.*.applicant_nim' => 'nullable|string|max:30',
            'applicants.*.applicant_faculty' => 'nullable|string|max:255',
        ]);

        $productImagePath = null;
        if ($request->hasFile('product_image')) {
            $productImagePath = $request->file('product_image')->store('product_images', 'public');
        }

        $primary = $request->applicants[0];

        $application = HkiApplication::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'application_type' => $request->application_type,
            'application_category' => $request->application_category,
            'description' => $request->description,
            'product_image_path' => $productImagePath,
            'applicant_name' => $primary['applicant_name'],
            'applicant_address' => $primary['applicant_address'],
            'applicant_nik' => $primary['applicant_nik'],
            'applicant_nip' => $primary['applicant_nip'],
            'applicant_nim' => $primary['applicant_nim'],
            'applicant_faculty' => $primary['applicant_faculty'],
            'status' => 'draft',
        ]);

        foreach ($request->applicants as $index => $applicant) {
            HkiApplicant::create([
                'hki_application_id' => $application->id,
                'applicant_name' => $applicant['applicant_name'],
                'applicant_address' => $applicant['applicant_address'],
                'applicant_nik' => $applicant['applicant_nik'],
                'applicant_nip' => $applicant['applicant_nip'],
                'applicant_nim' => $applicant['applicant_nim'],
                'applicant_faculty' => $applicant['applicant_faculty'],
                'is_primary' => $index === 0,
            ]);
        }

        ActivityLog::log('CREATE_APPLICATION', "Pengguna membuat permohonan HKI baru (#{$application->id}: {$application->title}).");

        MultiChannelAlertService::notifyAdmins(
            'APPLICATION_SUBMITTED',
            'Permohonan HKI Baru Dibuat',
            "Pengguna " . Auth::user()->name . " telah membuat permohonan HKI baru (#{$application->id}: {$application->title}).",
            route('admin.applications.show', $application->id)
        );

        return redirect()->route('applications.show', $application->id)
            ->with('success', 'Permohonan HKI berhasil dibuat. Silakan unduh template formulir dan unggah dokumen Anda.');
    }

    /**
     * Detail Pengajuan & Antarmuka Unggah Dokumen & Foto Produk.
     */
    public function show(HkiApplication $application)
    {
        $this->authorizeUser($application);
        $application->load(['documents', 'payments', 'applicants']);

        $documentsMap = $application->documents->keyBy('document_type');
        $templatesMap = self::TEMPLATES_MAP;

        return view('user.applications.show', compact('application', 'documentsMap', 'templatesMap'));
    }

    /**
     * Halaman Detail Ajuan Publik (tanpa popup modal).
     */
    public function publicShow(HkiApplication $application)
    {
        $application->load(['user', 'applicants']);

        return view('public.application-detail', compact('application'));
    }

    /**
     * Unggah / Update Foto Produk Invensi HKI.
     */
    public function updateProductImage(Request $request, HkiApplication $application)
    {
        $this->authorizeUser($application);

        $request->validate([
            'product_image' => 'required|image|mimes:jpg,jpeg,png|max:5000',
        ]);

        if ($application->product_image_path && Storage::disk('public')->exists($application->product_image_path)) {
            Storage::disk('public')->delete($application->product_image_path);
        }

        $imagePath = $request->file('product_image')->store('product_images', 'public');
        $application->update(['product_image_path' => $imagePath]);

        ActivityLog::log('UPDATE_PRODUCT_IMAGE', "Pengguna mengunggah/memperbarui foto produk untuk permohonan #{$application->id}.");

        return redirect()->back()->with('success', 'Foto produk invensi berhasil diperbarui!');
    }

    /**
     * ALUR SEDERHANA: Upload Dokumen (Format Fleksibel: PDF, DOC, DOCX, PNG, JPG, ZIP).
     */
    public function uploadDocument(Request $request, HkiApplication $application)
    {
        $this->authorizeUser($application);

        $request->validate([
            'document_type' => 'required|string|in:' . implode(',', array_keys(self::TEMPLATES_MAP)),
            'file' => 'required|file|mimes:pdf,doc,docx,png,jpg,jpeg,zip,rar|max:15360', // Max 15MB
        ]);

        $docType = $request->document_type;
        $uploadedFile = $request->file('file');
        $originalName = $uploadedFile->getClientOriginalName();

        // Simpan File ke Storage Public
        $path = $uploadedFile->storeAs(
            'hki_documents/' . $application->id,
            $docType . '_' . time() . '.' . $uploadedFile->getClientOriginalExtension(),
            'public'
        );

        // Update / Save Database Record
        HkiDocument::updateOrCreate(
            [
                'hki_application_id' => $application->id,
                'document_type' => $docType,
            ],
            [
                'file_path' => $path,
                'form_data' => ['original_name' => $originalName],
                'is_emeterai' => false,
            ]
        );

        ActivityLog::log('UPLOAD_DOCUMENT', "Pengguna mengunggah dokumen '{$docType}' ({$originalName}) pada permohonan #{$application->id}.");

        $this->checkAndUpdateStatus($application);

        return redirect()->back()->with('success', 'Dokumen (' . $originalName . ') berhasil diunggah!');
    }

    /**
     * Unduh Template Formulir Word (.docx) untuk Dokumen Paten / HKI.
     */
    public function downloadTemplate($docType)
    {
        if (!array_key_exists($docType, self::TEMPLATES_MAP)) {
            abort(404, 'Template dokumen tidak ditemukan.');
        }

        $templateInfo = self::TEMPLATES_MAP[$docType];
        $filename = $templateInfo['file'];
        $templatePath = Storage::disk('public')->path('templates/' . $filename);

        if (!file_exists($templatePath)) {
            Storage::disk('public')->makeDirectory('templates');
            file_put_contents($templatePath, "FORMULIR TEMPLATE OFFICIAL HKI UM BIMA\nJENIS DOKUMEN: " . $templateInfo['label'] . "\n\nSilakan isi data invensi/permohonan Anda dan unggah kembali file ini ke portal HKI UM BIMA.");
        }

        return response()->download($templatePath, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        ]);
    }

    /**
     * Submit Pembayaran oleh User setelah Admin menerbitkan Kode Billing SIMPAKI.
     */
    public function submitPayment(Request $request, HkiApplication $application)
    {
        $this->authorizeUser($application);

        $request->validate([
            'proof_of_payment' => 'required|file|mimes:jpg,jpeg,png,pdf,doc,docx,zip|max:10240',
        ]);

        if (!$application->simpaki_billing_code || !$application->billing_amount) {
            return redirect()->back()->with('error', 'Tagihan SIMPAKI belum diterbitkan oleh Admin.');
        }

        $proofPath = $request->file('proof_of_payment')->store('payments/' . $application->id, 'public');

        Payment::create([
            'hki_application_id' => $application->id,
            'user_id' => Auth::id(),
            'simpaki_code' => $application->simpaki_billing_code,
            'amount' => $application->billing_amount,
            'proof_of_payment' => $proofPath,
            'status' => 'pending',
        ]);

        $application->update(['status' => 'payment_pending']);

        ActivityLog::log('SUBMIT_PAYMENT', "Pengguna mengunggah bukti pembayaran SIMPAKI untuk permohonan #{$application->id}.");

        MultiChannelAlertService::notifyAdmins(
            'PAYMENT_SUBMITTED',
            'Bukti Pembayaran SIMPAKI Diunggah',
            "Pengguna " . Auth::user()->name . " telah mengunggah bukti transfer pembayaran SIMPAKI untuk permohonan #{$application->id}.",
            route('admin.applications.show', $application->id)
        );

        return redirect()->back()->with('success', 'Bukti pembayaran berhasil diunggah! Menunggu verifikasi Admin.');
    }

    private function authorizeUser(HkiApplication $application)
    {
        if (Auth::user()->role !== 'admin' && $application->user_id !== Auth::id()) {
            abort(403, 'Akses tidak diizinkan.');
        }
    }

    private function checkAndUpdateStatus(HkiApplication $application)
    {
        $count = HkiDocument::where('hki_application_id', $application->id)->count();
        if ($count >= 8 && $application->status === 'draft') {
            $application->update(['status' => 'submitted']);
            MultiChannelAlertService::notifyAdmins(
                'ALL_DOCUMENTS_UPLOADED',
                '8 Dokumen HKI Lengkap',
                "Permohonan #{$application->id} ('{$application->title}') telah melengkapi seluruh 8 dokumen. Siap di-review dan di-export.",
                route('admin.applications.show', $application->id)
            );
        }
    }
}
