<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('businesses', function (Blueprint $table) {
            $table->string('cover_image')->nullable()->after('logo');
            $table->boolean('is_featured')->default(false)->after('status');
            $table->decimal('commission_rate', 5, 2)->default(10.00)->after('is_featured'); // % per booking
            $table->text('rejection_reason')->nullable()->after('commission_rate');
            $table->unsignedBigInteger('approved_by')->nullable()->after('rejection_reason');
            $table->timestamp('approved_at')->nullable()->after('approved_by');
        });

        Schema::table('reviews', function (Blueprint $table) {
            $table->boolean('is_reported')->default(false)->after('is_approved');
            $table->text('report_reason')->nullable()->after('is_reported');
            $table->timestamp('reported_at')->nullable()->after('report_reason');
        });
    }

    public function down(): void
    {
        Schema::table('businesses', function (Blueprint $table) {
            $table->dropColumn(['cover_image','is_featured','commission_rate','rejection_reason','approved_by','approved_at']);
        });
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropColumn(['is_reported','report_reason','reported_at']);
        });
    }
};
