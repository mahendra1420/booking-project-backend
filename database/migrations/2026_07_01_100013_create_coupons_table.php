<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_id')->nullable()->constrained()->cascadeOnDelete(); // null = platform-wide
            $table->string('code')->unique();
            $table->enum('type', ['percentage', 'fixed'])->default('percentage');
            $table->decimal('value', 10, 2); // percent or flat amount
            $table->decimal('minimum_order', 10, 2)->default(0);
            $table->decimal('maximum_discount', 10, 2)->nullable();
            $table->integer('max_uses')->nullable(); // null = unlimited
            $table->integer('used_count')->default(0);
            $table->boolean('status')->default(true);
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();

            $table->index(['code', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
