<?php
set_time_limit(0);
ini_set('memory_limit', '1024M');

$rootPath = __DIR__;
$publicZip = $rootPath . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'hki_umb_production.zip';

if (file_exists($publicZip)) {
    @unlink($publicZip);
}

// Ensure .env in root is configured from .env.production for production zip
$envProd = $rootPath . DIRECTORY_SEPARATOR . '.env.production';
$envFile = $rootPath . DIRECTORY_SEPARATOR . '.env';
if (file_exists($envProd)) {
    @copy($envProd, $envFile);
}

$cmd = 'powershell -NoProfile -ExecutionPolicy Bypass -Command "' .
    '$dest = \'' . str_replace("'", "''", $publicZip) . '\'; ' .
    '$files = Get-ChildItem -Path \'' . str_replace("'", "''", $rootPath) . '\' -Exclude \'.git\',\'.github\',\'node_modules\',\'hki_umb_production.zip\',\'*.log\'; ' .
    'Compress-Archive -Path $files.FullName -DestinationPath $dest -Force"';

exec($cmd, $outputArray, $returnCode);

if (file_exists($publicZip) && filesize($publicZip) > 0) {
    $sizeMb = round(filesize($publicZip) / (1024 * 1024), 2);
    echo "SUCCESS: File ZIP Production berhasil dibuat via PowerShell! ($sizeMb MB)\n";
} else {
    echo "ERROR: Gagal membuat ZIP via PowerShell. Return code: $returnCode\n";
    echo implode("\n", $outputArray);
}
