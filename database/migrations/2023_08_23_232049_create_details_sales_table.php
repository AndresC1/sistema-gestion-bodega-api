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
        Schema::create('details_sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sale_id')->index()->constrained('sales')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('product_input_id')->index()->constrained('product_inputs')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('organization_id')->index()->constrained('organizations')->cascadeOnUpdate()->cascadeOnDelete();
            $table->decimal('quantity', 10, 4);
            $table->decimal('price', 10, 4);
            $table->decimal('total', 10, 4);
            $table->decimal('cost_unit', 10, 4);
            $table->decimal('cost_total', 10, 4);
            $table->decimal('earning', 10, 4);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('details_sales');
    }
};
