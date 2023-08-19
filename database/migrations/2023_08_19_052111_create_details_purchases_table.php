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
        Schema::create('details_purchases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_id')->index()->constrained('purchases')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('product_id')->index()->constrained('products')->cascadeOnUpdate()->cascadeOnDelete();
            $table->float('quantity', 8, 2);
            $table->decimal('price', 8, 2);
            $table->decimal('total', 8, 2);
            $table->float('disponibility', 8, 2)->nullable();
            $table->string('observation')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('details_purchases');
    }
};
