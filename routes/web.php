<?php

use App\Http\Controllers\Admin\AdminHkiController;
use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HkiApplicationController;
use App\Http\Controllers\UserProfileController;
use App\Models\HkiApplication;
use App\Models\Popup;
use App\Models\Slider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Sistem Informasi HKI Universitas Muhammadiyah Bima (UM BIMA)
|--------------------------------------------------------------------------
*/

// 1. Homepage Publik (Guest) & Active Sliders & Public Applications
Route::get('/', function () {
    $activePopup = Popup::where('is_active', true)->latest()->first();
    $sliders = Slider::where('is_active', true)->orderBy('order', 'asc')->latest()->get();
    
    // Daftar Semua Ajuan Permohonan (untuk tabel halaman depan)
    $publicApplications = HkiApplication::with(['user', 'applicants'])
        ->latest()
        ->paginate(15);

    return view('welcome', compact('activePopup', 'sliders', 'publicApplications'));
})->name('home');

Route::get('/dev/clear-cache', function () {
    \Illuminate\Support\Facades\Artisan::call('view:clear');
    \Illuminate\Support\Facades\Artisan::call('cache:clear');
    \Illuminate\Support\Facades\Artisan::call('config:clear');
    return response()->json(['status' => 'success', 'message' => 'View/cache/config cleared successfully.']);
});




Route::get('/dev/run-migrations', function () {
    \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);

    $templatesMap = [
        'data_dukung' => [
            'title' => '0. Data Dukung',
            'description' => 'Dokumen data dukung resmi pengajuan KI (Sertifikat, Berita Acara, dll).',
            'file_name' => '0. Data dukung.docx',
        ],
        'daftar_inventor' => [
            'title' => '1. Daftar Inventor',
            'description' => 'Template daftar susunan anggota inventor / pencipta.',
            'file_name' => '1. Template daftar inventor.docx',
        ],
        'deskripsi_paten' => [
            'title' => '2. Deskripsi Paten',
            'description' => 'Template spesifikasi dan ulasan deskripsi teknis invensi paten.',
            'file_name' => '2. Template Deskripsi Paten.docx',
        ],
        'abstrak' => [
            'title' => '3. Abstrak Invensi',
            'description' => 'Template abstrak ringkasan invensi teknologi maksimal 200 kata.',
            'file_name' => '3. Template abstrak.docx',
        ],
        'klaim' => [
            'title' => '4. Klaim Invensi',
            'description' => 'Template klaim kebaruan invensi paten yang diajukan.',
            'file_name' => '4. Template klaim.docx',
        ],
        'gambar_invensi' => [
            'title' => '5. Gambar Invensi',
            'description' => 'Template penyajian gambar teknik / ilustrasi invensi.',
            'file_name' => '5. Template Gambar Invensi.docx',
        ],
        'pernyataan_pengalihan_hak' => [
            'title' => '6. Surat Pernyataan Pengalihan Hak',
            'description' => 'Surat pernyataan pengalihan hak cipta/paten ke institusi UM Bima.',
            'file_name' => '6. Surat Pernyataan Pengalihan Hak.docx',
        ],
        'pernyataan_kepemilikan' => [
            'title' => '7. Surat Pernyataan Kepemilikan',
            'description' => 'Surat pernyataan kepemilikan invensi/karya keaslian bermeterai.',
            'file_name' => '7. Template Surat Pernyataan Kepemilikan.docx',
        ],
    ];

    \App\Models\DocumentTemplate::truncate();

    foreach ($templatesMap as $code => $item) {
        \App\Models\DocumentTemplate::create([
            'code' => $code,
            'title' => $item['title'],
            'description' => $item['description'],
            'file_name' => $item['file_name'],
            'file_type' => 'docx',
            'is_active' => true,
        ]);
    }

    return response()->json(['status' => 'success', 'message' => 'Migration and DocumentTemplates updated successfully!']);
});

// 1b. Halaman Detail Ajuan Publik (tanpa popup modal)
Route::get('/ajuan/{application}', [HkiApplicationController::class, 'publicShow'])->name('public.applications.show');

