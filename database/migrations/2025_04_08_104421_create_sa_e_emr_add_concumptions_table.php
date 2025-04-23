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
        Schema::create('sa_e_emr_add_consumption', function (Blueprint $table) {
            $table->id('consumptionId');
            $table->bigInteger('envirementId')->nullable();
            $table->string('category')->nullable();
            $table->string('source')->nullable();
            $table->string('unit')->nullable();
            $table->string('quantity')->nullable();
            $table->string('amount')->nullable();
            $table->string('ghgInTonnes')->nullable();
            $table->string('scope')->nullable();
            $table->string('methodOfTracking')->nullable();
            $table->string('usageType')->nullable();
            $table->boolean('doYouHaveREC')->nullable();
            $table->string('description')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sa_e_emr_add_concumptions');
    }
};
