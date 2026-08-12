# Panduan Tema Design & Layout: "Professional Polish"
## Portal Digital DJKI Indonesia (Direktorat Jenderal Kekayaan Intelektual - Kemenkumham RI)

---

### 1. Ringkasan Identitas Visual (Visual Identity Overview)
Tema **"Professional Polish"** dirancang khusus untuk portal resmi pemerintahan dan instansi publik berstandar internasional. Tema ini mengombinasikan warna **Deep Navy** khas institusi negara dengan **Republic Red** sebagai aksen tindakan utama (*Call-to-Action*), serta latarnya yang bersih berbasis **Slate & White** untuk memberikan keterbacaan (*readability*) dan kepercayaan (*trustworthiness*) maksimal.

---

### 2. Sistem Warna (Color Palette System)

#### 2.1. Warna Utama (Primary Colors)
| Kategori | Nama Warna | Kode Hex | Kelas Tailwind | Penggunaan |
|---|---|---|---|---|
| **Primary Navy** | Government Navy | `#002855` | `bg-[#002855]`, `text-[#002855]` | Top Header, Navigation Emblem, Dark Cards, Footer |
| **Primary Navy Dark** | Midnight Navy | `#001D3D` | `bg-[#001D3D]` | Deep Backgrounds, Modal Overlays |
| **Primary Navy Gradient** | Ocean Blue | `#00509D` | `from-[#003366] to-[#00509d]` | Hero Banner Background |

#### 2.2. Warna Aksen & Action (Accent & CTA Colors)
| Kategori | Nama Warna | Kode Hex | Kelas Tailwind | Penggunaan |
|---|---|---|---|---|
| **Accent Red** | Republic Red | `#DC2626` | `bg-red-600`, `text-red-600` | Tombol Utama (CTA), Highlight Text, Border Active |
| **Accent Red Hover** | Dark Red | `#B91C1C` | `hover:bg-red-700` | State Hover Tombol Utama |
| **Secondary Accent** | Warning Gold | `#D97706` | `bg-amber-500`, `text-amber-400` | Badge Status, Warning, Sub-informasi |
| **Success Emerald** | Verified Green | `#059669` | `bg-emerald-600`, `text-emerald-600` | Status Terdaftar, Sertifikat Valid |

#### 2.3. Warna Netral & Latar (Neutral & Canvas Colors)
| Kategori | Nama Warna | Kode Hex | Kelas Tailwind | Penggunaan |
|---|---|---|---|---|
| **Light Canvas** | Slate 50 | `#F8FAFC` | `bg-slate-50` | Latar Belakang Aplikasi Mode Terang |
| **Container Card** | Pure White | `#FFFFFF` | `bg-white` | Card Informasi, Box Input, Dropdown |
| **Border Neutral** | Slate 200 | `#E2E8F0` | `border-slate-200` | Pembatas Card & Input Fields |
| **Text Dark** | Slate 900 | `#0F172A` | `text-slate-900` | Judul Utama, Body Text Utama |
| **Text Muted** | Slate 500 | `#64748B` | `text-slate-500` | Subtitle, Deskripsi Sekunder, Timestamp |

---

### 3. Tipografi & Hirarki Teks (Typography Hierarchy)

* **Font Family**: Sans-serif standar modern (Plus Jakarta Sans / Inter fallback).
* **Prinsip Judul**: Menggunakan huruf kapital (*Uppercase*) dengan pelacakan huruf berjarak (*tracking-wide*) untuk judul seksi & tombol navigasi.

```scss
/* Contoh Skala Tipografi */
h1.hero-title     => text-3xl sm:text-4xl lg:text-5xl | font-extrabold | tracking-tight
h2.section-title  => text-3xl                       | font-extrabold | tracking-tight
h3.card-title     => text-lg                        | font-bold      | uppercase | tracking-wide
p.body-text       => text-xs sm:text-sm             | font-normal    | leading-relaxed
span.badge-label  => text-[10px] sm:text-[11px]     | font-bold      | uppercase | tracking-wider
```

---

### 4. Template Komponen Reusable (Component Templates)

