<?php
/**
 * Script Helper Deployment (Untuk hosting tanpa akses SSH/Terminal)
 * Keamanan: Diberi token rahasia agar tidak bisa diakses sembarangan.
 */

$secretToken = 'kiumbima2026';

if (!isset($_GET['token']) || $_GET['token'] !== $secretToken) {
    http_response_code(403);
    die('Akses Ditolak: Token keamanan tidak valid.');
}

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$action = $_GET['action'] ?? 'help';
$output = '';

try {
    switch ($action) {
        case 'migrate':
            \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
            $output = \Illuminate\Support\Facades\Artisan::output();
            break;

        case 'storage-link':
            \Illuminate\Support\Facades\Artisan::call('storage:link');
            $output = \Illuminate\Support\Facades\Artisan::output();
            break;

        case 'cache-optimize':
            \Illuminate\Support\Facades\Artisan::call('config:cache');
            \Illuminate\Support\Facades\Artisan::call('route:cache');
            \Illuminate\Support\Facades\Artisan::call('view:cache');
            $output = "Konfigurasi, rute, dan view berhasil di-cache!\n" . \Illuminate\Support\Facades\Artisan::output();
            break;

        case 'cache-clear':
            \Illuminate\Support\Facades\Artisan::call('config:clear');
            \Illuminate\Support\Facades\Artisan::call('route:clear');
            \Illuminate\Support\Facades\Artisan::call('view:clear');
            \Illuminate\Support\Facades\Artisan::call('cache:clear');
            $output = "Seluruh cache berhasil dibersihkan!\n" . \Illuminate\Support\Facades\Artisan::output();
            break;

        default:
            $output = "Gunakan parameter action berikut:\n" .
                "- ?token=kiumbima2026&action=migrate (Jalankan migrasi database)\n" .
                "- ?token=kiumbima2026&action=storage-link (Buat symlink storage)\n" .
                "- ?token=kiumbima2026&action=cache-optimize (Optimize cache)\n" .
                "- ?token=kiumbima2026&action=cache-clear (Bersihkan cache)\n";
            break;
    }
} catch (\Throwable $e) {
    $output = "ERR: " . $e->getMessage() . "\n" . $e->getTraceAsString();
}

header('Content-Type: text/plain');
echo "=== KI UM BIMA DEPLOYMENT HELPER ===\n\n" . $output;
