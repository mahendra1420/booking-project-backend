<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('businesses', function (Blueprint $table) {
            // Allow business registration without a linked user account
            $table->dropForeign(['owner_id']);
            $table->unsignedBigInteger('owner_id')->nullable()->change();
            $table->foreign('owner_id')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('businesses', function (Blueprint $table) {
            $table->dropForeign(['owner_id']);
            $table->unsignedBigInteger('owner_id')->nullable(false)->change();
            $table->foreign('owner_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }
};
