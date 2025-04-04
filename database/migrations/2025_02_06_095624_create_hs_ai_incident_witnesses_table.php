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
        Schema::create('hs_ai_incident_witnesses', function (Blueprint $table) {
            $table->id('witnessId');
            $table->bigInteger('incidentId')->nullable();
            $table->string('employeeId')->nullable();
            $table->string('name')->nullable();
            $table->string('division')->nullable();
            $table->string('department')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hs_ai_incident_witnesses');
    }
};
