<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HkiDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'hki_application_id',
        'document_type',
        'file_path',
        'is_emeterai',
        'form_data',
        'signature_base64',
    ];

    protected $casts = [
        'is_emeterai' => 'boolean',
        'form_data' => 'array',
    ];

    public function hkiApplication()
    {
        return $this->belongsTo(HkiApplication::class);
    }
}
