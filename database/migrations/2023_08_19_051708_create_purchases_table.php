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
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->string('number_bill');
            $table->foreignId('organization_id')->index()->constrained('organizations')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('provider_id')->index()->constrained('providers')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('user_id')->index()->constrained('users')->cascadeOnUpdate()->cascadeOnDelete();
            $table->date('date');
            $table->decimal('total', 8, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};
