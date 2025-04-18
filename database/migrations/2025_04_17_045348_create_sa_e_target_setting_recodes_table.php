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
        Schema::create('sa_e_target_setting_recodes', function (Blueprint $table) {
            $table->id();
            $table->string('referenceNumber')->nullable();
            $table->string('division')->nullable();
            $table->string('department')->nullable();
            $table->string('category')->nullable();
            $table->string('source')->nullable();
            $table->integer('baselineConsumption')->nullable();
            $table->integer('ghgEmission')->nullable();
            $table->string('problem')->nullable();
            $table->json('documents')->nullable();
            $table->string('responsibleId')->nullable();
            $table->string('approverId')->nullable();
            $table->string('action')->nullable();
            $table->string('possibilityCategory')->nullable();
            $table->string('opertunity')->nullable();
            $table->integer('implementationCost')->nullable();
            $table->integer('expectedSavings')->nullable();
            $table->integer('targetGHGReduction')->nullable();
            $table->integer('costSavings')->nullable();
            $table->string('implementationTime')->nullable();
            $table->integer('paybackPeriod')->nullable();
            $table->integer('projectLifespan')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected', 'published', 'shipped', 'draft'])->default('draft')->nullable();
            $table->string('responsibleSection')->nullable()->default('EnvirementManagement');
            $table->string('assigneeLevel')->nullable()->default('1');
            $table->string('createdByUser')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sa_e_target_setting_recodes');
    }
};
