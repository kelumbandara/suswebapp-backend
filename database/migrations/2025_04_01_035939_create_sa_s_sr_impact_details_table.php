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
        Schema::create('sa_s_sr_impact_details', function (Blueprint $table) {
            $table->id('impactId');
            $table->bigInteger('sdgId')->nullable();
            $table->string('impactType')->nullable();
            $table->string('unit')->nullable();
            $table->string('value')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sa_s_sr_impact_details');
    }
};
