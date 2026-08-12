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
        Schema::create('hki_applicants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hki_application_id')
                  ->constrained('hki_applications')
                  ->cascadeOnDelete();
            $table->string('applicant_name');
            $table->text('applicant_address');
            $table->string('applicant_nik');
            $table->string('applicant_nip')->nullable();
            $table->string('applicant_nim')->nullable();
            $table->string('applicant_faculty')->nullable();
            $table->boolean('is_primary')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hki_applicants');
    }
};
