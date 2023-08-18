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
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->index()->constrained('products')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('organization_id')->index()->constrained('organizations')->cascadeOnDelete()->cascadeOnUpdate();
            $table->enum('type', ['MP', 'PT'])->index();
            $table->float('stock', 8, 4)->index();
            $table->float('stock_min', 8, 2)->nullable()->index();
            $table->char('unit_of_measurement', 3);
            $table->string('location', 100)->nullable();
            $table->date('date_last_modified');
            $table->string('lot_number', 100)->nullable();
            $table->string('note', 200)->nullable();
            $table->enum('status', ['disponible', 'no disponible'])->index();
            $table->float('total_value', 8, 2);
            $table->string('code', 20)->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventories');
    }
};
