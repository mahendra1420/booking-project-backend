<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('appointment_status_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('appointment_id')->constrained()->cascadeOnDelete();
            $table->string('status');
            $table->unsignedBigInteger('changed_by')->nullable(); // user_id or admin_user_id
            $table->string('changed_by_type')->nullable();        // 'user' | 'admin' | 'system'
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index('appointment_id');
        });

        Schema::create('business_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_id')->constrained()->cascadeOnDelete();
            $table->string('type'); // registration_certificate, gst, id_proof, etc.
            $table->string('file_path');
            $table->string('original_name')->nullable();
            $table->enum('status', ['pending', 'verified', 'rejected'])->default('pending');
            $table->text('rejection_reason')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->unsignedBigInteger('verified_by')->nullable();
            $table->timestamps();
        });

        Schema::create('business_bank_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_id')->unique()->constrained()->cascadeOnDelete();
            $table->string('bank_name');
            $table->string('account_number'); // store encrypted
            $table->string('ifsc_code');
            $table->string('account_holder_name');
            $table->string('branch')->nullable();
            $table->boolean('is_verified')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('business_bank_details');
        Schema::dropIfExists('business_documents');
        Schema::dropIfExists('appointment_status_history');
    }
};