#### 4.1. Top Government Header Bar
```html
<div class="bg-[#002855] text-white py-1 px-4 sm:px-8 flex justify-between items-center text-[11px] font-medium border-b border-blue-950/60">
  <div class="flex items-center space-x-3">
    <span class="font-bold tracking-wider text-slate-100">KEMENTERIAN HUKUM DAN HAK ASASI MANUSIA RI</span>
    <span class="text-blue-300/40">|</span>
    <span class="text-blue-200 font-semibold hidden md:inline tracking-wide">DIREKTORAT JENDERAL KEKAYAAN INTELEKTUAL</span>
  </div>
  <div class="flex items-center space-x-3">
    <a href="tel:152" class="bg-red-600 hover:bg-red-700 text-white px-2.5 py-0.5 rounded text-[11px] font-bold transition shadow-xs">
      CALL CENTER 152
    </a>
    <button class="bg-red-600 hover:bg-red-700 text-white px-2.5 py-0.5 rounded font-bold text-[11px] transition shadow-xs uppercase tracking-wide">
      HALO DJKI
    </button>
  </div>
</div>
```

#### 4.2. Navigation Bar
```html
<header class="bg-white border-b border-slate-200 px-6 py-4 flex justify-between items-center">
  <div class="flex items-center space-x-3">
    <div class="w-11 h-11 bg-[#002855] rounded flex items-center justify-center text-white font-bold text-xs text-center leading-tight shadow-xs">
      DJKI
    </div>
    <div>
      <h1 class="text-base font-extrabold text-slate-900 leading-none tracking-tight">DJKI INDONESIA</h1>
      <p class="text-[10px] text-slate-500 uppercase tracking-widest font-semibold mt-1">Intellectual Property Office</p>
    </div>
  </div>
  <nav class="hidden lg:flex items-center space-x-6 text-sm font-semibold tracking-wide uppercase text-slate-700">
    <a href="#" class="text-red-600 border-b-2 border-red-600 font-bold py-2">BERANDA</a>
    <a href="#" class="border-b-2 border-transparent hover:text-red-600 py-2">PROFIL</a>
    <a href="#" class="border-b-2 border-transparent hover:text-red-600 py-2">LAYANAN</a>
    <a href="#" class="border-b-2 border-transparent hover:text-red-600 py-2">DATABASE</a>
    <a href="#" class="border-b-2 border-transparent hover:text-red-600 py-2">BERITA</a>
  </nav>
  <button class="bg-[#002855] hover:bg-[#003366] text-white px-5 py-2.5 rounded-md text-xs font-bold uppercase tracking-wider transition shadow-xs">
    LOGIN PERMOHONAN
  </button>
</header>
```

#### 4.3. Hero Banner dengan Mesh Pattern & Glow Effect
```html
<section class="relative bg-gradient-to-r from-[#003366] to-[#00509d] text-white overflow-hidden py-16 px-8">
  <!-- Grid SVG Pattern Overlay -->
  <div class="absolute inset-0 opacity-20 pointer-events-none">
    <svg width="100%" height="100%" viewBox="0 0 1024 280">
      <pattern id="grid-pattern" width="40" height="40" patternUnits="userSpaceOnUse">
        <path d="M 40 0 L 0 0 0 40" fill="none" stroke="white" stroke-width="0.5"/>
      </pattern>
      <rect width="100%" height="100%" fill="url(#grid-pattern)" />
    </svg>
  </div>

  <!-- Red Ambient Blur -->
  <div class="absolute right-[-100px] bottom-[-50px] w-[500px] h-[500px] bg-red-600/10 rounded-full blur-[100px] pointer-events-none"></div>

  <!-- Content Box -->
  <div class="relative z-10 max-w-2xl space-y-5">
    <div class="inline-flex items-center space-x-2 bg-red-600/20 border border-red-500/40 text-red-300 px-3 py-1 rounded text-xs font-extrabold tracking-wider uppercase">
      PERMOHONAN E-FILING 24/7
    </div>
    <h2 class="text-4xl font-extrabold text-white leading-tight">
      Lindungi Karya <span class="text-red-400">Inovasi</span> & <span class="text-red-400">Kreativitas</span> Anda
    </h2>
    <p class="text-blue-100 text-base leading-relaxed">
      Daftarkan Paten, Merek, Hak Cipta, dan Desain Industri secara online melalui sistem permohonan mandiri kami.
    </p>
    <div class="flex gap-4 pt-2">
      <button class="bg-red-600 hover:bg-red-700 text-white font-bold px-8 py-3 rounded shadow-lg shadow-red-900/20 text-sm uppercase tracking-wider">
        DAFTAR AKUN
      </button>
      <button class="bg-white/10 hover:bg-white/20 border border-white/30 text-white font-bold px-8 py-3 rounded backdrop-blur-sm text-sm uppercase tracking-wider">
        PANDUAN LAYANAN
      </button>
    </div>
  </div>
</section>
```

