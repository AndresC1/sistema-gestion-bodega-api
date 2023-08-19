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
        Schema::create('details_product_inputs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('details_purchase_id')->index()->constrained('details_purchases')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('product_input_id')->index()->constrained('product_inputs')->cascadeOnUpdate()->cascadeOnDelete();
            $table->integer('quantity');
            $table->decimal('price', 10, 2);
            $table->decimal('total', 10, 2);
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('details_product_inputs');
    }
};
