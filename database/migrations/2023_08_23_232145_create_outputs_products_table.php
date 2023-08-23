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
        Schema::create('outputs_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inventory_id')->index()->constrained('inventories')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('organization_id')->index()->constrained('organizations')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('user_id')->index()->constrained('users')->cascadeOnUpdate()->cascadeOnDelete();
            $table->date('date');
            $table->decimal('quantity', 10, 4);
            $table->decimal('price', 10, 4);
            $table->decimal('total', 10, 4);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('outputs_products');
    }
};
