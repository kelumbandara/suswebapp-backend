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
        Schema::create('s_a_internal_audits', function (Blueprint $table) {
            $table->id();
            $table->string('referenceNumber')->unique();
            $table->string('division');
            $table->string('department')->nullable();
            $table->string('auditTitle');
            $table->string('auditType');
            $table->boolean('isNotSupplier');
            $table->string('supplierType')->nullable();
            $table->string('factoryLiNo')->nullable();
            $table->string('higgId')->nullable();
            $table->string('zdhcId')->nullable();
            $table->string('processType')->nullable();
            $table->string('factoryName');
            $table->text('factoryAddress');
            $table->string('factoryContact');
            $table->string('designation');
            $table->string('email');
            $table->string('contactNumber');
            $table->date('auditDate')->nullable();
            $table->string('auditee');
            $table->string('approver');
            $table->enum('status', ['Completed', 'Scheduled'])->default('Completed');
            $table->string('auditStatus')->nullable();
            $table->date('dateApproval')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('s_a_internal_audits');
    }
};
