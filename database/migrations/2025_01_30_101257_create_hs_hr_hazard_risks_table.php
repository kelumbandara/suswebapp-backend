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
        Schema::create('hs_hr_hazard_risks', function (Blueprint $table) {
            $table->id();
            $table->string('referenceNumber')->nullable();
            $table->string('category')->nullable();
            $table->string('subCategory')->nullable();
            $table->string('observationType')->nullable();
            $table->string('division')->nullable();
            $table->string('assignee')->nullable();
            $table->string('createdByUser')->nullable();
            $table->string('locationOrDepartment')->nullable();
            $table->string('subLocation')->nullable();
            $table->string('description')->nullable();
            $table->string('documents')->nullable();
            $table->dateTime('dueDate')->nullable();
            $table->string('condition')->nullable();
            $table->enum('riskLevel', ['Low', 'Medium', 'High'])->default('Low')->nullable();
            $table->enum('unsafeActOrCondition', ['Unsafe Act', 'Unsafe Condition'])->default('Unsafe Act')->nullable();
            $table->enum('status', ['Open',  'draft'])->default('draft')->nullable();
            $table->dateTime('serverDateAndTime')->nullable();
            $table->integer('assigneeLevel')->nullable();
            $table->string('responsibleSection')->nullable()->default('HazardRisks');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hs_hr_hazard_risks');
    }
};
