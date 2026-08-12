<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\ApplicationCategory;
use App\Models\ApplicationType;
use App\Models\Faculty;
use App\Models\HkiApplication;
use App\Models\HkiDocument;
use App\Models\Payment;
use App\Models\Popup;
use App\Models\Slider;
use App\Models\User;
use App\Services\MultiChannelAlertService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use ZipArchive;

class AdminHkiController extends Controller
{
    /**
     * Dashboard Admin.
     */
    public function dashboard()
    {
        $pendingUsersCount = User::where('role', 'user')->where('status', 'pending')->count();
        $totalApplicationsCount = HkiApplication::count();
        $pendingPaymentCount = Payment::where('status', 'pending')->count();
        $recentApplications = HkiApplication::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'pendingUsersCount',
            'totalApplicationsCount',
            'pendingPaymentCount',
            'recentApplications'
        ));
    }

    // ==========================================
    // MASTER KATEGORI PENGAJUAN (UMKM, PERGURUAN TINGGI, UMUM, LITBANG)
    // ==========================================
    public function applicationCategoriesIndex()
    {
        $categories = ApplicationCategory::latest()->get();
        return view('admin.application_categories.index', compact('categories'));
    }

    public function storeApplicationCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:application_categories,code',
            'description' => 'nullable|string',
        ]);

        ApplicationCategory::create([
            'name' => $request->name,
            'code' => strtoupper($request->code),
            'description' => $request->description,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->back()->with('success', 'Kategori Pengajuan HKI berhasil ditambahkan.');
    }

    public function updateApplicationCategory(Request $request, ApplicationCategory $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:application_categories,code,' . $category->id,
            'description' => 'nullable|string',
        ]);

        $category->update([
            'name' => $request->name,
            'code' => strtoupper($request->code),
            'description' => $request->description,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->back()->with('success', 'Kategori Pengajuan HKI berhasil diperbarui.');
    }

    public function deleteApplicationCategory(ApplicationCategory $category)
    {
        $category->delete();
        return redirect()->back()->with('success', 'Kategori Pengajuan HKI berhasil dihapus.');
    }

    // ==========================================
    // ACTIVITY LOGS SYSTEM (PERSYARATAN 1)
    // ==========================================
    public function activityLogsIndex(Request $request)
    {
        $query = ActivityLog::query();

        if ($request->filled('action')) {
            $query->where('action', strtoupper($request->action));
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('user_name', 'like', "%{$search}%")
                  ->orWhere('user_email', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('ip_address', 'like', "%{$search}%");
            });
        }

        $logs = $query->latest()->paginate(25)->withQueryString();

        return view('admin.activity_logs.index', compact('logs'));
    }

    // ==========================================
    // MANAJEMEN USER & TAMBAH ADMIN (RESET PASSWORD, EDIT DATA, ROLE, DELETE)
    // ==========================================
    public function manageUsersIndex(Request $request)
    {
        $query = User::query();

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%")
                  ->orWhere('nip', 'like', "%{$search}%")
                  ->orWhere('nim', 'like', "%{$search}%");
            });
        }

        $users = $query->latest()->paginate(15)->withQueryString();
        $faculties = Faculty::orderBy('name')->get();

        return view('admin.manage_users.index', compact('users', 'faculties'));
    }

    public function storeAdmin(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:6',
            'nik' => 'nullable|string|max:30',
            'phone_number' => 'nullable|string|max:30',
            'faculty' => 'nullable|string|max:255',
        ]);

        $newAdmin = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin',
            'status' => 'approved',
            'nik' => $request->nik,
            'identity_number' => $request->nik,
            'phone_number' => $request->phone_number,
            'faculty' => $request->faculty,
        ]);

        ActivityLog::log('CREATE_ADMIN', "Admin " . Auth::user()->name . " menambahkan administrator baru ({$newAdmin->email}).");

        return redirect()->back()->with('success', 'Akun Administrator baru (' . $request->name . ') berhasil dibuat!');
    }

    public function updateUser(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,user',
            'status' => 'required|in:approved,pending,rejected',
            'nik' => 'nullable|string|max:30',
            'nip' => 'nullable|string|max:30',
            'nim' => 'nullable|string|max:30',
            'phone_number' => 'nullable|string|max:30',
            'faculty' => 'nullable|string|max:255',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'status' => $request->status,
            'nik' => $request->nik,
            'nip' => $request->nip,
            'nim' => $request->nim,
            'identity_number' => $request->nik ?: ($request->nip ?: $request->nim),
            'phone_number' => $request->phone_number,
            'faculty' => $request->faculty,
        ]);

        ActivityLog::log('UPDATE_USER', "Admin " . Auth::user()->name . " memperbarui data pengguna {$user->name}.");

        return redirect()->back()->with('success', 'Data akun ' . $user->name . ' berhasil diperbarui.');
    }

    public function resetUserPassword(Request $request, User $user)
    {
        $request->validate([
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        ActivityLog::log('RESET_PASSWORD', "Admin " . Auth::user()->name . " mereset password pengguna {$user->name}.");

        return redirect()->back()->with('success', 'Kata sandi untuk akun ' . $user->name . ' berhasil di-reset!');
    }

    public function deleteUser(User $user)
    {
        if (Auth::id() === $user->id) {
            return redirect()->back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $userName = $user->name;
        $user->delete();

        ActivityLog::log('DELETE_USER', "Admin " . Auth::user()->name . " menghapus akun {$userName}.");

        return redirect()->back()->with('success', 'Akun ' . $userName . ' berhasil dihapus dari sistem.');
    }

    // ==========================================
    // MASTER TIPE PERMOHONAN HKI (PATEN, CIPTA, MEREK, DLL)
    // ==========================================
    public function applicationTypesIndex()
    {
        $types = ApplicationType::latest()->get();
        return view('admin.application_types.index', compact('types'));
    }

    public function storeApplicationType(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:application_types,code',
            'description' => 'nullable|string',
        ]);

        ApplicationType::create([
            'name' => $request->name,
            'code' => strtoupper($request->code),
            'description' => $request->description,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->back()->with('success', 'Tipe Permohonan HKI berhasil ditambahkan.');
    }

    public function updateApplicationType(Request $request, ApplicationType $type)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:application_types,code,' . $type->id,
            'description' => 'nullable|string',
        ]);

        $type->update([
            'name' => $request->name,
            'code' => strtoupper($request->code),
            'description' => $request->description,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->back()->with('success', 'Tipe Permohonan HKI berhasil diperbarui.');
    }

    public function deleteApplicationType(ApplicationType $type)
    {
        $type->delete();
        return redirect()->back()->with('success', 'Tipe Permohonan HKI berhasil dihapus.');
    }

    // ==========================================
    // 1. MASTER FAKULTAS / UNIT KERJA USER
    // ==========================================
    public function facultiesIndex()
    {
        $faculties = Faculty::withCount('users')->latest()->get();
        return view('admin.faculties.index', compact('faculties'));
    }

    public function storeFaculty(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:faculties,name',
            'code' => 'nullable|string|max:20',
            'description' => 'nullable|string',
        ]);

        Faculty::create([
            'name' => $request->name,
            'code' => $request->code,
            'description' => $request->description,
        ]);

        return redirect()->back()->with('success', 'Fakultas / Unit Kerja berhasil ditambahkan!');
    }

    public function updateFaculty(Request $request, Faculty $faculty)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:faculties,name,' . $faculty->id,
            'code' => 'nullable|string|max:20',
            'description' => 'nullable|string',
        ]);

        $faculty->update([
            'name' => $request->name,
            'code' => $request->code,
            'description' => $request->description,
        ]);

        return redirect()->back()->with('success', 'Fakultas / Unit Kerja berhasil diperbarui!');
    }

    public function deleteFaculty(Faculty $faculty)
    {
        $faculty->delete();
        return redirect()->back()->with('success', 'Fakultas / Unit Kerja berhasil dihapus.');
    }

    // ==========================================
    // 2. APPROVE / REJECT AKUN USER BARU (PERSYARATAN 3: MULTI-CHANNEL ALERTS)
    // ==========================================
    public function usersIndex()
    {
        $users = User::where('role', 'user')->latest()->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    public function approveUser(User $user)
    {
        $user->update(['status' => 'approved']);

        ActivityLog::log('VERIFY_USER', "Admin " . Auth::user()->name . " menyetujui (Approved) akun {$user->name}.");

        // MULTI-CHANNEL ALERTS (In-App, Email, WhatsApp)
        MultiChannelAlertService::triggerAlert(
            $user,
            'USER_APPROVED',
            'Akun Pengguna Disetujui (Approved)',
            "Selamat! Akun Pemohon HKI Anda telah diverifikasi dan disetujui oleh Administrator Sentra HKI UM BIMA. Anda sekarang dapat membuat dan mengajukan permohonan HKI Baru.",
            route('user.dashboard')
        );

        return redirect()->back()->with('success', 'Akun user ' . $user->name . ' berhasil disetujui (Approved) dan notifikasi multi-channel telah dikirim!');
    }

    public function rejectUser(User $user)
    {
        $user->update(['status' => 'rejected']);

        ActivityLog::log('VERIFY_USER', "Admin " . Auth::user()->name . " menolak (Rejected) akun {$user->name}.");

        MultiChannelAlertService::triggerAlert(
            $user,
            'USER_REJECTED',
            'Akun Pengguna Ditolak (Rejected)',
            "Pendaftaran akun Anda tidak disetujui. Silakan hubungi Administrator Sentra HKI UM BIMA untuk informasi lebih lanjut.",
            route('home')
        );

        return redirect()->back()->with('success', 'Akun user ' . $user->name . ' telah ditolak.');
    }

    // ==========================================
    // 3. CRUD WELCOME POPUP HOMEPAGE GUEST
    // ==========================================
    public function popupsIndex()
    {
        $popups = Popup::latest()->get();
        return view('admin.popups.index', compact('popups'));
    }

    public function storePopup(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('popups', 'public');
        }

        Popup::create([
            'title' => $request->title,
            'content' => $request->content,
            'image_path' => $imagePath,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->back()->with('success', 'Welcome Popup berhasil ditambahkan.');
    }

    public function togglePopup(Popup $popup)
    {
        $popup->update(['is_active' => !$popup->is_active]);
        return redirect()->back()->with('success', 'Status aktif Popup berhasil diubah.');
    }

    public function deletePopup(Popup $popup)
    {
        if ($popup->image_path && Storage::disk('public')->exists($popup->image_path)) {
            Storage::disk('public')->delete($popup->image_path);
        }
        $popup->delete();
        return redirect()->back()->with('success', 'Popup berhasil dihapus.');
    }

    // ==========================================
    // 4. CRUD HOMEPAGE SLIDERS
    // ==========================================
    public function slidersIndex()
    {
        $sliders = Slider::orderBy('order', 'asc')->latest()->get();
        return view('admin.sliders.index', compact('sliders'));
    }

    public function storeSlider(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'image' => 'required|image|max:3072',
            'link_url' => 'nullable|url',
        ]);

        $imagePath = $request->file('image')->store('sliders', 'public');

        Slider::create([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'image_path' => $imagePath,
            'link_url' => $request->link_url,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->back()->with('success', 'Slider Banner berhasil ditambahkan.');
    }

    public function toggleSlider(Slider $slider)
    {
        $slider->update(['is_active' => !$slider->is_active]);
        return redirect()->back()->with('success', 'Status aktif Slider berhasil diubah.');
    }

    public function deleteSlider(Slider $slider)
    {
        if ($slider->image_path && Storage::disk('public')->exists($slider->image_path)) {
            Storage::disk('public')->delete($slider->image_path);
        }
        $slider->delete();
        return redirect()->back()->with('success', 'Slider Banner berhasil dihapus.');
    }

    // ==========================================
    // 5. REVIEW PENGAJUAN HKI & 8 DOKUMEN
    // ==========================================
    public function applicationsIndex()
    {
        $applications = HkiApplication::with(['user', 'documents', 'payments', 'applicants'])->latest()->paginate(15);
        return view('admin.applications.index', compact('applications'));
    }

    public function showApplication(HkiApplication $application)
    {
        $application->load(['user', 'documents', 'payments', 'applicants']);
        $documentsMap = $application->documents->keyBy('document_type');

        return view('admin.applications.show', compact('application', 'documentsMap'));
    }

    // ==========================================
    // 6. FITUR EXPORT ZIP (INTEGRASI DJKI)
    // ==========================================
    public function exportZip(HkiApplication $application)
    {
        $application->load('documents');

        if ($application->documents->count() === 0) {
            return redirect()->back()->with('error', 'Tidak ada dokumen yang diunggah untuk permohonan ini.');
        }

        $disk = Storage::disk('public');
        if (!$disk->exists('zips')) {
            $disk->makeDirectory('zips');
        }

        $zipFileName = 'DJKI_HKI_App_' . $application->id . '_' . time() . '.zip';
        $zipFilePath = $disk->path('zips/' . $zipFileName);

        $zip = new ZipArchive();

        if ($zip->open($zipFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
            foreach ($application->documents as $doc) {
                $fileStoragePath = $disk->path($doc->file_path);

                if (file_exists($fileStoragePath)) {
                    $entryName = strtoupper($doc->document_type) . '_' . basename($doc->file_path);
                    $zip->addFile($fileStoragePath, $entryName);
                }
            }
            $zip->close();
        } else {
            return redirect()->back()->with('error', 'Gagal membuat file ZIP archive.');
        }

        $application->update([
            'zip_export_path' => 'zips/' . $zipFileName,
            'status' => $application->status === 'submitted' ? 'under_review' : $application->status
        ]);

        ActivityLog::log('EXPORT_ZIP', "Admin " . Auth::user()->name . " meng-export paket ZIP 8 dokumen untuk permohonan #{$application->id}.");

        return response()->download($zipFilePath, $zipFileName, [
            'Content-Type' => 'application/zip',
        ]);
    }

    // ==========================================
    // 7. INPUT NOMOR DJKI & KODE BILLING SIMPAKI (MULTI-CHANNEL ALERTS)
    // ==========================================
    public function inputDjkiBilling(Request $request, HkiApplication $application)
    {
        $request->validate([
            'djki_application_number' => 'nullable|string|max:100',
            'simpaki_billing_code' => 'required|string|max:100',
            'billing_amount' => 'required|numeric|min:0',
        ]);

        $application->update([
            'djki_application_number' => $request->djki_application_number,
            'simpaki_billing_code' => $request->simpaki_billing_code,
            'billing_amount' => $request->billing_amount,
            'status' => 'billing_issued',
        ]);

        $application->load('user');

        ActivityLog::log('BILLING_ISSUED', "Admin " . Auth::user()->name . " menerbitkan Billing SIMPAKI ({$request->simpaki_billing_code}) untuk permohonan #{$application->id}.");

        // MULTI-CHANNEL ALERTS (In-App, Email, WhatsApp)
        MultiChannelAlertService::triggerAlert(
            $application->user,
            'BILLING_ISSUED',
            'Kode Billing SIMPAKI Diterbitkan',
            "Admin telah menerbitkan Kode Billing SIMPAKI DJKI ({$request->simpaki_billing_code}) senilai Rp " . number_format($request->billing_amount, 0, ',', '.') . " untuk permohonan HKI Anda ('{$application->title}'). Silakan lakukan pembayaran dan unggah bukti transfer.",
            route('applications.show', $application->id)
        );

        return redirect()->back()->with('success', 'Nomor Permohonan DJKI & Kode Billing SIMPAKI berhasil disimpan dan notifikasi multi-channel telah terkirim!');
    }

    // ==========================================
    // 8. VERIFIKASI PEMBAYARAN & KUITANSI PDF (MULTI-CHANNEL ALERTS)
    // ==========================================
    public function verifyPayment(Request $request, Payment $payment)
    {
        $payment->load('hkiApplication', 'user');

        $pdf = Pdf::loadView('pdf.kuitansi', [
            'payment' => $payment,
            'application' => $payment->hkiApplication,
            'user' => $payment->user,
        ]);

        $receiptPath = 'receipts/Kuitansi_' . $payment->id . '_' . time() . '.pdf';
        Storage::disk('public')->put($receiptPath, $pdf->output());

        $payment->update([
            'status' => 'verified_paid',
            'receipt_pdf_path' => $receiptPath,
            'verified_at' => now(),
        ]);

        $payment->hkiApplication->update(['status' => 'paid']);

        ActivityLog::log('PAYMENT_VERIFIED', "Admin " . Auth::user()->name . " memverifikasi pembayaran SIMPAKI & menerbitkan Kuitansi PDF permohonan #{$payment->hki_application_id}.");

        // MULTI-CHANNEL ALERTS (In-App, Email, WhatsApp)
        MultiChannelAlertService::triggerAlert(
            $payment->user,
            'PAYMENT_VERIFIED',
            'Pembayaran Terverifikasi & Kuitansi Terbit',
            "Pembayaran PNBP SIMPAKI permohonan HKI Anda ('{$payment->hkiApplication->title}') telah diverifikasi LUNAS oleh Admin. Kuitansi PDF Resmi telah diterbitkan.",
            route('applications.show', $payment->hki_application_id)
        );

        return redirect()->back()->with('success', 'Pembayaran berhasil diverifikasi. Kuitansi PDF otomatis telah terbit dan notifikasi multi-channel dikirim!');
    }
}
