<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'user_name',
        'user_email',
        'action',
        'description',
        'ip_address',
        'user_agent',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Helper static method untuk mencatat log aktivitas sistem secara otomatis.
     */
    public static function log(string $action, string $description, ?User $user = null): self
    {
        $targetUser = $user ?: Auth::user();

        return self::create([
            'user_id' => $targetUser ? $targetUser->id : null,
            'user_name' => $targetUser ? $targetUser->name : 'GUEST / SYSTEM',
            'user_email' => $targetUser ? $targetUser->email : 'guest@umb.ac.id',
            'action' => strtoupper($action),
            'description' => $description,
            'ip_address' => request()->ip() ?: '127.0.0.1',
            'user_agent' => request()->header('User-Agent'),
        ]);
    }
}
