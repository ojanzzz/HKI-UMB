<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HkiApplicant extends Model
{
    protected $fillable = [
        'hki_application_id',
        'applicant_name',
        'applicant_address',
        'applicant_nik',
        'applicant_nip',
        'applicant_nim',
        'applicant_faculty',
        'is_primary',
    ];

    protected function casts(): array
    {
        return [
            'is_primary' => 'boolean',
        ];
    }

    public function application()
    {
        return $this->belongsTo(HkiApplication::class, 'hki_application_id');
    }
}
