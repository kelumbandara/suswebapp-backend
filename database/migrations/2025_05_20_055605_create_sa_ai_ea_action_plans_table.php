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
        Schema::create('sa_ai_ea_action_plans', function (Blueprint $table) {
           $table->id('actionPlanId');
            $table->bigInteger('externalAuditId')->nullable();
            $table->string('correctiveOrPreventiveAction')->nullable();
            $table->string('priority')->nullable();
            $table->integer('approverId')->nullable();
            $table->string('targetCompletionDate')->nullable();
            $table->string('dueDate')->nullable();
            $table->string('date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sa_ai_ea_action_plans');
    }
};
