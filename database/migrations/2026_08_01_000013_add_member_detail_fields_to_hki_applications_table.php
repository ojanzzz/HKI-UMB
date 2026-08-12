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
        Schema::table('hki_applications', function (Blueprint $table) {
            $table->string('applicant_name')->nullable()->after('user_id');
            $table->text('applicant_address')->nullable()->after('applicant_name');
            $table->string('applicant_nik')->nullable()->after('applicant_address');
            $table->string('applicant_nip')->nullable()->after('applicant_nik');
            $table->string('applicant_nim')->nullable()->after('applicant_nip');
            $table->string('applicant_faculty')->nullable()->after('applicant_nim');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hki_applications', function (Blueprint $table) {
            $table->dropColumn([
                'applicant_name',
                'applicant_address',
                'applicant_nik',
                'applicant_nip',
                'applicant_nim',
                'applicant_faculty',
            ]);
        });
    }
};
