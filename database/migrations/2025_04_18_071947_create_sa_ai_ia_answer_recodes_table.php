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
        Schema::create('sa_ai_ia_answer_recodes', function (Blueprint $table) {
            $table->id('answerId');
            $table->bigInteger('internalAuditId')->nullable();
            $table->bigInteger('questionRecoId')->nullable();
            $table->bigInteger('queGroupId')->nullable();
            $table->bigInteger('questionId')->nullable();
            $table->string('score');
            $table->integer('status');
            $table->string('rating');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sa_ai_ia_answer_recodes');
    }
};
