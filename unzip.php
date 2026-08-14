<?php
// Auto Unzip & Setup Script for ki.umbima.ac.id
set_time_limit(600);
ini_set('memory_limit', '1024M');

$zipFile = __DIR__ . '/hki_umb_production.zip';

echo "<!DOCTYPE html><html><head><title>Auto Extract - Direktorat Inovasi & KI UM Bima</title>";
echo "<style>body{font-family:sans-serif;padding:40px;background:#f8fafc;color:#1e293b;}.card{background:#fff;padding:30px;border-radius:12px;box-shadow:0 4px 6px -1px rgba(0,0,0,0.1);max-width:600px;margin:auto;}h1{color:#16a34a;margin-top:0;}.btn{display:inline-block;background:#2563eb;color:#fff;padding:12px 24px;border-radius:8px;text-decoration:none;font-weight:bold;margin-top:16px;}</style></head><body><div class='card'>";

if (!file_exists($zipFile)) {
    echo "<h1 style='color:#dc2626;'>File ZIP Tidak Ditemukan</h1><p>File <code>hki_umb_production.zip</code> tidak ditemukan di folder root server.</p></div></body></html>";
    exit;
}

$zip = new ZipArchive();
if ($zip->open($zipFile) === true) {
    $zip->extractTo(__DIR__);
    $zip->close();
    
    echo "<h1>Ekstrak Berhasil! 🎉</h1>";
    echo "<p>Seluruh file project Laravel telah berhasil diekstrak ke server secara otomatis.</p>";
    echo "<a href='/deploy-helper.php?token=kiumbima2026&action=migrate' class='btn'>Jalankan Migrasi Database & Setup Sekarang &rarr;</a>";
} else {
    echo "<h1 style='color:#dc2626;'>Gagal Ekstrak ZIP</h1><p>Tidak dapat membuka file <code>hki_umb_production.zip</code>.</p>";
}

echo "</div></body></html>";
