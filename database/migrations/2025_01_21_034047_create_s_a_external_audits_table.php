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
        Schema::create('s_a_external_audits', function (Blueprint $table) {
            $table->id();
            $table->string('referenceNumber')->unique();
            $table->string('auditorName')->nullable();
            $table->string('auditType');
            $table->string('auditCategory');
            $table->text('customer');
            $table->string('auditStandard');
            $table->string('auditFirm');
            $table->string('division');
            $table->string('representative');
            $table->date('auditDate')->nullable();
            $table->date('expiryDate')->nullable();
            $table->string('approver');
            $table->enum('status', ['draft', 'approved', 'declined'])->default('draft');
            $table->string('announcement');
            $table->date('dateApproval');
            $table->text('description')->nullable();
            $table->string('lapsedStatus')->nullable();
            $table->string('auditStatus')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('s_a_external_audits');
    }
};
