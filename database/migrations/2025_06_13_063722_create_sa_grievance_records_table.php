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
        Schema::create('sa_grievance_records', function (Blueprint $table) {
            $table->id();
            $table->string('referenceNumber')->nullable();
            $table->string('caseId')->nullable();
            $table->string('type')->nullable();
            $table->string('personType')->nullable();
            $table->string('name')->nullable();
            $table->string('gender')->nullable();
            $table->string('supervisor')->nullable();
            $table->string('employeeId')->nullable();
            $table->string('employeeShift')->nullable();
            $table->string('location')->nullable();
            $table->string('submissionDate')->nullable();
            $table->boolean('isAnonymous')->nullable();
            $table->string('channel')->nullable();
            $table->string('category')->nullable();
            $table->string('topic')->nullable();
            $table->string('submissions')->nullable();
            $table->string('description')->nullable();
            $table->string('dueDate')->nullable();
            $table->string('businessUnit')->nullable();
            $table->string('resolutionDate')->nullable();
            $table->string('remarks')->nullable();
            $table->string('helpDeskPerson')->nullable();
            $table->string('responsibleDepartment')->nullable();
            $table->string('humanRightsViolation')->nullable();
            $table->string('frequencyRate')->nullable();
            $table->string('severityScore')->nullable();
            $table->string('scale')->nullable();
            $table->string('committeeStatement')->nullable();
            $table->string('grievantStatement')->nullable();
            $table->string('tradeUnionRepresentative')->nullable();
            $table->boolean('isFollowUp')->nullable();
            $table->boolean('isAppeal')->nullable();
            $table->string('solutionProvided')->nullable();
            $table->boolean('isIssuesPreviouslyRaised')->nullable();
            $table->json('statementDocuments')->nullable();
            $table->json('investigationCommitteeStatementDocuments')->nullable();
            $table->json('evidence')->nullable();
            $table->string('dateOfJoin')->nullable();
            $table->string('servicePeriod')->nullable();
            $table->string('tenureSplit')->nullable();
            $table->string('designation')->nullable();
            $table->string('department')->nullable();
            $table->string('division')->nullable();
            $table->string('feedback')->nullable();
            $table->integer('stars')->nullable();
            $table->integer('assigneeId')->nullable();
            $table->enum('status', ['inprogress', 'draft', 'completed', 'open'])->default('draft')->nullable();
            $table->integer('createdByUserId')->nullable();
            $table->integer('updatedByUserId')->nullable();
            $table->integer('openedByUserId')->nullable();
            $table->integer('inprogressByUserId')->nullable();
            $table->integer('completedByUserId')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sa_grievance_records');
    }
};
