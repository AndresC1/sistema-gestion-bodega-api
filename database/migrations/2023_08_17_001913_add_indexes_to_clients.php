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
            $table->index('name');
            $table->index('organization_id');
            $table->index('municipality_id');
            $table->index('city_id');
            $table->index('type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::table('clients', function (Blueprint $table) {
            $table->dropIndex(['name']);
            $table->dropIndex(['organization_id']);
            $table->dropIndex(['municipality_id']);
            $table->dropIndex(['city_id']);
            $table->dropIndex(['type']);
        });
        Schema::enableForeignKeyConstraints();
    }
};
