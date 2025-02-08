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
        Schema::create('hs_oh_mi_medicine_names', function (Blueprint $table) {
            $table->id();
            $table->string('medicineName')->nullable();
            $table->string('genericName')->nullable();
            $table->string('dosageStrength')->nullable();
            $table->string('form')->nullable();
            $table->string('medicineType')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hs_oh_mi_medicine_names');
    }
};
