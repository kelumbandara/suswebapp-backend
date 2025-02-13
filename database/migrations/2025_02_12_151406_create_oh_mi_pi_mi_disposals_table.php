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
        Schema::create('oh_mi_pi_mi_disposals', function (Blueprint $table) {
            $table->id('disposalId');
            $table->unsignedBigInteger('inventoryId')->nullable();
            $table->string('disposalDate')->nullable();
            $table->string('availableQuantity')->nullable();
            $table->string('disposalQuantity')->nullable();
            $table->string('contractor')->nullable();
            $table->string('cost')->nullable();
            $table->string('balanceQuantity')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('oh_mi_pi_mi_disposals');
    }
};
