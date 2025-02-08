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
        Schema::create('hs_oh_cs_medicine_stocks', function (Blueprint $table) {
            $table->id();
            $table->string('medicineName')->nullable();
            $table->string('division')->nullable();
            $table->string('inStock')->nullable();
            $table->string('status')->nullable();
            $table->string('lastUpdated')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hs_oh_cs_medicine_stocks');
    }
};
