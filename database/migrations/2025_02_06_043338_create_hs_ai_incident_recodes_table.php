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
        Schema::create('hs_ai_incident_recodes', function (Blueprint $table) {
            $table->id();
            $table->string('referenceNumber')->required()->unique();
            $table->string('createdByUser')->nullable();
            $table->string('division')->required();
            $table->string('location')->nullable();
            $table->string('circumstances')->nullable();
            $table->string('imageUrl')->nullable();
            $table->string('typeOfNearMiss')->nullable();
            $table->string('typeOfConcern')->nullable();
            $table->string('factors')->nullable();
            $table->string('causes')->nullable();
            $table->string('incidentDetails')->nullable();
            $table->string('incidentTime')->nullable();
            $table->string('incidentDate')->nullable();
            $table->enum('status',['draft', 'open', 'closed'])->default('draft')->nullable();
            $table->string('severity')->nullable();
            $table->string('assignee')->nullable();
            $table->string('createdUserLevel')->nullable();
            $table->string('responsibleSection')->nullable()->default('AccidentReport');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hs_ai_incident_recodes');
    }
};
