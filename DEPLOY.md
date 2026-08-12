# 🚀 Panduan Deployment ke Vercel

## Prasyarat
- Akun [Vercel](https://vercel.com) (gratis)
- Database eksternal (contoh: [Neon](https://neon.tech), [Supabase](https://supabase.com), atau [PlanetScale](https://planetscale.com))
- Git repository (GitHub/GitLab/Bitbucket)

---

## Langkah 1: Persiapan Database

1. Buat database PostgreSQL/MySQL di layanan eksternal (misal Neon)
2. Catat **connection string** yang diberikan

Contoh format Neon PostgreSQL:
```
postgresql://username:password@ep-xxx.us-east-1.aws.neon.tech/neondb?sslmode=require
```

---

## Langkah 2: Persiapan Repository

1. Push kode ke GitHub/GitLab/Bitbucket
2. Import repository di Vercel dashboard

---

## Langkah 3: Konfigurasi Environment Variables di Vercel

Di Vercel Dashboard → Project Settings → Environment Variables, tambahkan:

```env
APP_NAME="HKI UM BIMA"
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:GENERATE_KEY_DI_LOCAL
APP_URL=https://nama-project-anda.vercel.app

DB_CONNECTION=pgsql
DB_HOST=your-db-host.com
DB_PORT=5432
DB_DATABASE=your_db_name
DB_USERNAME=your_username
DB_PASSWORD=your_password

SESSION_DRIVER=database
QUEUE_CONNECTION=sync
CACHE_STORE=database
FILESYSTEM_DISK=public

MAIL_MAILER=log
MAIL_FROM_ADDRESS="noreply@umb.ac.id"
MAIL_FROM_NAME="Sentra HKI UM BIMA"
```

**Catatan:**
- `APP_KEY` harus di-generate dari lokal: `php artisan key:generate --show`
- Ganti `DB_*` dengan kredensial database Anda
- Ganti `APP_URL` dengan domain Vercel Anda

---

## Langkah 4: Build Settings di Vercel

- **Framework Preset**: Other
- **Build Command**: `composer install --no-dev --optimize-autoloader && npm install && npm run build`
- **Output Directory**: `public`
- **Install Command**: `composer install --no-dev --optimize-autoloader`

Atau gunakan `vercel.json` yang sudah disediakan.

---

## Langkah 5: Deploy

```bash
# Install Vercel CLI
npm i -g vercel

# Login
vercel login

# Deploy ke production
vercel --prod
```

---

## Langkah 6: Post-Deployment

Setelah deploy berhasil, jalankan migrasi database:

```bash
# Via Vercel CLI
vercel env pull .env
php artisan migrate --force
php artisan db:seed --class=DummyDataSeeder --force
```

Atau gunakan Vercel Cron Jobs / GitHub Actions untuk menjalankan migrasi otomatis.

---

## Catatan Penting

1. **SQLite tidak disimpan** di Vercel — gunakan PostgreSQL/MySQL eksternal
2. **File upload** disimpan di `storage/app/public` — pastikan disk `public` dikonfigurasi
3. **Queue** gunakan `sync` driver di Vercel (tidak ada daemon queue)
4. **Session** gunakan `database` driver (bukan file)
5. **Cache** gunakan `database` driver (bukan file/redis)
6. **APP_DEBUG=false** di production untuk keamanan
