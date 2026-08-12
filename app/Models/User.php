<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'google_id',
        'avatar',
        'role',
        'nik',
        'nip',
        'nim',
        'ktp_path',
        'identity_number',
        'faculty',
        'phone_number',
        'status',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function hkiApplications()
    {
        return $this->hasMany(HkiApplication::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function getIdentityNumberAttribute()
    {
        return $this->attributes['nik'] ?? ($this->attributes['nip'] ?? ($this->attributes['nim'] ?? ($this->attributes['identity_number'] ?? null)));
    }

    public function isProfileComplete(): bool
    {
        return !empty($this->nik) && !empty($this->phone_number) && !empty($this->ktp_path);
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isUser(): bool
    {
        return $this->role === 'user';
    }

    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }
}
