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
        Schema::create('sa_e_envirement_management_recodes', function (Blueprint $table) {
            $table->id();
            $table->string('referenceNumber')->nullable();
            $table->integer('totalWorkForce')->nullable();
            $table->integer('numberOfDaysWorked')->nullable();
            $table->integer('totalProuctProducedPcs')->nullable();
            $table->integer('totalProuctProducedkg')->nullable();
            $table->string('division')->nullable();
            $table->string('year')->nullable();
            $table->string('month')->nullable();
            $table->string('reviewerId')->nullable();
            $table->string('approverId')->nullable();
            $table->string('area')->nullable();
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
        Schema::dropIfExists('sa_e_envirement_management_recodes');
    }
};
