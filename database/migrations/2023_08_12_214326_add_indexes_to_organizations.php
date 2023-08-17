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
            $table->index('sector_id');
            $table->index('name');
            $table->index('municipality_id');
            $table->index('city_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::table('organizations', function (Blueprint $table) {
            $table->dropIndex(['sector_id']);
            $table->dropIndex(['name']);
            $table->dropIndex(['municipality_id']);
            $table->dropIndex(['city_id']);
        });
        Schema::enableForeignKeyConstraints();
    }
};