// Halaman Informasi Publik (Panduan, Tentang, FAQ)
Route::view('/panduan', 'panduan')->name('panduan');
Route::view('/tentang', 'tentang')->name('tentang');
Route::view('/faq', 'faq')->name('faq');

use App\Http\Controllers\Auth\RegisterController;

// 2. Autentikasi Login & Registrasi (Login Biasa Email/Password, Registrasi, & Google SSO)
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.post');

Route::get('/auth/google', [GoogleAuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [GoogleAuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');

Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect()->route('home')->with('info', 'Anda telah berhasil logout.');
})->name('logout');

// 3. Kelengkapan Profil & Status Pending (Force Redirect)
Route::middleware(['auth'])->group(function () {
    Route::get('/profile/complete', [UserProfileController::class, 'showCompleteForm'])->name('profile.complete');
    Route::post('/profile/save', [UserProfileController::class, 'saveProfile'])->name('profile.save');
    Route::get('/profile/pending', [UserProfileController::class, 'showPendingNotice'])->name('profile.pending');
});

// 4. Fitur User / Pemohon HKI (Membutuhkan Auth, Role User, dan Force Profile)
Route::middleware(['auth', 'role:user', 'force.profile'])->group(function () {
    Route::get('/user/dashboard', [HkiApplicationController::class, 'index'])->name('user.dashboard');
    
    // Edit Profil User / Pemohon
    Route::get('/profile/edit', [UserProfileController::class, 'editProfile'])->name('profile.edit');
    Route::post('/profile/update', [UserProfileController::class, 'updateProfile'])->name('profile.update');
    
    // CRUD Pengajuan HKI & Dokumen
    Route::get('/applications/create', [HkiApplicationController::class, 'create'])->name('applications.create');
    Route::post('/applications', [HkiApplicationController::class, 'store'])->name('applications.store');
    Route::get('/applications/{application}', [HkiApplicationController::class, 'show'])->name('applications.show');
    
    // Unduh Template Formulir Word (.docx) & Upload Dokumen Multi-Format & Foto Produk
    Route::get('/templates/download/{docType}', [HkiApplicationController::class, 'downloadTemplate'])->name('templates.download');
    Route::post('/applications/{application}/upload-document', [HkiApplicationController::class, 'uploadDocument'])->name('applications.upload-document');
    Route::post('/applications/{application}/update-product-image', [HkiApplicationController::class, 'updateProductImage'])->name('applications.update-product-image');
    
    // Pembayaran SIMPAKI
    Route::post('/applications/{application}/submit-payment', [HkiApplicationController::class, 'submitPayment'])->name('applications.submit-payment');
});

// 5. Fitur Admin HKI & Integrasi DJKI
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminHkiController::class, 'dashboard'])->name('admin.dashboard');
    
    // User Verification / Approval & Master Fakultas
    Route::get('/faculties', [AdminHkiController::class, 'facultiesIndex'])->name('admin.faculties');
    Route::post('/faculties', [AdminHkiController::class, 'storeFaculty'])->name('admin.faculties.store');
    Route::post('/faculties/{faculty}/update', [AdminHkiController::class, 'updateFaculty'])->name('admin.faculties.update');
    Route::delete('/faculties/{faculty}', [AdminHkiController::class, 'deleteFaculty'])->name('admin.faculties.delete');

    // Log Aktivitas System (Audit Logs)
    Route::get('/activity-logs', [AdminHkiController::class, 'activityLogsIndex'])->name('admin.activity-logs');

    // Manajemen User & Tambah Admin (Reset Password, Edit Data, Role, Delete)
    Route::get('/manage-users', [AdminHkiController::class, 'manageUsersIndex'])->name('admin.manage-users');
    Route::post('/manage-users/store-admin', [AdminHkiController::class, 'storeAdmin'])->name('admin.manage-users.store-admin');
    Route::post('/manage-users/{user}/update', [AdminHkiController::class, 'updateUser'])->name('admin.manage-users.update');
    Route::post('/manage-users/{user}/reset-password', [AdminHkiController::class, 'resetUserPassword'])->name('admin.manage-users.reset-password');
    Route::delete('/manage-users/{user}', [AdminHkiController::class, 'deleteUser'])->name('admin.manage-users.delete');

    Route::get('/users', [AdminHkiController::class, 'usersIndex'])->name('admin.users');
    Route::post('/users/{user}/approve', [AdminHkiController::class, 'approveUser'])->name('admin.users.approve');
    Route::post('/users/{user}/reject', [AdminHkiController::class, 'rejectUser'])->name('admin.users.reject');
    
    // Master Tipe Permohonan HKI
    Route::get('/application-types', [AdminHkiController::class, 'applicationTypesIndex'])->name('admin.application-types');
    Route::post('/application-types', [AdminHkiController::class, 'storeApplicationType'])->name('admin.application-types.store');
    Route::post('/application-types/{type}/update', [AdminHkiController::class, 'updateApplicationType'])->name('admin.application-types.update');
    Route::delete('/application-types/{type}', [AdminHkiController::class, 'deleteApplicationType'])->name('admin.application-types.delete');

    // Manajemen Template Dokumen Pengajuan
    Route::get('/templates', [AdminHkiController::class, 'templatesIndex'])->name('admin.templates');
    Route::post('/templates/{template}/update', [AdminHkiController::class, 'updateTemplate'])->name('admin.templates.update');

    // Master Kategori Pengajuan HKI (UMKM, PERGURUAN TINGGI, UMUM, DLL)
    Route::get('/application-categories', [AdminHkiController::class, 'applicationCategoriesIndex'])->name('admin.application-categories');
    Route::post('/application-categories', [AdminHkiController::class, 'storeApplicationCategory'])->name('admin.application-categories.store');
    Route::post('/application-categories/{category}/update', [AdminHkiController::class, 'updateApplicationCategory'])->name('admin.application-categories.update');
    Route::delete('/application-categories/{category}', [AdminHkiController::class, 'deleteApplicationCategory'])->name('admin.application-categories.delete');
    
    // Welcome Popup CRUD
    Route::get('/popups', [AdminHkiController::class, 'popupsIndex'])->name('admin.popups');
    Route::post('/popups', [AdminHkiController::class, 'storePopup'])->name('admin.popups.store');
    Route::post('/popups/{popup}/toggle', [AdminHkiController::class, 'togglePopup'])->name('admin.popups.toggle');
    Route::delete('/popups/{popup}', [AdminHkiController::class, 'deletePopup'])->name('admin.popups.delete');

    // Homepage Slider Banners CRUD
    Route::get('/sliders', [AdminHkiController::class, 'slidersIndex'])->name('admin.sliders');
    Route::post('/sliders', [AdminHkiController::class, 'storeSlider'])->name('admin.sliders.store');
    Route::put('/sliders/{slider}', [AdminHkiController::class, 'updateSlider'])->name('admin.sliders.update');
    Route::post('/sliders/{slider}/toggle', [AdminHkiController::class, 'toggleSlider'])->name('admin.sliders.toggle');
    Route::delete('/sliders/{slider}', [AdminHkiController::class, 'deleteSlider'])->name('admin.sliders.delete');
    
    // Review Pengajuan HKI & 8 Dokumen
    Route::get('/applications', [AdminHkiController::class, 'applicationsIndex'])->name('admin.applications');
    Route::get('/applications/{application}', [AdminHkiController::class, 'showApplication'])->name('admin.applications.show');
    
    // Export ZIP 8 PDF Documents (ZipArchive)
    Route::get('/applications/{application}/export-zip', [AdminHkiController::class, 'exportZip'])->name('admin.applications.export-zip');
    
    // Input DJKI & SIMPAKI Billing Code
    Route::post('/applications/{application}/input-djki', [AdminHkiController::class, 'inputDjkiBilling'])->name('admin.applications.input-djki');
    
    // Verify Payment & Generate Kuitansi PDF
    Route::post('/payments/{payment}/verify', [AdminHkiController::class, 'verifyPayment'])->name('admin.payments.verify');
});

// Notifications Route for Authenticated Users
Route::middleware('auth')->group(function () {
    Route::post('/notifications/mark-all-read', function () {
        \App\Models\UserNotification::where('user_id', auth()->id())->where('is_read', false)->update(['is_read' => true]);
        return redirect()->back()->with('success', 'Semua notifikasi telah ditandai dibaca.');
    })->name('notifications.mark-all-read');
});
