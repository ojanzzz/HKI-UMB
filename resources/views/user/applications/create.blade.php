@extends('layouts.dashboard')

@section('title', 'Pengajuan Baru HKI - Sentra HKI UM BIMA')

@section('content')
<div class="max-w-6xl mx-auto space-y-6 py-2">
    
    <!-- Top Bar Title Banner -->
    <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-xs flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">Pengajuan Baru</h2>
            <p class="text-xs text-slate-500 mt-0.5">Layanan pengajuan KI yang modern, lapang, dan interaktif.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('faq') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold px-4 py-2 rounded-xl text-xs uppercase tracking-wider transition">
                Bantuan
            </a>
            <button type="button" onclick="document.getElementById('applicationForm').submit()" class="bg-blue-600 hover:bg-blue-700 text-white font-extrabold px-6 py-2 rounded-xl text-xs uppercase tracking-wider transition shadow-sm">
                Ajukan KI
            </button>
        </div>
    </div>

    <!-- Stepper Navigation Header (5 Steps Wizard with Dynamic Checkmarks ✓) -->
    <div class="bg-white rounded-2xl border border-slate-200 p-3 shadow-xs">
        <div class="grid grid-cols-5 gap-2 text-center text-xs font-bold uppercase tracking-wider">
            <button type="button" onclick="goToStep(1)" id="stepTab1" class="py-3 px-2 rounded-xl bg-blue-600 text-white border border-blue-600 font-extrabold transition flex items-center justify-center gap-1">
                <span id="checkStep1">✓</span>
                <span>1. Jenis</span>
            </button>
            <button type="button" onclick="goToStep(2)" id="stepTab2" class="py-3 px-2 rounded-xl bg-slate-50 text-slate-400 hover:text-slate-700 transition flex items-center justify-center gap-1">
                <span id="checkStep2" class="hidden text-emerald-600 font-black">✓</span>
                <span>2. Pemohon</span>
            </button>
            <button type="button" onclick="goToStep(3)" id="stepTab3" class="py-3 px-2 rounded-xl bg-slate-50 text-slate-400 hover:text-slate-700 transition flex items-center justify-center gap-1">
                <span id="checkStep3" class="hidden text-emerald-600 font-black">✓</span>
                <span>3. Detail</span>
            </button>
            <button type="button" onclick="goToStep(4)" id="stepTab4" class="py-3 px-2 rounded-xl bg-slate-50 text-slate-400 hover:text-slate-700 transition flex items-center justify-center gap-1">
                <span id="checkStep4" class="hidden text-emerald-600 font-black">✓</span>
                <span>4. Dokumen</span>
            </button>
            <button type="button" onclick="goToStep(5)" id="stepTab5" class="py-3 px-2 rounded-xl bg-slate-50 text-slate-400 hover:text-slate-700 transition flex items-center justify-center gap-1">
                <span>5. Kirim</span>
            </button>
        </div>
    </div>

    <!-- Main Wizard Form Card -->
    <div class="bg-white rounded-2xl border border-slate-200 p-6 md:p-8 shadow-xs space-y-6">
        <form id="applicationForm" action="{{ route('applications.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Hidden inputs to bind card selection & category -->
            <input type="hidden" name="application_type" id="inputApplicationType" value="{{ old('application_type', 'PATEN') }}">

            <!-- ================= STEP 1: PILIH JENIS DAN KATEGORI ================= -->
            <div id="stepContent1" class="space-y-6">
                <div>
                    <h3 class="text-xl font-extrabold text-slate-900">Pilih Jenis dan Kategori</h3>
                    <p class="text-xs text-slate-500 mt-1">Pilih jenis Kekayaan Intelektual yang akan diajukan.</p>
                </div>

                <!-- Jenis KI * Cards Grid Selection -->
                <div class="space-y-2">
                    <label class="block font-bold text-slate-800 uppercase text-xs">Jenis KI <span class="text-red-600">*</span></label>
                    
                    @php
                        $types = \App\Models\ApplicationType::where('is_active', true)->get();
                        
                        $defaultCards = [
                            ['code' => 'MEREK', 'title' => 'Merek', 'subtitle' => 'Merek dagang dan jasa'],
                            ['code' => 'PATEN', 'title' => 'Paten', 'subtitle' => 'Invensi dan teknologi'],
                            ['code' => 'HAK_CIPTA', 'title' => 'Hak Cipta', 'subtitle' => 'Karya seni, sastra, software'],
                            ['code' => 'DESAIN_INDUSTRI', 'title' => 'Desain Industri', 'subtitle' => 'Tampilan visual produk'],
                            ['code' => 'INDIKASI_GEOGRAFIS', 'title' => 'Indikasi Geografis', 'subtitle' => 'Produk asal daerah'],
                            ['code' => 'DTLST', 'title' => 'DTLST', 'subtitle' => 'Desain tata letak sirkuit terpadu'],
                        ];
                    @endphp

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 pt-1">
                        @if($types->count() > 0)
                            @foreach($types as $t)
                                <div onclick="selectKiCard('{{ $t->code }}', this)" class="ki-card border-2 rounded-2xl p-6 text-center cursor-pointer transition-all duration-200 hover:shadow-md border-slate-200 hover:border-blue-400 bg-white">
                                    <h4 class="font-extrabold text-base text-slate-900">{{ $t->name }}</h4>
                                    <p class="text-xs text-slate-500 mt-1 line-clamp-1">{{ $t->description ?: 'Pengajuan Kekayaan Intelektual resmi' }}</p>
                                </div>
                            @endforeach
                        @else
                            @foreach($defaultCards as $card)
                                <div onclick="selectKiCard('{{ $card['code'] }}', this)" class="ki-card border-2 rounded-2xl p-6 text-center cursor-pointer transition-all duration-200 hover:shadow-md border-slate-200 hover:border-blue-400 bg-white">
                                    <h4 class="font-extrabold text-base text-slate-900">{{ $card['title'] }}</h4>
                                    <p class="text-xs text-slate-500 mt-1">{{ $card['subtitle'] }}</p>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>

                <!-- Kategori Pengajuan * (Dynamic from Master Admin) -->
                <div class="space-y-2 pt-2">
                    <label for="application_category" class="block font-bold text-slate-800 uppercase text-xs">Kategori Pengajuan <span class="text-red-600">*</span></label>
                    @php
                        $categories = \App\Models\ApplicationCategory::where('is_active', true)->orderBy('name')->get();
                    @endphp
                    <select id="application_category" name="application_category" required class="w-full border border-slate-300 rounded-xl p-3.5 text-slate-900 font-medium focus:outline-none focus:border-blue-600 bg-white text-xs">
                        <option value="">-- Pilih Kategori Pengajuan HKI --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->code }}" {{ old('application_category') == $cat->code ? 'selected' : '' }}>
                                {{ $cat->name }} ({{ $cat->description ?: 'Tarif & Subjek ' . $cat->name }})
                            </option>
                        @endforeach
                        @if($categories->isEmpty())
                            <option value="UMKM" selected>UMKM (Usaha Mikro, Kecil, dan Menengah)</option>
                            <option value="PERGURUAN_TINGGI">Perguruan Tinggi (Dosen, Peneliti, Mahasiswa)</option>
                            <option value="UMUM">Umum / Perorangan</option>
                            <option value="LITBANG">Lembaga Litbang Industri</option>
                        @endif
                    </select>
                </div>

                <div class="pt-4 flex justify-start">
                    <button type="button" onclick="goToStep(2)" class="bg-blue-600 hover:bg-blue-700 text-white font-extrabold px-8 py-3 rounded-xl text-xs uppercase tracking-wider transition shadow-sm">
                        Lanjutkan &rarr;
                    </button>
                </div>
            </div>

            <!-- ================= STEP 2: DETAIL ANGGOTA / PEMOHON ================= -->
            <div id="stepContent2" class="hidden space-y-6">
                <div>
                    <h3 class="text-xl font-extrabold text-slate-900">Detail Anggota / Pemohon</h3>
                    <p class="text-xs text-slate-500 mt-1">Lengkapi identitas setiap anggota. Kolom bertanda <span class="text-red-600">*</span> wajib diisi. Kolom NIK, NIM, dan Fakultas bersifat opsional.</p>
                </div>

                <!-- Confirmation Card (read-only reference) -->
                <div class="bg-slate-50 rounded-2xl border border-slate-200 p-6 space-y-4 text-xs">
                    <h4 class="font-extrabold text-slate-800 uppercase text-[10px]">Data Pemohon Terdaftar di Akun</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <span class="block text-slate-500 font-bold uppercase text-[10px]">Nama Pemohon</span>
                            <span class="font-extrabold text-slate-900 text-sm">{{ auth()->user()->name }}</span>
                        </div>
                        <div>
                            <span class="block text-slate-500 font-bold uppercase text-[10px]">Alamat Email</span>
                            <span class="font-bold text-slate-900">{{ auth()->user()->email }}</span>
                        </div>
                        <div>
                            <span class="block text-slate-500 font-bold uppercase text-[10px]">NIK / NIP / NIM</span>
                            <span class="font-mono font-bold text-slate-900">{{ auth()->user()->nik ?? auth()->user()->identity_number ?? '-' }}</span>
                        </div>
                        <div>
                            <span class="block text-slate-500 font-bold uppercase text-[10px]">Fakultas / Unit Kerja</span>
                            <span class="font-bold text-slate-900">{{ auth()->user()->faculty ?: 'Universitas Muhammadiyah Bima' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Dynamic List of Applicants -->
                <div class="space-y-4">
                    <h4 class="font-extrabold text-slate-800 uppercase text-[10px] tracking-wider">Daftar Anggota / Pemohon</h4>

                    <div id="applicantsList" class="space-y-4">
                        @php
                            $existingApplicants = old('applicants', [
                                [
                                    'applicant_name' => auth()->user()->name,
                                    'applicant_address' => '',
                                    'applicant_nik' => auth()->user()->nik ?? auth()->user()->identity_number,
                                    'applicant_nip' => auth()->user()->nip,
                                    'applicant_nim' => auth()->user()->nim,
                                    'applicant_faculty' => auth()->user()->faculty,
                                ],
                                [
                                    'applicant_name' => 'Diah Ayu Wulandari',
                                    'applicant_address' => 'Jl. Merdeka No. 12, Mataram, NTB',
                                    'applicant_nik' => '5206011504850003',
                                    'applicant_nip' => '198809012019031002',
                                    'applicant_nim' => '41520010023',
                                    'applicant_faculty' => 'Fakultas Ilmu Komputer',
                                ],
                            ]);
                            $allFaculties = \App\Models\Faculty::orderBy('name')->get();
                            $facultyOptions = '<option value="">-- Pilih Fakultas / Unit --</option>';
                            foreach ($allFaculties as $fac) {
                                $facultyOptions .= '<option value="' . $fac->name . '">' . $fac->name . '</option>';
                            }
                        @endphp

                        @if(is_array($existingApplicants) && count($existingApplicants) > 0)
                            @foreach($existingApplicants as $index => $applicant)
                                @include('user.applications.partials.applicant-row', [
                                    'index' => $index,
                                    'applicant' => $applicant,
                                    'faculties' => $allFaculties,
                                    'showRemove' => count($existingApplicants) > 1,
                                ])
                            @endforeach
                        @else
                            @include('user.applications.partials.applicant-row', [
                                'index' => 0,
                                'applicant' => [
                                    'applicant_name' => auth()->user()->name,
                                    'applicant_address' => '',
                                    'applicant_nik' => auth()->user()->nik ?? auth()->user()->identity_number,
                                    'applicant_nip' => auth()->user()->nip,
                                    'applicant_nim' => auth()->user()->nim,
                                    'applicant_faculty' => auth()->user()->faculty,
                                ],
                                'faculties' => $allFaculties,
                                'showRemove' => false,
                            ])
                        @endif
                    </div>

                    <div class="flex items-center gap-3 pt-2">
                        <button type="button" onclick="addApplicant()" class="bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold px-5 py-2.5 rounded-xl text-xs uppercase tracking-wider transition shadow-sm flex items-center gap-1">
                            <span>+</span>
                            <span>Tambah Anggota</span>
                        </button>
                        <span class="text-[10px] text-slate-500">Klik untuk menambahkan anggota baru (mis. teman seperjuangan / co-inventor).</span>
                    </div>
                </div>

                <div class="pt-4 flex justify-between">
                    <button type="button" onclick="goToStep(1)" class="bg-slate-200 hover:bg-slate-300 text-slate-800 font-bold px-6 py-3 rounded-xl text-xs uppercase">
                        &larr; Kembali
                    </button>
                    <button type="button" onclick="goToStep(3)" class="bg-blue-600 hover:bg-blue-700 text-white font-extrabold px-8 py-3 rounded-xl text-xs uppercase tracking-wider transition shadow-sm">
                        Lanjutkan &rarr;
                    </button>
                </div>
            </div>

            <!-- ================= STEP 3: DETAIL INVENSI / KARYA & FOTO PRODUK ================= -->
            <div id="stepContent3" class="hidden space-y-6">
                <div>
                    <h3 class="text-xl font-extrabold text-slate-900">Detail Invensi & Foto Produk HKI</h3>
                    <p class="text-xs text-slate-500 mt-1">Masukkan judul resmi karya, deskripsi singkat, dan foto produk invensi Anda.</p>
                </div>

                <div class="space-y-4 text-xs">
                    <div>
                        <label for="title" class="block font-bold text-slate-800 uppercase mb-1">Judul Invensi / Karya HKI <span class="text-red-600">*</span></label>
                        <input type="text" id="title" name="title" required value="{{ old('title') }}" placeholder="Contoh: Alat Pengolah Limbah Plastik Berbasis Sensor IOT Deep Learning" class="w-full border border-slate-300 rounded-xl p-3.5 text-slate-900 focus:outline-none focus:border-blue-600 font-medium">
                    </div>

                    <div>
                        <label for="description" class="block font-bold text-slate-800 uppercase mb-1">Deskripsi Singkat Invensi / Karya</label>
                        <textarea id="description" name="description" rows="3" placeholder="Jelaskan ringkasan keunggulan, kebaruan, atau fungsi utama invensi Anda..." class="w-full border border-slate-300 rounded-xl p-3.5 text-slate-900 focus:outline-none focus:border-blue-600 font-medium">{{ old('description') }}</textarea>
                    </div>

                    <!-- Task 1: Upload Foto Produk Invensi HKI -->
                    <div class="bg-blue-50/60 border border-blue-200 rounded-xl p-4 space-y-2">
                        <label for="product_image" class="block font-extrabold text-slate-900 uppercase text-xs">
                            📷 Upload Foto Produk / Visual Invensi HKI <span class="text-slate-400 font-normal">(Opsional)</span>
                        </label>
                        <input type="file" id="product_image" name="product_image" accept="image/jpeg,image/png,image/jpg" class="w-full text-xs text-slate-600 border border-slate-300 rounded-lg bg-white p-2 file:mr-3 file:py-1 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-bold file:bg-blue-600 file:text-white hover:file:bg-blue-700">
                        <p class="text-[10px] text-slate-500">Format gambar: JPG, PNG, JPEG (Maksimal 5MB). Foto produk akan ditampilkan pada pratinjau detail permohonan HKI Anda.</p>
                    </div>
                </div>

                <div class="pt-4 flex justify-between">
                    <button type="button" onclick="goToStep(2)" class="bg-slate-200 hover:bg-slate-300 text-slate-800 font-bold px-6 py-3 rounded-xl text-xs uppercase">
                        &larr; Kembali
                    </button>
                    <button type="button" onclick="goToStep(4)" class="bg-blue-600 hover:bg-blue-700 text-white font-extrabold px-8 py-3 rounded-xl text-xs uppercase tracking-wider transition shadow-sm">
                        Lanjutkan &rarr;
                    </button>
                </div>
            </div>

            <!-- ================= STEP 4: UNDUH TEMPLATE & UPLOAD DOKUMEN (TASK 2 IMPROVED LAYOUT) ================= -->
            <div id="stepContent4" class="hidden space-y-6">
                <div>
                    <h3 class="text-xl font-extrabold text-slate-900">Informasi 8 Formulir Dokumen HKI</h3>
                    <p class="text-xs text-slate-500 mt-1">Unduh template Word (.docx) resmi yang diberikan oleh Admin dan siapkan file dokumen Anda.</p>
                </div>

                @php
                    $templatesMap = \App\Http\Controllers\HkiApplicationController::TEMPLATES_MAP;
                @endphp

                <!-- Grid 8 Slot Dokumen (Unduh Template Tombol + Info Format) -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    @foreach($templatesMap as $docKey => $info)
                        <div class="bg-slate-50 rounded-2xl border border-slate-200 p-5 space-y-3 hover:border-blue-400 transition-colors shadow-xs">
                            <div class="flex items-center justify-between border-b border-slate-200 pb-2">
                                <h4 class="font-extrabold text-slate-900 text-xs flex items-center gap-1.5">
                                    <span>📄</span>
                                    <span>{{ $info['label'] }}</span>
                                </h4>

                                <!-- Unduh Template Word (.docx) Official Button -->
                                <a href="{{ route('templates.download', $docKey) }}" class="bg-amber-500 hover:bg-amber-600 text-slate-950 font-extrabold px-3 py-1.5 rounded-lg text-[10px] uppercase tracking-wider transition shadow-xs flex items-center gap-1 shrink-0">
                                    <span>📥</span>
                                    <span>UNDUH TEMPLATE</span>
                                </a>
                            </div>

                            <div class="space-y-1">
                                <label class="block text-[10px] font-bold text-slate-700 uppercase">Status & Petunjuk File:</label>
                                <div class="bg-white border border-slate-200 p-2.5 rounded-lg text-[11px] text-slate-600 font-medium">
                                    Format diperbolehkan: <span class="font-bold text-slate-900">.pdf, .docx, .doc, .png, .jpg, .zip</span> (Maks 15MB)
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="pt-4 flex justify-between">
                    <button type="button" onclick="goToStep(3)" class="bg-slate-200 hover:bg-slate-300 text-slate-800 font-bold px-6 py-3 rounded-xl text-xs uppercase">
                        &larr; Kembali
                    </button>
                    <button type="button" onclick="goToStep(5)" class="bg-blue-600 hover:bg-blue-700 text-white font-extrabold px-8 py-3 rounded-xl text-xs uppercase tracking-wider transition shadow-sm">
                        Lanjutkan Ke Step Akhir &rarr;
                    </button>
                </div>
            </div>

            <!-- ================= STEP 5: KIRIM & SIMPAN DRAFT ================= -->
            <div id="stepContent5" class="hidden space-y-6">
                <div class="text-center py-6 space-y-3">
                    <div class="w-16 h-16 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center mx-auto text-3xl font-extrabold">
                        🚀
                    </div>
                    <h3 class="text-2xl font-extrabold text-slate-900">Siap Mengajukan Permohonan HKI</h3>
                    <p class="text-xs text-slate-500 max-w-md mx-auto">Klik tombol di bawah untuk menyimpan pengajuan HKI ke dalam daftar draft Anda dan mulai mengunggah formulir dokumen.</p>
                </div>

                <div class="pt-4 flex justify-between border-t border-slate-100">
                    <button type="button" onclick="goToStep(4)" class="bg-slate-200 hover:bg-slate-300 text-slate-800 font-bold px-6 py-3 rounded-xl text-xs uppercase">
                        &larr; Kembali
                    </button>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-extrabold px-10 py-3.5 rounded-xl text-xs uppercase tracking-wider transition shadow-md flex items-center space-x-2">
                        <span>SIMPAN KE DRAFT & KELOLA DOKUMEN</span>
                        <span>&rarr;</span>
                    </button>
                </div>
            </div>

        </form>
    </div>
</div>

<script>
    const facultyOptionsHtml = `{!! $facultyOptions !!}`;
    const completedSteps = {
        1: true, // Step 1 default selected PATEN
        2: false,
        3: false,
        4: false,
        5: false
    };

    function selectKiCard(code, element) {
        document.getElementById('inputApplicationType').value = code;
        
        document.querySelectorAll('.ki-card').forEach(card => {
            card.classList.remove('border-blue-600', 'bg-blue-50/70', 'ring-2', 'ring-blue-400');
            card.classList.add('border-slate-200', 'bg-white');
        });

        element.classList.remove('border-slate-200', 'bg-white');
        element.classList.add('border-blue-600', 'bg-blue-50/70', 'ring-2', 'ring-blue-400');

        completedSteps[1] = true;
        updateCheckmarks();
    }

    function updateCheckmarks() {
        for (let i = 1; i <= 4; i++) {
            const check = document.getElementById('checkStep' + i);
            const tab = document.getElementById('stepTab' + i);
            
            if (completedSteps[i]) {
                if (check) check.classList.remove('hidden');
                tab.classList.add('border-emerald-300', 'text-emerald-900');
            }
        }
    }

    function updateApplicantRowNumbers() {
        document.querySelectorAll('.applicant-row').forEach((row, i) => {
            var header = row.querySelector('h4');
            if (header) {
                header.textContent = 'Anggota #' + (i + 1);
            }
            var removeBtn = row.querySelector('button[onclick*="removeApplicant"]');
            if (removeBtn) {
                removeBtn.style.display = (document.querySelectorAll('.applicant-row').length > 1) ? '' : 'none';
            }
        });
    }

    function addApplicant() {
        var rows = document.querySelectorAll('.applicant-row');
        var newIndex = 0;
        rows.forEach(function(row) {
            var num = parseInt(row.id.replace('applicantRow', ''));
            if (num >= newIndex) newIndex = num + 1;
        });

        var dummyName = 'Contoh Nama Anggota';
        var dummyAddress = 'Jl. Contoh No. 1, Kota Anda';
        var dummyNik = '5206011504850003';

        var html = '';
        html += '<div id="applicantRow' + newIndex + '" class="bg-white rounded-2xl border border-slate-200 p-5 space-y-4 shadow-xs applicant-row">';
        html += '<div class="flex items-center justify-between border-b border-slate-200 pb-3">';
        html += '<h4 class="font-extrabold text-slate-900 text-xs uppercase tracking-wider">Anggota #' + (newIndex + 1) + '</h4>';
        html += '<button type="button" onclick="removeApplicant(' + newIndex + ')" class="bg-red-100 hover:bg-red-200 text-red-700 font-extrabold px-3 py-1 rounded-lg text-[10px] uppercase tracking-wider transition flex items-center gap-1"><span>&times;</span><span>Hapus</span></button>';
        html += '</div>';
        html += '<div class="grid grid-cols-1 md:grid-cols-2 gap-4">';
        html += '<div>';
        html += '<label for="applicants_' + newIndex + '_applicant_name" class="block font-bold text-slate-800 uppercase text-xs mb-1">Nama Lengkap <span class="text-red-600">*</span></label>';
        html += '<input type="text" id="applicants_' + newIndex + '_applicant_name" name="applicants[' + newIndex + '][applicant_name]" value="' + dummyName + '" required placeholder="Masukkan nama lengkap sesuai KTP" class="w-full border border-slate-300 rounded-xl p-3.5 text-slate-900 focus:outline-none focus:border-blue-600 font-medium text-xs">';
        html += '</div>';
        html += '<div class="md:col-span-2">';
        html += '<label for="applicants_' + newIndex + '_applicant_address" class="block font-bold text-slate-800 uppercase text-xs mb-1">Alamat <span class="text-red-600">*</span></label>';
        html += '<textarea id="applicants_' + newIndex + '_applicant_address" name="applicants[' + newIndex + '][applicant_address]" required rows="2" placeholder="Masukkan alamat lengkap sesuai KTP" class="w-full border border-slate-300 rounded-xl p-3.5 text-slate-900 focus:outline-none focus:border-blue-600 font-medium text-xs resize-y">' + dummyAddress + '</textarea>';
        html += '</div>';
        html += '<div>';
        html += '<label for="applicants_' + newIndex + '_applicant_nik" class="block font-bold text-slate-800 uppercase text-xs mb-1">NIK <span class="text-red-600">*</span></label>';
        html += '<input type="text" id="applicants_' + newIndex + '_applicant_nik" name="applicants[' + newIndex + '][applicant_nik]" value="' + dummyNik + '" required placeholder="Nomor Induk Kependudukan" class="w-full border border-slate-300 rounded-xl p-3.5 text-slate-900 focus:outline-none focus:border-blue-600 font-medium text-xs">';
        html += '</div>';
        html += '<div>';
        html += '<label for="applicants_' + newIndex + '_applicant_nip" class="block font-bold text-slate-800 uppercase text-xs mb-1">NIP <span class="text-slate-400 font-normal">(Opsional)</span></label>';
        html += '<input type="text" id="applicants_' + newIndex + '_applicant_nip" name="applicants[' + newIndex + '][applicant_nip]" placeholder="Nomor Induk Pegawai / Dosen" class="w-full border border-slate-300 rounded-xl p-3.5 text-slate-900 focus:outline-none focus:border-blue-600 font-medium text-xs">';
        html += '</div>';
        html += '<div>';
        html += '<label for="applicants_' + newIndex + '_applicant_nim" class="block font-bold text-slate-800 uppercase text-xs mb-1">NIM <span class="text-slate-400 font-normal">(Opsional)</span></label>';
        html += '<input type="text" id="applicants_' + newIndex + '_applicant_nim" name="applicants[' + newIndex + '][applicant_nim]" placeholder="Nomor Induk Mahasiswa" class="w-full border border-slate-300 rounded-xl p-3.5 text-slate-900 focus:outline-none focus:border-blue-600 font-medium text-xs">';
        html += '</div>';
        html += '<div>';
        html += '<label for="applicants_' + newIndex + '_applicant_faculty" class="block font-bold text-slate-800 uppercase text-xs mb-1">Fakultas / Unit Kerja <span class="text-slate-400 font-normal">(Opsional)</span></label>';
        html += '<select id="applicants_' + newIndex + '_applicant_faculty" name="applicants[' + newIndex + '][applicant_faculty]" class="w-full border border-slate-300 rounded-xl p-3.5 text-slate-900 focus:outline-none focus:border-blue-600 font-medium text-xs bg-white">' + facultyOptionsHtml + '</select>';
        html += '</div>';
        html += '</div>';
        html += '</div>';

        document.getElementById('applicantsList').insertAdjacentHTML('beforeend', html);
        updateApplicantRowNumbers();
    }

    function removeApplicant(index) {
        var row = document.getElementById('applicantRow' + index);
        if (row) {
            row.remove();
            updateApplicantRowNumbers();
        }
    }

    function goToStep(stepNumber) {
        // Mark previous steps as completed when navigating forward
        for (let i = 1; i < stepNumber; i++) {
            completedSteps[i] = true;
        }

        updateCheckmarks();

        for (let i = 1; i <= 5; i++) {
            document.getElementById('stepContent' + i).classList.add('hidden');
            const tab = document.getElementById('stepTab' + i);
            
            if (completedSteps[i] && i !== stepNumber) {
                tab.className = "py-3 px-2 rounded-xl bg-emerald-100/70 text-emerald-900 border border-emerald-300 font-extrabold transition flex items-center justify-center gap-1";
            } else if (i === stepNumber) {
                tab.className = "py-3 px-2 rounded-xl bg-blue-600 text-white border border-blue-600 font-extrabold transition flex items-center justify-center gap-1 shadow-xs";
            } else {
                tab.className = "py-3 px-2 rounded-xl bg-slate-50 text-slate-400 hover:text-slate-700 transition flex items-center justify-center gap-1";
            }
        }

        document.getElementById('stepContent' + stepNumber).classList.remove('hidden');
    }

    document.addEventListener('DOMContentLoaded', function () {
        const firstCard = document.querySelector('.ki-card');
        if (firstCard) {
            selectKiCard('PATEN', firstCard);
        }
        updateCheckmarks();
        updateApplicantRowNumbers();
    });
</script>
@endsection
