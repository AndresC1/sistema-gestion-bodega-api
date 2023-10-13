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
        Schema::table('sales', function (Blueprint $table) {
            $table->enum('payment_method', ["contado", "credito"])->index()->nullable()->after('note');
            $table->enum('payment_status', ["pendiente", "cancelado"])->index()->nullable()->after('payment_method');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->dropColumn('payment_method');
            $table->dropColumn('payment_status');
        });
    }
};
