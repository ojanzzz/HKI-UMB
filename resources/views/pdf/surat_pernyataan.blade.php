<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat {{ strtoupper(str_replace('_', ' ', $docType)) }}</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 11pt;
            line-height: 1.5;
            color: #0F172A;
            margin: 30px;
        }
        .header {
            text-align: center;
            border-bottom: 3px double #002855;
            padding-bottom: 12px;
            margin-bottom: 25px;
        }
        .header h2 {
            font-size: 14pt;
            margin: 0;
            color: #002855;
            text-transform: uppercase;
        }
        .header p {
            margin: 3px 0 0 0;
            font-size: 10pt;
            color: #64748B;
        }
        .title {
            text-align: center;
            font-weight: bold;
            font-size: 13pt;
            text-decoration: underline;
            margin-bottom: 20px;
            text-transform: uppercase;
        }
        .content {
            margin-bottom: 30px;
        }
        .table-data {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }
        .table-data td {
            padding: 4px 0;
            vertical-align: top;
        }
        .signature-section {
            width: 100%;
            margin-top: 40px;
        }
        .signature-box {
            float: right;
            width: 250px;
            text-align: center;
        }
        .signature-img {
            max-width: 220px;
            max-height: 90px;
            margin: 10px 0;
        }
        .clear {
            clear: both;
        }
        .footer-note {
            margin-top: 50px;
            font-size: 8pt;
            color: #94A3B8;
            border-top: 1px solid #CBD5E1;
            padding-top: 6px;
        }
    </style>
</head>
<body>

    <div class="header">
        <h2>UNIVERSITAS MUHAMMADIYAH BIMA - DIREKTORAT INOVASI DAN KEKAYAAN INTELEKTUAL (KI)</h2>
        <p>Jl. Meruya Selatan No. 1, Kembangan, Jakarta Barat 11650 | Email: hki@umbima.ac.id</p>
    </div>

    <div class="title">
        SURAT PERNYATAAN {{ strtoupper(str_replace('_', ' ', $docType)) }}
    </div>

    <div class="content">
        <p>Yang bertanda tangan di bawah ini:</p>

        <table class="table-data">
            <tr>
                <td width="30%"><strong>Nama Pemohon/Inventor</strong></td>
                <td width="3%">:</td>
                <td>{{ $formData['user_name'] ?? '-' }}</td>
            </tr>
            <tr>
                <td><strong>NIM / NIP / NIK</strong></td>
                <td>:</td>
                <td>{{ $formData['identity_number'] ?? '-' }}</td>
            </tr>
            <tr>
                <td><strong>Fakultas / Unit Kerja</strong></td>
                <td>:</td>
                <td>{{ $formData['faculty'] ?? '-' }}</td>
            </tr>
            <tr>
                <td><strong>Judul Invensi / Paten</strong></td>
                <td>:</td>
                <td><strong>{{ $formData['title_statement'] ?? $application->title }}</strong></td>
            </tr>
            <tr>
                <td><strong>Daftar Anggota Inventor</strong></td>
                <td>:</td>
                <td>{!! nl2br(e($formData['inventor_names'] ?? '-')) !!}</td>
            </tr>
        </table>

        <p>
            Dengan ini menyatakan secara sebenar-benarnya bahwa permohonan Hak Kekayaan Intelektual (Paten) dengan judul di atas adalah benar milik pemohon dan/atau institusi Universitas Mercu Buana, serta bebas dari tuntutan pihak manapun.
        </p>

        @if(!empty($formData['additional_info']))
        <p><strong>Catatan Tambahan:</strong> {{ $formData['additional_info'] }}</p>
        @endif
    </div>

    <div class="signature-section">
        <div class="signature-box">
            <p>Jakarta, {{ date('d F Y', strtotime($formData['statement_date'] ?? date('Y-m-d'))) }}</p>
            <p>Yang Membuat Pernyataan,</p>
            
            <!-- Gambar Tanda Tangan Digital Base64 HTML5 Canvas -->
            @if(!empty($signatureBase64))
                <img src="{{ $signatureBase64 }}" class="signature-img" alt="E-Signature Base64">
            @else
                <div style="height: 80px;"></div>
            @endif

            <p style="text-decoration: underline; font-weight: bold; margin-bottom: 0;">{{ $formData['user_name'] }}</p>
            <p style="margin-top: 0; font-size: 9pt;">NIP/NIM: {{ $formData['identity_number'] }}</p>
        </div>
        <div class="clear"></div>
    </div>

    <div class="footer-note">
        * Dokumen ini digenerate secara otomatis melalui Sistem Informasi KI UM BIMA terintegrasi DJKI Kemenkumham RI dengan Tanda Tangan Digital (E-Signature HTML5).
    </div>

</body>
</html>
