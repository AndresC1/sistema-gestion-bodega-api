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
        Schema::table('product_inputs', function (Blueprint $table) {
            $table->double('disponibility', 8, 2)->nullable()->after('observation');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_inputs', function (Blueprint $table) {
            $table->dropColumn('disponibility');
        });
    }
};
