<?php

namespace App\Services;

use App\Mail\StatusUpdateMail;
use App\Models\User;
use App\Models\UserNotification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class MultiChannelAlertService
{
    /**
     * Memicu notifikasi otomatis multi-channel (In-App, Email, & WhatsApp)
     * saat verifikasi user atau update status permohonan HKI.
     */
    public static function triggerAlert(
        User $recipient,
        string $type,
        string $title,
        string $message,
        ?string $linkUrl = null
    ): void {
        // 1. IN-APP NOTIFICATION
        try {
            UserNotification::send($recipient, $type, $title, $message, $linkUrl);
        } catch (\Exception $e) {
            Log::error("Failed to create In-App Notification: " . $e->getMessage());
        }

        // 2. EMAIL NOTIFICATION
        try {
            if (filter_var($recipient->email, FILTER_VALIDATE_EMAIL)) {
                Mail::to($recipient->email)->send(
                    new StatusUpdateMail($recipient, $title, $message, $linkUrl)
                );
            }
        } catch (\Exception $e) {
            Log::error("Failed to send Email Alert to {$recipient->email}: " . $e->getMessage());
        }

        // 3. WHATSAPP API MESSAGE ALERT
        try {
            if ($recipient->phone_number) {
                $waMessage = "🏛️ *HKI UM BIMA ALERT*\n\n"
                    . "Halo *{$recipient->name}*,\n\n"
                    . "📢 *{$title}*\n"
                    . "{$message}\n\n"
                    . ($linkUrl ? "🔗 Akses Portal: {$linkUrl}\n\n" : "")
                    . "_Sentra Hak Kekayaan Intelektual Universitas Muhammadiyah Bima_";

                WhatsAppService::sendMessage($recipient->phone_number, $waMessage);
            }
        } catch (\Exception $e) {
            Log::error("Failed to send WhatsApp Alert to {$recipient->phone_number}: " . $e->getMessage());
        }
    }

    /**
     * Memicu notifikasi In-App & WA ke seluruh Administrator (saat ada pendaftar baru / permohonan baru).
     */
    public static function notifyAdmins(string $type, string $title, string $message, ?string $linkUrl = null): void
    {
        $admins = User::where('role', 'admin')->get();

        foreach ($admins as $admin) {
            self::triggerAlert($admin, $type, $title, $message, $linkUrl);
        }
    }
}
