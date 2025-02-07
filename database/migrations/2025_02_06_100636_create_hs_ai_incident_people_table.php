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
        Schema::create('hs_ai_incident_people', function (Blueprint $table) {
            $table->id('personId');
            $table->bigInteger('incidentId')->nullable();
            $table->string('personType')->nullable();
            $table->string('employeeId')->nullable();
            $table->string('name')->nullable();
            $table->enum('gender', ['Male', 'Female'])->default('Male')->nullable();
            $table->integer('age')->nullable();
            $table->string('dateOfJoin')->nullable();
            $table->string('employmentDuration')->nullable();
            $table->enum('industryExperience', ['Skill', 'Unskilled','Semiskilled','draft'])->default('draft')->nullable();
            $table->string('designation')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hs_ai_incident_people');
    }
};
