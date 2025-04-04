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
            $table->json('auditTitle')->nullable();
            $table->string('auditType')->nullable();
            $table->json('department')->nullable();
            $table->boolean('isAuditScheduledForSupplier')->nullable();
            $table->string('supplierType')->nullable();
            $table->string('factoryLicenseNo')->nullable();
            $table->string('higgId')->nullable();
            $table->string('zdhcId')->nullable();
            $table->string('processType')->nullable();
            $table->string('status')->nullable();
            $table->string('factoryName')->nullable();
            $table->string('factoryAddress')->nullable();
            $table->string('factoryContactPerson')->nullable();
            $table->string('factoryContactNumber')->nullable();
            $table->string('factoryEmail')->nullable();
            $table->string('designation')->nullable();
            $table->string('description')->nullable();
            $table->string('auditeeId')->nullable();
            $table->string('approverId')->nullable();
            $table->string('auditDate')->nullable();
            $table->string('dateForApproval')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected', 'published', 'shipped', 'draft'])->default('draft')->nullable();
            $table->string('responsibleSection')->nullable()->default('SDGReportingRecodes');
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
        Schema::dropIfExists('sa_ai_internal_audit_recodes');
    }
};
