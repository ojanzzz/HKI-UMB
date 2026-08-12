<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HkiApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'product_image_path',
        'application_type',
        'application_category',
        'applicant_name',
        'applicant_address',
        'applicant_nik',
        'applicant_nip',
        'applicant_nim',
        'applicant_faculty',
        'status',
        'djki_application_number',
        'simpaki_billing_code',
        'billing_amount',
        'zip_export_path',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function applicants()
    {
        return $this->hasMany(HkiApplicant::class);
    }

    public function documents()
    {
        return $this->hasMany(HkiDocument::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
