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
        Schema::create('sa_ai_external_audit_recodes', function (Blueprint $table) {
            $table->id();
            $table->string('referenceNumber')->nullable();
            $table->string('auditType')->nullable();
            $table->string('auditCategory')->nullable();
            $table->string('auditStandard')->nullable();
            $table->string('customer')->nullable();
            $table->string('auditFirm')->nullable();
            $table->string('division')->nullable();
            $table->enum('status',['pending', 'approved', 'rejected','published','shipped','draft'])->default('draft')->nullable();
            $table->string('auditDate')->nullable();
            $table->string('approvalDate')->nullable();
            $table->string('approverId')->nullable();
            $table->string('representorId')->nullable();
            $table->string('announcement')->nullable();
            $table->string('assessmentDate')->nullable();
            $table->string('auditorId')->nullable();
            $table->string('remarks')->nullable();
            $table->string('auditorName')->nullable();
            $table->string('auditExpiryDate')->nullable();
            $table->string('auditStatus')->nullable();
            $table->string('auditScore')->nullable();
            $table->string('gradePeriod')->nullable();
            $table->string('numberOfNonCom')->nullable();
            $table->string('auditFee')->nullable();
            $table->string('auditGrade')->nullable();
            $table->json('documents')->nullable();
            $table->string('responsibleSection')->nullable()->default('ExternalAudits');
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
        Schema::dropIfExists('sa_ai_external_audit_recodes');
    }
};
