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
        Schema::table('users', function (Blueprint $table) {
            $table->string('username', 50)->unique();
            $table->foreignId('role_id')->constrained('roles')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('organization_id')->nullable()->constrained('organizations')->cascadeOnDelete()->cascadeOnUpdate();
            $table->dateTime('last_login_at');
            $table->enum('status', ['active', 'inactive'])->default('active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
            $table->dropForeign(['organization_id']);
            $table->dropIfExists('username');
            $table->dropIfExists('role_id');
            $table->dropIfExists('organization_id');
            $table->dropIfExists('last_login_at');
            $table->dropIfExists('status');
        });
    }
};
