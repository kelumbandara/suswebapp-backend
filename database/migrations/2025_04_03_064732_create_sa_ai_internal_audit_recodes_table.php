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
        Schema::create('sa_ai_internal_audit_recodes', function (Blueprint $table) {
            $table->id();
            $table->string('referenceNumber')->nullable();
            $table->string('division')->nullable();
            $table->integer('auditId')->nullable();
            $table->string('auditType')->nullable();
            $table->json('department')->nullable();
            $table->boolean('isAuditScheduledForSupplier')->nullable();
            $table->string('supplierType')->nullable();
            $table->string('factoryLicenseNo')->nullable();
            $table->string('higgId')->nullable();
            $table->string('zdhcId')->nullable();
            $table->string('processType')->nullable();
            $table->string('factoryName')->nullable();
            $table->string('factoryAddress')->nullable();
            $table->string('factoryContactPersonId')->nullable();
            $table->string('factoryContactNumber')->nullable();
            $table->string('factoryEmail')->nullable();
            $table->string('designation')->nullable();
            $table->string('description')->nullable();
            $table->integer('auditeeId')->nullable();
            $table->integer('approverId')->nullable();
            $table->string('auditDate')->nullable();
            $table->string('dateForApproval')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected', 'published', 'ongoing', 'draft', 'scheduled', 'completed'])->default('draft')->nullable();
            $table->string('responsibleSection')->nullable()->default('SDGReportingRecodes');
            $table->string('assigneeLevel')->nullable()->default('1');
            $table->integer('createdByUser')->nullable();
            $table->integer('updatedByUser')->nullable();
            $table->integer('scheduledBy')->nullable();
            $table->integer('ongoingBy')->nullable();
            $table->integer('completedBy')->nullable();
            $table->integer('draftBy')->nullable();
            $table->string('draftAt')->nullable();
            $table->string('scheduledAt')->nullable();
            $table->string('ongoingAt')->nullable();
            $table->string('completedAt')->nullable();


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sa_ai_internal_audit_recodes');
    }
};
