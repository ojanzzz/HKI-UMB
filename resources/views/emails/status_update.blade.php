<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $subjectTitle }}</title>
</head>
<body style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #f8fafc; margin: 0; padding: 24px; color: #0f172a;">
    <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 12px; overflow: hidden; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">
        <div style="background-color: #064E3B; color: #ffffff; padding: 20px 24px; text-align: left;">
            <h1 style="margin: 0; font-size: 16px; font-weight: 800; letter-spacing: 0.5px; text-transform: uppercase;">Direktorat Inovasi & KI UM Bima</h1>
            <p style="margin: 4px 0 0 0; font-size: 11px; color: #a7f3d0; text-transform: uppercase; font-weight: 600;">Universitas Muhammadiyah Bima</p>
        </div>
        
        <div style="padding: 28px 24px; font-size: 14px; line-height: 1.6;">
            <p style="margin-top: 0;">Halo, <strong>{{ $user->name }}</strong>,</p>
            
            <div style="background-color: #f0fdf4; border-left: 4px solid #059669; padding: 16px; margin: 20px 0; border-radius: 4px;">
                <h2 style="margin: 0 0 8px 0; font-size: 16px; color: #065f46;">{{ $subjectTitle }}</h2>
                <p style="margin: 0; color: #047857; font-size: 13px;">{{ $emailMessage }}</p>
            </div>

            @if(!empty($actionUrl))
                <div style="text-align: center; margin: 28px 0;">
                    <a href="{{ $actionUrl }}" style="background-color: #064E3B; color: #ffffff; padding: 12px 24px; text-decoration: none; border-radius: 6px; font-weight: bold; font-size: 13px; display: inline-block; text-transform: uppercase;">
                        Buka Dashboard KI UM BIMA &rarr;
                    </a>
                </div>
            @endif

            <p style="margin-bottom: 0; font-size: 12px; color: #64748b;">
                Pesan ini dikirimkan secara otomatis oleh Sistem Informasi KI Universitas Muhammadiyah Bima.
            </p>
        </div>

        <div style="background-color: #f1f5f9; padding: 16px 24px; text-align: center; font-size: 11px; color: #64748b; border-top: 1px solid #e2e8f0;">
            &copy; {{ date('Y') }} Direktorat Inovasi dan Kekayaan Intelektual (KI) UM Bima
        </div>
    </div>
</body>
</html>
