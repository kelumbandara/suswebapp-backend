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
            $table->integer('medicineName')->nullable();
            $table->integer('division')->nullable();
            $table->integer('inStock')->nullable();
            $table->integer('status')->nullable();
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
