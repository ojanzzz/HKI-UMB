<?php
set_time_limit(600);
ini_set('memory_limit', '512M');

$ftpHost = '185.205.222.104';
$ftpPort = 21;
$ftpUser = 'ftp_ki_umbima_ac_id';
$ftpPass = 'KI.14082026';

$localZip = __DIR__ . '/public/hki_umb_production.zip';

if (!file_exists($localZip)) {
    die("ERROR: File local zip hki_umb_production.zip tidak ditemukan.\n");
}

$sizeMb = round(filesize($localZip) / (1024 * 1024), 2);
echo "1. Memulai re-upload PKZip standar via cURL FTP ke server $ftpHost...\n";
echo "2. Ukuran file PKZip yang di-upload: $sizeMb MB\n";

$remoteUrl = "ftp://{$ftpHost}:{$ftpPort}/hki_umb_production.zip";

$fp = fopen($localZip, 'rb');

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $remoteUrl);
curl_setopt($ch, CURLOPT_USERPWD, "{$ftpUser}:{$ftpPass}");
curl_setopt($ch, CURLOPT_UPLOAD, 1);
curl_setopt($ch, CURLOPT_INFILE, $fp);
curl_setopt($ch, CURLOPT_INFILESIZE, filesize($localZip));
curl_setopt($ch, CURLOPT_FTP_USE_EPSV, 1);
curl_setopt($ch, CURLOPT_TIMEOUT, 600);

$result = curl_exec($ch);
$error = curl_error($ch);
$httpCode = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);

curl_close($ch);
fclose($fp);

if ($result) {
    echo "SUCCESS: File Standard PKZip hki_umb_production.zip ($sizeMb MB) BERHASIL DI-UPLOAD KE SERVER FTP! 🎉\n";
} else {
    echo "ERROR: Gagal mengunggah file via cURL FTP: $error (Code: $httpCode)\n";
}
