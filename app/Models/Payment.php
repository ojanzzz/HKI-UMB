<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'hki_application_id',
        'user_id',
        'simpaki_code',
        'amount',
        'proof_of_payment',
        'status',
        'receipt_pdf_path',
        'verified_at',
    ];

    protected $casts = [
        'verified_at' => 'datetime',
        'amount' => 'decimal:2',
    ];

    public function hkiApplication()
    {
        return $this->belongsTo(HkiApplication::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
