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
                    <h3 style="margin: 0; color: #002855;">SENTRA HKI UNIVERSITAS MERCU BUANA</h3>
                    <p style="margin: 3px 0 0 0; font-size: 9pt; color: #64748B;">Layanan SIMPAKI Terintegrasi DJKI Kemenkumham RI</p>
                </td>
                <td width="30%" style="text-align: right;">
                    <strong style="font-size: 10pt; color: #DC2626;">KUITANSI RESMI</strong>
                </td>
            </tr>
        </table>
    </div>

    <div class="title">KUITANSI BUKTI PEMBAYARAN HKI</div>

    <div class="box-info">
        <table class="table-details">
            <tr>
                <td width="35%"><strong>No. Kuitansi</strong></td>
                <td width="3%">:</td>
                <td>KUT-UMB-{{ str_pad($payment->id, 5, '0', STR_PAD_LEFT) }}</td>
            </tr>
            <tr>
                <td><strong>Diterima Dari</strong></td>
                <td>:</td>
                <td>{{ $user->name }} ({{ $user->identity_number }})</td>
            </tr>
            <tr>
                <td><strong>Fakultas / Unit</strong></td>
                <td>:</td>
                <td>{{ $user->faculty }}</td>
            </tr>
            <tr>
                <td><strong>Judul Permohonan HKI</strong></td>
                <td>:</td>
                <td><strong>{{ $application->title }}</strong></td>
            </tr>
            <tr>
                <td><strong>Nomor Permohonan DJKI</strong></td>
                <td>:</td>
                <td>{{ $application->djki_application_number ?? '-' }}</td>
            </tr>
            <tr>
                <td><strong>Kode Billing SIMPAKI</strong></td>
                <td>:</td>
                <td><strong style="color: #002855;">{{ $payment->simpaki_code }}</strong></td>
            </tr>
            <tr>
                <td><strong>Status Verifikasi</strong></td>
                <td>:</td>
                <td><span class="status-badge">✓ LUNAS (VERIFIED)</span></td>
            </tr>
            <tr>
                <td><strong>Tanggal Verifikasi</strong></td>
                <td>:</td>
                <td>{{ date('d F Y H:i', strtotime($payment->verified_at ?? now())) }} WIB</td>
            </tr>
        </table>

        <div class="amount-box">
            TOTAL BAYAR: Rp {{ number_format($payment->amount, 0, ',', '.') }}
        </div>
    </div>

    <div class="stamp">
        <p>Jakarta, {{ date('d F Y') }}</p>
        <p>Verifikator Keuangan HKI UMB,</p>
        <br><br>
        <p style="font-weight: bold; text-decoration: underline;">Admin Sentra HKI UMB</p>
        <p style="font-size: 8pt; color: #64748B;">NIP: 198809012019031002</p>
    </div>

</body>
</html>
