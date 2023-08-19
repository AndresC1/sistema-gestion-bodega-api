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
        Schema::create('product_inputs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inventory_id')->index()->constrained('inventories')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('organization_id')->index()->constrained('organizations')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('user_id')->index()->constrained('users')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('details_purchase_id')->index()->constrained('details_purchases')->cascadeOnUpdate()->cascadeOnDelete();
            $table->date('date');
            $table->float('quantity', 8, 2);
            $table->decimal('price', 8, 2);
            $table->decimal('total', 8, 2);
            $table->string('observation')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_inputs');
    }
};
