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
        Schema::create('hki_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('application_type')->default('paten');
            $table->enum('status', [
                'draft',
                'submitted',
                'under_review',
                'billing_issued',
                'payment_pending',
                'paid',
                'submitted_to_djki',
                'approved_djki',
                'rejected'
            ])->default('draft');
            
            // DJKI Integration & Payment Fields
            $table->string('djki_application_number')->nullable();
            $table->string('simpaki_billing_code')->nullable();
            $table->decimal('billing_amount', 12, 2)->nullable();
            $table->string('zip_export_path')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hki_applications');
    }
};
