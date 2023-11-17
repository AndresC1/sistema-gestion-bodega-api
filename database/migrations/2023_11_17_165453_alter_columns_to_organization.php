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
        Schema::table('organizations', function (Blueprint $table) {
            $table->string('address')->nullable()->change();
            $table->string('phone_main')->nullable()->change();
            $table->string('ruc', 16)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('organizations', function (Blueprint $table) {
            $table->string('address')->nullable(false)->change();
            $table->string('phone_main')->nullable(false)->change();
            $table->string('ruc', 16)->nullable(false)->change();
        });
    }
};
