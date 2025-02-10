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
        Schema::create('hs_oh_mr_benefit_requests', function (Blueprint $table) {
            $table->id();
            $table->string('employeeId')->nullable();
            $table->string('employeeName')->nullable();
            $table->string('applicationId')->nullable();
            $table->string('applicationDate')->nullable();
            $table->string('reJoinDate')->nullable();
            $table->enum('status',['pending', 'approved', 'rejected',])->default('pending')->nullable();
            $table->integer('age')->nullable();
            $table->integer('contactNumber')->nullable();
            $table->string('designation')->nullable();
            $table->string('department')->nullable();
            $table->string('supervisorOrManager')->nullable();
            $table->string('dateOfJoin')->nullable();
            $table->integer('averageWages')->nullable();
            $table->string('division')->nullable();
            $table->string('remarks')->nullable();
            $table->string('expectedDeliveryDate')->nullable();
            $table->string('leaveStatus')->nullable();
            $table->string('leaveStartDate')->nullable();
            $table->string('leaveEndDate')->nullable();
            $table->string('actualDeliveryDate')->nullable();
            $table->string('noticeDateAfterDelivery')->nullable();
            $table->string('supportProvider')->nullable();
            $table->string('responsibleSection')->nullable()->default('BenefitRequest');
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
        Schema::dropIfExists('hs_oh_mr_benefit_requests');
    }
};
