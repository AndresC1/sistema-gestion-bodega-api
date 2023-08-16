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
        Schema::table('clients', function (Blueprint $table) {
            $table->foreignId('municipality_id')->constrained('municipalities')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('city_id')->constrained('cities')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropForeign(['municipality_id']);
            $table->dropForeign(['city_id']);
            $table->dropColumn(['municipality_id', 'city_id']);
        });
    }
};
