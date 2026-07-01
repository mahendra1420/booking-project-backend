<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('refunds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payment_id')->constrained()->cascadeOnDelete();
            $table->foreignId('appointment_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->decimal('amount', 10, 2);
            $table->string('reason')->nullable();
            $table->enum('status', ['pending', 'processing', 'completed', 'failed'])->default('pending');
            $table->string('gateway_refund_id')->nullable();
            $table->json('gateway_response')->nullable();
            $table->timestamp('refunded_at')->nullable();
            $table->timestamps();
        });

        Schema::create('payouts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_id')->constrained()->cascadeOnDelete();
            $table->decimal('gross_amount', 12, 2);
            $table->decimal('commission_amount', 12, 2)->default(0);
            $table->decimal('net_amount', 12, 2);
            $table->enum('status', ['pending', 'processing', 'completed', 'failed'])->default('pending');
            $table->string('transaction_ref')->nullable();
            $table->date('payout_date')->nullable();
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('processed_by')->nullable(); // admin_user_id
            $table->timestamps();

            $table->index(['business_id', 'status']);
        });

        Schema::create('commissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('appointment_id')->constrained()->cascadeOnDelete();
            $table->foreignId('business_id')->constrained()->cascadeOnDelete();
            $table->decimal('gross_amount', 10, 2);
            $table->decimal('commission_rate', 5, 2); // percentage at time of booking
            $table->decimal('commission_amount', 10, 2);
            $table->decimal('net_amount', 10, 2);
            $table->enum('status', ['pending', 'paid'])->default('pending');
            $table->foreignId('payout_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('commissions');
        Schema::dropIfExists('payouts');
        Schema::dropIfExists('refunds');
    }
};
