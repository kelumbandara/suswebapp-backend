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
        Schema::create('sa_cm_chemical_managemant_recodes', function (Blueprint $table) {
            $table->id();
            $table->string('referenceNumber')->nullable();
            $table->string('commercialName')->nullable();
            $table->string('substanceName')->nullable();
            $table->string('reachRegistrationNumber')->nullable();
            $table->string('molecularFormula')->nullable();
            $table->integer('requestQuantity')->nullable();
            $table->string('requestUnit')->nullable();
            $table->string('zdhcCategory')->nullable();
            $table->string('chemicalFormType')->nullable();
            $table->string('whareAndWhyUse')->nullable();
            $table->string('productStandard')->nullable();
            $table->boolean('doYouHaveMSDSorSDS')->nullable();
            $table->string('msdsorsdsIssuedDate')->nullable();
            $table->string('msdsorsdsExpiryDate')->nullable();
            $table->json('documents')->nullable();
            $table->string('division')->nullable();
            $table->string('requestedCustomer')->nullable();
            $table->string('requestedMerchandiser')->nullable();
            $table->string('requestDate')->nullable();
            $table->string('reviewerId')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected', 'published', 'ongoing', 'draft', 'scheduled', 'completed', 'reviewed'])->default('draft')->nullable();
            $table->string('createdByUser')->nullable();
            $table->string('updatedBy')->nullable();
            $table->string('approvedBy')->nullable();
            $table->string('rejectedBy')->nullable();
            $table->string('responsibleSection')->nullable()->default('ChemicalManagement');
            $table->string('assigneeLevel')->nullable()->default('1');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sa_cm_chemical_managemant_recodes');
    }
};
