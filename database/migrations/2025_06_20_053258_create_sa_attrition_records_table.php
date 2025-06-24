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
        Schema::create('sa_attrition_records', function (Blueprint $table) {
            $table->id();
            $table->string('referenceNumber')->nullable();
            $table->string('employeeName')->nullable();
            $table->string('employeeId')->nullable();
            $table->integer('country')->nullable();
            $table->string('state')->nullable();
            $table->string('resignedDate')->nullable();
            $table->string('gender')->nullable();
            $table->string('relievedDate')->nullable();
            $table->string('division')->nullable();
            $table->string('designation')->nullable();
            $table->string('department')->nullable();
            $table->string('perDaySalary')->nullable();
            $table->string('dateOfJoin')->nullable();
            $table->string('employmentClassification')->nullable();
            $table->string('employmentType')->nullable();
            $table->boolean('isHostelAccess')->nullable();
            $table->boolean('isWorkHistory')->nullable();
            $table->string('resignationType')->nullable();
            $table->string('resignationReason')->nullable();
            $table->string('servicePeriod')->nullable();
            $table->string('tenureSplit')->nullable();
            $table->boolean('isNormalResignation')->nullable();
            $table->string('remark')->nullable();
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
        Schema::dropIfExists('sa_attrition_records');
    }
};
