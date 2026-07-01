<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable()->after('email');
            $table->string('avatar')->nullable()->after('phone');
            $table->enum('role', ['customer', 'business_owner', 'admin'])->default('customer')->after('avatar');
            $table->foreignId('city_id')->nullable()->constrained('cities')->nullOnDelete()->after('role');
            $table->boolean('status')->default(true)->after('city_id');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['city_id']);
            $table->dropColumn(['phone', 'avatar', 'role', 'city_id', 'status']);
        });
    }
};
