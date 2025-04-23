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
        Schema::create('sa_ai_ia_qr_questions', function (Blueprint $table) {
            $table->id('queId');
            $table->bigInteger('queGroupId')->nullable();
            $table->bigInteger('questionRecoId')->nullable();
            $table->string('colorCode')->nullable();
            $table->string('question')->nullable();
            $table->integer('allocatedScore')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sa_ai_ia_qr_questions');
    }
};
