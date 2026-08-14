<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'title',
        'description',
        'file_path',
        'file_name',
        'file_type',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
