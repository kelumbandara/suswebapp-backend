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
        Schema::create('sa_rag_records', function (Blueprint $table) {
            $table->id();
            $table->string('referenceNumber')->nullable();
            $table->string('employeeType')->nullable();
            $table->string('employeeId')->nullable();
            $table->string('employeeName')->nullable();
            $table->string('division')->nullable();
            $table->string('dateOfJoin')->nullable();
            $table->string('designation')->nullable();
            $table->string('department')->nullable();
            $table->string('gender')->nullable();
            $table->integer('age')->nullable();
            $table->string('dateOfBirth')->nullable();
            $table->string('servicePeriod')->nullable();
            $table->string('tenureSplit')->nullable();
            $table->string('sourceOfHiring')->nullable();
            $table->string('function')->nullable();
            $table->string('reportingManager')->nullable();
            $table->string('country')->nullable();
            $table->string('state')->nullable();
            $table->string('origin')->nullable();
            $table->string('category')->nullable();
            $table->string('discussionSummary')->nullable();
            $table->string('remark')->nullable();
            $table->string('employmentType')->nullable();
            $table->enum('status', ['inprogress', 'approved', 'rejected', 'published', 'ongoing', 'draft', 'scheduled', 'completed', 'open'])->default('draft')->nullable();
            $table->integer('createdByUser')->nullable();
            $table->integer('updatedBy')->nullable();
            $table->integer('rejectedBy')->nullable();
            $table->integer('inprogressBy')->nullable();
            $table->integer('approvedBy')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sa_rag_records');
    }
};
