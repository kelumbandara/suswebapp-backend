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
        Schema::create('hs_oh_cs_clinical_suites', function (Blueprint $table) {
            $table->id();
            $table->string('patientId')->nullable();
            $table->string('employeeId')->nullable();
            $table->string('employeeName')->nullable();
            $table->string('designation')->nullable();
            $table->string('gender')->nullable();
            $table->string('age')->nullable();
            $table->string('department')->nullable();
            $table->string('SubDepartment')->nullable();
            $table->string('division')->nullable();
            $table->enum('workStatus',['OffDuty', 'OnDuty', 'draft'])->default('draft')->nullable();
            $table->string('symptoms')->nullable();
            $table->string('checkInDate')->nullable();
            $table->string('checkInTime')->nullable();
            $table->string('checkOut')->nullable();
            $table->string('bodyTemperature')->nullable();
            $table->string('weight')->nullable();
            $table->string('height')->nullable();
            $table->boolean('useFeetAndInches')->nullable();
            $table->integer('feet')->nullable();
            $table->integer('inches')->nullable();
            $table->string('bloodPressure')->nullable();
            $table->string('randomBloodSugar')->nullable();
            $table->string('consultingDoctor')->nullable();
            $table->string('clinicDivision')->nullable();
            $table->enum('Status',['pending', 'approved', 'rejected',])->default('pending')->nullable();
            $table->string('createdByUser')->nullable();
            $table->string('assigneeLevel')->nullable()->default('1');
            $table->string('responsibleSection')->nullable()->default('ClinicalSuites');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hs_oh_cs_clinical_suites');
    }
};
