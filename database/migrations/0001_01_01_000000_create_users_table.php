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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('google_id')->nullable()->unique();
            $table->string('avatar')->nullable();
            $table->enum('role', ['admin', 'user', 'guest'])->default('user');
            
            // Separated Identity Fields
            $table->string('nik')->nullable(); // NIK (Nomor Induk Kependudukan) - WAJIB
            $table->string('nip')->nullable(); // NIP (Nomor Induk Pegawai) - OPTIONAL
            $table->string('nim')->nullable(); // NIM (Nomor Induk Mahasiswa) - OPTIONAL
            $table->string('ktp_path')->nullable(); // Path File Upload KTP - WAJIB
            
            $table->string('identity_number')->nullable(); // Backward compatibility fallback
            $table->string('faculty')->nullable(); // Fakultas / Unit (OPTIONAL)
            $table->string('phone_number')->nullable(); // WhatsApp (WAJIB)
            
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
