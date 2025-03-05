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
        Schema::create('hs_oh_mi_medicine_requests', function (Blueprint $table) {
            $table->id();
            $table->string('referenceNumber')->nullable();
            $table->string('medicineName')->nullable();
            $table->string('genericName')->nullable();
            $table->string('division')->nullable();
            $table->integer('requestQuantity')->nullable();
            $table->string('approverId')->nullable();
            $table->string('inventoryNumber')->nullable();
            $table->string('requestedDate')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending')->nullable();
            $table->string('responsibleSection')->nullable()->default('medicineRequests');
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
        Schema::dropIfExists('hs_oh_mi_medicine_requests');
    }
};
