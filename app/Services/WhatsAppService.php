<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    /**
     * Mengirim pesan WhatsApp via WhatsApp Gateway API (e.g. Fonnte / Wablas API)
     * Serta mencatat payload ke storage/logs/whatsapp.log untuk keperluan testing offline.
     */
    public static function sendMessage(string $phoneNumber, string $message): array
    {
        // Format Nomor HP ke format 628xxx
        $formattedPhone = preg_replace('/[^0-9]/', '', $phoneNumber);
        if (str_starts_with($formattedPhone, '0')) {
            $formattedPhone = '62' . substr($formattedPhone, 1);
        }

        $apiUrl = config('services.whatsapp.api_url', 'https://api.fonnte.com/send');
        $apiToken = config('services.whatsapp.token', env('WHATSAPP_API_TOKEN', 'DEMO_UMB_WA_TOKEN'));

        $payload = [
            'target' => $formattedPhone,
            'message' => $message,
            'countryCode' => '62',
        ];

        // Catat ke log file khusus WhatsApp storage/logs/whatsapp.log
        Log::channel('single')->info("📲 [WHATSAPP OUTGOING ALERT]\nTo: {$formattedPhone}\nMessage:\n{$message}\n" . str_repeat('-', 40));

        $status = 'logged_simulated';
        $responseBody = [];

        try {
            // Jika token terisi API asli, kirim via HTTP Client
            if ($apiToken && $apiToken !== 'DEMO_UMB_WA_TOKEN') {
                $response = Http::withHeaders([
                    'Authorization' => $apiToken,
                ])->timeout(5)->post($apiUrl, $payload);

                $status = $response->successful() ? 'sent' : 'failed';
                $responseBody = $response->json();
            }
        } catch (\Exception $e) {
            Log::error("WhatsApp Gateway API Exception: " . $e->getMessage());
            $status = 'exception';
        }

        return [
            'status' => $status,
            'phone' => $formattedPhone,
            'response' => $responseBody,
        ];
    }
}
