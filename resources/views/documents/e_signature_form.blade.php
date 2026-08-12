@extends('layouts.dashboard')

@section('title', 'E-Signature & Generator Surat - Sistem Informasi HKI UMB')

@section('content')
<div class="max-w-4xl mx-auto my-8 p-6 bg-white rounded-xl border border-slate-200 shadow-md">
    
    <!-- Header Modal / Card (per theme.md) -->
    <div class="bg-[#002855] text-white p-5 rounded-t-xl -m-6 mb-6 flex justify-between items-center">
        <div>
            <span class="bg-red-600 text-white text-[10px] font-extrabold px-2.5 py-1 rounded uppercase tracking-wider">
                METODE 2: WEB-TO-PDF & E-SIGNATURE
            </span>
            <h2 class="text-lg font-extrabold uppercase tracking-wide mt-2">
                Surat {{ strtoupper(str_replace('_', ' ', $docType)) }}
            </h2>
            <p class="text-xs text-blue-200 mt-0.5">Lengkapi formulir di bawah ini dan gambar Tanda Tangan Digital Anda pada kanvas HTML5.</p>
        </div>
        <a href="{{ route('applications.show', $application->id) }}" class="text-white hover:text-red-400 font-bold text-xs uppercase tracking-wider">
            &larr; KEMBALI
        </a>
    </div>

    <form id="eSignatureForm" action="{{ route('applications.generate-pdf', $application->id) }}" method="POST" class="space-y-6">
        @csrf
        <input type="hidden" name="document_type" value="{{ $docType }}">
        <!-- Hidden input untuk menyimpan Base64 TTD dari JavaScript -->
        <input type="hidden" id="signature_base64" name="signature_base64" value="">

        <!-- Detail Permohonan -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs">
            <div>
                <label for="title_statement" class="block font-bold text-slate-900 uppercase tracking-wide mb-1">
                    Judul Invensi / Pernyataan <span class="text-red-600">*</span>
                </label>
                <input type="text" id="title_statement" name="title_statement" value="{{ old('title_statement', $application->title) }}" required class="w-full border border-slate-200 rounded-md py-2 px-3 text-slate-900 focus:outline-none focus:border-red-500 font-medium">
            </div>

            <div>
                <label for="statement_date" class="block font-bold text-slate-900 uppercase tracking-wide mb-1">
                    Tanggal Surat Pernyataan <span class="text-red-600">*</span>
                </label>
                <input type="date" id="statement_date" name="statement_date" value="{{ old('statement_date', date('Y-m-d')) }}" required class="w-full border border-slate-200 rounded-md py-2 px-3 text-slate-900 focus:outline-none focus:border-red-500 font-medium">
            </div>

            <div class="md:col-span-2">
                <label for="inventor_names" class="block font-bold text-slate-900 uppercase tracking-wide mb-1">
                    Nama Seluruh Inventor / Pemegang Hak <span class="text-red-600">*</span>
                </label>
                <textarea id="inventor_names" name="inventor_names" rows="2" required placeholder="Contoh: 1. Dr. Ir. Budi Santoso, M.T. 2. Ahmad Rizal, S.Kom." class="w-full border border-slate-200 rounded-md py-2 px-3 text-slate-900 focus:outline-none focus:border-red-500 font-medium">{{ old('inventor_names', auth()->user()->name) }}</textarea>
            </div>

            <div class="md:col-span-2">
                <label for="additional_info" class="block font-bold text-slate-900 uppercase tracking-wide mb-1">
                    Catatan Tambahan / Keterangan Institusi
                </label>
                <input type="text" id="additional_info" name="additional_info" placeholder="Contoh: Hibah Penelitian UMB Tahun 2026" class="w-full border border-slate-200 rounded-md py-2 px-3 text-slate-900 focus:outline-none focus:border-red-500 font-medium">
            </div>
        </div>

        <hr class="border-slate-200">

        <!-- Komponen HTML5 Canvas E-Signature (Styling theme.md) -->
        <div class="space-y-3">
            <div class="flex justify-between items-center">
                <label class="block font-extrabold text-slate-900 uppercase tracking-wider text-xs flex items-center gap-1.5">
                    <span>✍️</span> KANVAS TANDA TANGAN DIGITAL (E-SIGNATURE HTML5) <span class="text-red-600">*</span>
                </label>
                <button type="button" id="clearCanvasBtn" class="bg-amber-500 hover:bg-amber-600 text-white px-3 py-1 rounded text-[11px] font-bold uppercase tracking-wider shadow-xs transition">
                    HAPUS TTD (RESET)
                </button>
            </div>

            <p class="text-[11px] text-slate-500">Gunakan mouse atau layar sentuh (touchscreen) untuk menggambar tanda tangan Anda di area putih di bawah ini:</p>

            <div class="border-2 border-dashed border-slate-300 rounded-xl p-2 bg-slate-50 flex justify-center items-center">
                <canvas id="signatureCanvas" width="650" height="220" class="bg-white border border-slate-200 rounded-lg shadow-inner cursor-crosshair touch-none w-full max-w-[650px]"></canvas>
            </div>

            <div id="canvasError" class="text-red-600 font-bold text-xs hidden">
                ⚠️ Silakan bubuhi tanda tangan Anda pada kanvas sebelum melanjutkan!
            </div>
        </div>

        <div class="pt-4 flex justify-end gap-3">
            <a href="{{ route('applications.show', $application->id) }}" class="bg-slate-200 hover:bg-slate-300 text-slate-700 px-5 py-2.5 rounded-md text-xs font-bold uppercase tracking-wider transition">
                BATAL
            </a>
            <button type="submit" id="submitFormBtn" class="bg-red-600 hover:bg-red-700 text-white px-7 py-2.5 rounded-md text-xs font-bold uppercase tracking-wider transition shadow-md flex items-center space-x-2">
                <span>GENERATE PDF SURAT & SIGNATURE</span>
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const canvas = document.getElementById('signatureCanvas');
        const ctx = canvas.getContext('2d');
        const clearBtn = document.getElementById('clearCanvasBtn');
        const form = document.getElementById('eSignatureForm');
        const signatureInput = document.getElementById('signature_base64');
        const canvasError = document.getElementById('canvasError');

        let isDrawing = false;
        let hasDrawn = false;

        // Styling garis tanda tangan
        ctx.strokeStyle = '#001D3D'; // Midnight Navy
        ctx.lineWidth = 3;
        ctx.lineCap = 'round';
        ctx.lineJoin = 'round';

        // Mendapatkan posisi koordinat kursor/sentuhan yang tepat di Canvas
        function getCanvasCoordinates(e) {
            const rect = canvas.getBoundingClientRect();
            const scaleX = canvas.width / rect.width;
            const scaleY = canvas.height / rect.height;

            let clientX, clientY;
            if (e.touches && e.touches.length > 0) {
                clientX = e.touches[0].clientX;
                clientY = e.touches[0].clientY;
            } else {
                clientX = e.clientX;
                clientY = e.clientY;
            }

            return {
                x: (clientX - rect.left) * scaleX,
                y: (clientY - rect.top) * scaleY
            };
        }

        // Start Drawing
        function startDrawing(e) {
            e.preventDefault();
            isDrawing = true;
            hasDrawn = true;
            canvasError.classList.add('hidden');
            const pos = getCanvasCoordinates(e);
            ctx.beginPath();
            ctx.moveTo(pos.x, pos.y);
        }

        // Draw Line
        function draw(e) {
            if (!isDrawing) return;
            e.preventDefault();
            const pos = getCanvasCoordinates(e);
            ctx.lineTo(pos.x, pos.y);
            ctx.stroke();
        }

        // Stop Drawing
        function stopDrawing(e) {
            if (isDrawing) {
                ctx.closePath();
                isDrawing = false;
            }
        }

        // Event Listeners MOUSE
        canvas.addEventListener('mousedown', startDrawing);
        canvas.addEventListener('mousemove', draw);
        canvas.addEventListener('mouseup', stopDrawing);
        canvas.addEventListener('mouseleave', stopDrawing);

        // Event Listeners TOUCH (Mobile/Tablet)
        canvas.addEventListener('touchstart', startDrawing, { passive: false });
        canvas.addEventListener('touchmove', draw, { passive: false });
        canvas.addEventListener('touchend', stopDrawing);

        // Clear / Reset Canvas
        clearBtn.addEventListener('click', function () {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            hasDrawn = false;
            signatureInput.value = '';
            canvasError.classList.add('hidden');
        });

        // Form Submission Event -> Convert Canvas to Base64 Image
        form.addEventListener('submit', function (e) {
            if (!hasDrawn) {
                e.preventDefault();
                canvasError.classList.remove('hidden');
                canvas.scrollIntoView({ behavior: 'smooth', block: 'center' });
                return false;
            }

            // Convert canvas drawing ke Data URL Base64 PNG
            const dataUrl = canvas.toDataURL('image/png');
            signatureInput.value = dataUrl;
        });
    });
</script>
@endpush
