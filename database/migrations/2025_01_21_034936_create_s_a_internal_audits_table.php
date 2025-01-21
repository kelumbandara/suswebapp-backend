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
            $table->string('reference_id')->unique();
            $table->string('division');
            $table->string('department')->nullable();
            $table->string('audit_title');
            $table->string('audit_type');
            $table->boolean('is_supplier_audit');
            $table->string('supplier_type')->nullable();
            $table->string('factory_license_no')->nullable();
            $table->string('higg_id')->nullable();
            $table->string('zdhc_id')->nullable();
            $table->string('process_type')->nullable();
            $table->string('factory_name');
            $table->text('factory_address');
            $table->string('factory_contact_person');
            $table->string('designation');
            $table->string('email');
            $table->string('contact_number');
            $table->date('audit_date')->nullable();
            $table->string('auditee')->nullable();
            $table->string('approver')->nullable();
            $table->date('approval_date')->nullable();
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
