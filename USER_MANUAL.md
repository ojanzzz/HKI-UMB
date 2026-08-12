# 📖 PANDUAN PENGGUNAAN SISTEM INFORMASI HKI
## Universitas Muhammadiyah Bima (UM BIMA)
*Terintegrasi Direktorat Jenderal Kekayaan Intelektual (DJKI) Kemenkumham RI*

---

## 🚀 1. AKSES DAN INISIALISASI SISTEM

### A. Menjalankan Aplikasi Secara Lokal
Aplikasi berjalan pada server lokal Laravel dengan perintah:
```bash
php artisan serve --port=8088
```
Akses di browser: **[http://127.0.0.1:8088/](http://127.0.0.1:8088/)**

### B. Kredensial Akun Uji Coba (Dummy Data)

| Peran (Role) | Alamat Email | Kata Sandi | Status Akun | Fitur & Akses Utama |
|---|---|---|---|---|
| **Administrator HKI** | `admin@umb.ac.id` | `password123` | `Approved` | Panel Admin, **Master Kategori Pengajuan**, **Master Tipe HKI**, Audit Logs, Multi-Channel Alerts (Email & WA), In-App Bell, Management User/Admin, Review 8 Dokumen, Export ZIP DJKI, Billing SIMPAKI, Kuitansi PDF |
| **Pemohon (Approved)** | `budi.santoso@umb.ac.id` | `password123` | `Approved` | Dashboard User, **5-Step Interactive Stepper Wizard**, **Unduh Template Word (.docx) di Step 4 & Detail Draft**, **Upload Multi-Format (.pdf, .docx, .doc, .png, .zip)**, Edit Profil |
| **Pemohon (Pending)** | `ahmad.rizal@umb.ac.id` | `password123` | `Pending` | Menguji middleware verifikasi NIK/KTP akun baru |

---

## 🌐 2. DEPLOYMENT KE VERCEL

### A. Persiapan
1. Push kode ke GitHub/GitLab
2. Import repository di [Vercel Dashboard](https://vercel.com)

### B. Environment Variables (Wajib)
Set di Vercel → Project Settings → Environment Variables:

| Variable | Value | Contoh |
|---|---|---|
| `APP_ENV` | `production` | `production` |
| `APP_DEBUG` | `false` | `false` |
| `APP_KEY` | Generate dari lokal | `base64:...` |
| `APP_URL` | URL Vercel Anda | `https://hki-umb.vercel.app` |
| `DB_CONNECTION` | `pgsql` atau `mysql` | `pgsql` |
| `DB_HOST` | Host database eksternal | `ep-xxx.aws.neon.tech` |
| `DB_PORT` | Port database | `5432` |
| `DB_DATABASE` | Nama database | `neondb` |
| `DB_USERNAME` | Username DB | `neondb_owner` |
| `DB_PASSWORD` | Password DB | `password` |

### C. Build Settings
- **Framework Preset**: Other
- **Build Command**: `composer install --no-dev --optimize-autoloader && npm install && npm run build`
- **Output Directory**: `public`

### D. Post-Deployment
Setelah deploy berhasil, jalankan migrasi:
```bash
vercel env pull .env
php artisan migrate --force
php artisan db:seed --class=DummyDataSeeder --force
```

📖 Lihat `DEPLOY.md` untuk panduan lengkap.

---

## 📄 3. UNDUH TEMPLATE & UNGGAH DOKUMEN PERMOHONAN HKI

### A. Pada Step 4 Wizard Pengajuan Baru (`/applications/create`)
- Setiap slot dari 8 dokumen HKI secara langsung dilengkapi dengan tombol **`📥 UNDUH TEMPLATE`** Word (`.docx`) resmi:
  1. `0. Data Dukung Invensi`
  2. `1. Daftar Inventor`
  3. `2. Deskripsi Paten`
  4. `3. Abstrak Invensi`
  5. `4. Klaim Invensi`
  6. `5. Gambar Invensi`
  7. `6. Surat Pernyataan Pengalihan Hak`
  8. `7. Surat Pernyataan Kepemilikan`

### B. Pada Halaman Detail / Kelola Draft Permohonan (`/applications/{id}`)
- Pengguna dapat mengunduh ulang template Word (`.docx`) kapan saja via tombol **`📥 UNDUH TEMPLATE`**.
- Pengguna dapat mengunggah atau mengganti dokumen yang ada via formulir **`📤 UNGGAH DOKUMEN`** (Mendukung format `.pdf`, `.docx`, `.doc`, `.png`, `.jpg`, `.zip` hingga 15MB).
- Admin dapat meninjau, mengunduh per dokumen, atau mengeksport paket 8 dokumen sekaligus ke dalam file archive ZIP DJKI.

---

## 🛠️ 4. TROUBLESHOOTING

### A. Error "No such table: hki_applicants"
Jalankan migrasi database:
```bash
php artisan migrate --force
```

### B. Error "Class 'App\Models\HkiApplicant' not found"
Regenerasi autoload:
```bash
composer dump-autoload
```

### C. Gambar tidak muncul
Pastikan storage link sudah dibuat:
```bash
php artisan storage:link
```

### D. Lightbox tidak muncul
Pastikan JavaScript tidak error di console browser. Cek network request untuk gambar.

