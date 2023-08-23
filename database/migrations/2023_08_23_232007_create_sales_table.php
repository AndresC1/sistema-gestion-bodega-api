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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->string('number_bill')->index();
            $table->foreignId('organization_id')->index()->constrained('organizations')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('client_id')->index()->constrained('clients')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('user_id')->index()->constrained('users')->cascadeOnUpdate()->cascadeOnDelete();
            $table->date('date');
            $table->decimal('total', 10, 4);
            $table->decimal('earning_total', 10, 4);
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