#### 4.4. Service Card (Standard Grid Item)
```html
<div class="bg-white rounded-xl border border-slate-200 hover:border-red-500 p-6 shadow-sm hover:shadow-md transition-all duration-200 flex flex-col justify-between group cursor-pointer">
  <div>
    <div class="flex items-center justify-between gap-2 mb-4">
      <div class="w-12 h-12 bg-red-50 text-red-600 rounded-lg flex items-center justify-center font-bold">
        <!-- SVG Icon Here -->
      </div>
      <span class="text-[11px] font-bold bg-slate-100 text-slate-700 px-2.5 py-1 rounded border border-slate-200 uppercase tracking-wider">
        MEREK
      </span>
    </div>
    <h3 class="text-lg font-bold text-slate-900 group-hover:text-red-600 transition-colors mb-1.5 uppercase tracking-wide">
      Pendaftaran Merek
    </h3>
    <p class="text-xs text-slate-500 leading-relaxed mb-4">
      Pelindungan logo, nama bisnis, slogan, dan identitas komersial produk Anda.
    </p>
  </div>
  <button class="w-full bg-[#002855] hover:bg-[#003366] text-white font-bold text-xs py-2.5 px-3 rounded-md transition flex items-center justify-center space-x-1.5 uppercase tracking-wider">
    <span>PANDUAN & SYARAT</span>
  </button>
</div>
```

#### 4.5. Footer & Sub-Footer
```html
<footer class="bg-[#002855] text-white pt-12 border-t-4 border-red-600">
  <div class="max-w-7xl mx-auto px-6 pb-8 grid grid-cols-1 md:grid-cols-4 gap-8">
    <!-- Footer Columns -->
  </div>
  
  <!-- Sub-footer Bar -->
  <div class="bg-slate-100 border-t border-slate-200 px-6 sm:px-12 py-4 flex flex-col sm:flex-row items-center justify-between gap-4 text-[11px] text-slate-500">
    <div>© 2026 Direktorat Jenderal Kekayaan Intelektual - Kemenkumham RI</div>
    <div class="flex items-center space-x-6 font-semibold">
      <a href="#" class="hover:text-slate-800 transition">Syarat & Ketentuan</a>
      <a href="#" class="hover:text-slate-800 transition">Kebijakan Privasi</a>
      <a href="#" class="hover:text-slate-800 transition">Peta Situs</a>
    </div>
  </div>
</footer>
```

---

### 5. Aturan Styling & Anti-Pattern (Design Rules & Guidelines)

1. **Aturan Radius Sudut (Border Radius)**:
   - Gunakan `rounded-md` atau `rounded-xl` (Maksimal 12px) untuk card dan button standar.
   - Hindari penggunaan `rounded-3xl` berlebihan pada komponen formulir formal atau tabel pemerintah.

2. **Aturan Kontras & Keterbacaan**:
   - Selalu gunakan teks putih (`text-white`) atau biru terang (`text-blue-100`) di atas background Deep Navy (`#002855`).
   - Gunakan teks `text-slate-900` untuk heading dan `text-slate-500` untuk body text di atas latar putih (`bg-white`).

3. **Aturan Hover Effect**:
   - Card interaktif wajib memiliki batas tipis Slate `border-slate-200` yang berubah menjadi Red `hover:border-red-500` dengan elevasi bayangan halus `hover:shadow-md`.
