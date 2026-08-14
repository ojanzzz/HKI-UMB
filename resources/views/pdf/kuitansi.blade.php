<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kuitansi Pembayaran SIMPAKI DJKI - UMB</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 11pt;
            color: #0F172A;
            margin: 25px;
        }
        .header {
            border-bottom: 2px solid #002855;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .header table { width: 100%; }
        .title {
            text-align: center;
            font-weight: bold;
            font-size: 14pt;
            color: #002855;
            text-transform: uppercase;
            margin-bottom: 20px;
        }
        .box-info {
            border: 1px solid #CBD5E1;
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 25px;
            background-color: #F8FAFC;
        }
        .table-details {
            width: 100%;
            border-collapse: collapse;
        }
        .table-details td {
            padding: 8px 0;
            border-bottom: 1px solid #E2E8F0;
        }
        .amount-box {
            background-color: #002855;
            color: #ffffff;
            font-size: 16pt;
            font-weight: bold;
            padding: 12px;
            text-align: center;
            border-radius: 4px;
            margin-top: 15px;
        }
        .status-badge {
            color: #059669;
            font-weight: bold;
            font-size: 12pt;
        }
        .stamp {
            margin-top: 30px;
            float: right;
            text-align: center;
            width: 200px;
        }
    </style>
</head>
<body>

    <div class="header">
        <table>
            <tr>
                <td width="70%">
                    <h3 style="margin: 0; color: #002855;">DIREKTORAT INOVASI DAN KEKAYAAN INTELEKTUAL (KI) UM BIMA</h3>
                    <p style="margin: 3px 0 0 0; font-size: 9pt; color: #64748B;">Layanan SIMPAKI Terintegrasi DJKI Kemenkumham RI</p>
                </td>
                <td width="30%" style="text-align: right;">
                    <strong style="font-size: 10pt; color: #DC2626;">KUITANSI RESMI</strong>
                </td>
            </tr>
        </table>
    </div>

    <div class="title">KUITANSI BUKTI PEMBAYARAN KI</div>

    <table class="details-table">
        <tr>
            <td width="30%"><strong>Nomor Kuitansi</strong></td>
            <td width="70%">: KWI-SIMPAKI-{{ date('Ymd', strtotime($payment->created_at ?? now())) }}-{{ $payment->id ?? $application->id }}</td>
        </tr>
        <tr>
            <td><strong>Tanggal Pembayaran</strong></td>
            <td>: {{ date('d F Y', strtotime($payment->created_at ?? now())) }}</td>
        </tr>
        <tr>
            <td><strong>Telah Diterima Dari</strong></td>
            <td>: <strong>{{ strtoupper($application->user->name ?? 'Pemohon') }}</strong> ({{ $application->user->faculty ?? 'Sivitas UM BIMA' }})</td>
        </tr>
        <tr>
            <td><strong>NIK / NIP / NIM</strong></td>
            <td>: {{ $application->user->identity_number ?? '-' }}</td>
        </tr>
        <tr>
            <td><strong>Judul Permohonan KI</strong></td>
            <td>: "{{ $application->title }}"</td>
        </tr>
        <tr>
            <td><strong>Jenis KI & Kategori</strong></td>
            <td>: {{ strtoupper($application->application_type) }} - {{ $application->application_category ?? 'UMKM' }}</td>
        </tr>
        <tr>
            <td><strong>Nomor Billing SIMPAKI</strong></td>
            <td>: <strong>{{ $application->simpaki_billing_code ?? 'SIMPAKI-BILL-OFFICIAL' }}</strong></td>
        </tr>
    </table>

    <div class="amount-box">
        TOTAL BAYAR: Rp {{ number_format($payment->amount ?? $application->billing_amount ?? 0, 0, ',', '.') }}
        <div class="terbilang">Status: LUNAS & DIVERIFIKASI ADMINISTRATOR</div>
    </div>

    <div class="footer-note">
        <p><strong>Catatan Tambahan:</strong></p>
        <p>1. Bukti pembayaran ini adalah sah dan digenerate secara otomatis oleh Sistem Informasi KI UM BIMA.</p>
        <p>2. Nomor billing SIMPAKI di atas telah terdaftar secara resmi pada portal DJKI Kemenkumham RI.</p>
    </div>

    <div class="signature-section">
        <p>Bima, {{ date('d F Y') }}</p>
        <p>Verifikator Keuangan KI UM BIMA,</p>
        <br><br>
        <p style="font-weight: bold; text-decoration: underline;">Admin Direktorat Inovasi & KI UM Bima</p>
        <p style="font-size: 8pt; color: #64748B;">NIP: 198809012019031002</p>
    </div>

</body>
</html>
