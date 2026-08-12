<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserNotification extends Model
{
    use HasFactory;

    protected $table = 'notifications';

    protected $fillable = [
        'user_id',
        'type',
        'title',
        'message',
        'link_url',
        'is_read',
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Helper static method untuk membuat In-App Notification.
     */
    public static function send(User $user, string $type, string $title, string $message, ?string $linkUrl = null): self
    {
        return self::create([
            'user_id' => $user->id,
            'type' => strtoupper($type),
            'title' => $title,
            'message' => $message,
            'link_url' => $linkUrl,
            'is_read' => false,
        ]);
    }
}
