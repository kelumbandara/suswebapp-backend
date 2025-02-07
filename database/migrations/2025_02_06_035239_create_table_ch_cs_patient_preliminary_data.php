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
        Schema::create('patient_preliminary_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients');
            $table->decimal('body_temperature', 5, 2)->nullable();
            $table->decimal('weight', 8, 2)->nullable();
            $table->string('height')->nullable();
            $table->string('blood_pressure')->nullable();
            $table->decimal('random_blood_sugar', 8, 2)->nullable();
            $table->decimal('body_mass_index', 5, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_preliminary_data');
    }
};
