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
        Schema::create('com_user_types', function (Blueprint $table) {
            $table->string('userType')->nullable();
            $table->string('userTypeDescription')->nullable();
            $table->json('section')->nullable();
            $table->json('areas')->nullable();
            $table->json('other')->nullable();
            $table->boolean('status')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('com_user_types');
    }
};
