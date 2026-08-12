<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('hki_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hki_application_id')->constrained('hki_applications')->cascadeOnDelete();
            $table->enum('document_type', [
                'deskripsi_paten',
                'abstrak',
                'klaim',
                'gambar_invensi',
                'data_dukung',
                'daftar_inventor',
                'pernyataan_pengalihan_hak',
                'pernyataan_kepemilikan'
            ]);
            $table->string('file_path');
            $table->boolean('is_emeterai')->default(false);
            $table->json('form_data')->nullable();
            $table->longText('signature_base64')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hki_documents');
    }
};
