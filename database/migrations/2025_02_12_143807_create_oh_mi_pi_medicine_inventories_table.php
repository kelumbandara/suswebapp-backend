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
        Schema::create('oh_mi_pi_medicine_inventories', function (Blueprint $table) {
            $table->id();
            $table->string('referenceNumber')->nullable();
            $table->string('medicineName')->nullable();
            $table->string('genericName')->nullable();
            $table->string('dosageStrength')->nullable();
            $table->string('form')->nullable();
            $table->string('medicineType')->nullable();
            $table->string('requestedDate')->nullable();
            $table->integer('supplierName')->nullable();
            $table->string('supplierContactNumber')->nullable();
            $table->string('supplierEmail')->nullable();
            $table->string('supplierType')->nullable();
            $table->string('location')->nullable();
            $table->string('manufacturingDate')->nullable();
            $table->string('expiryDate')->nullable();
            $table->string('deliveryDate')->nullable();
            $table->string('deliveryQuantity')->nullable();
            $table->string('deliveryUnit')->nullable();
            $table->string('purchaseAmount')->nullable();
            $table->string('thresholdLimit')->nullable();
            $table->string('invoiceDate')->nullable();
            $table->string('invoiceReference')->nullable();
            $table->string('manufacturerName')->nullable();
            $table->string('batchNumber')->nullable();
            $table->string('reorderThreshold')->nullable();
            $table->string('usageInstruction')->nullable();
            $table->string('division')->nullable();
            $table->enum('status',['pending', 'approved', 'rejected',])->default('pending')->nullable();
            $table->string('requestedBy')->nullable();
            $table->string('approvedBy')->nullable();
            $table->string('responsibleSection')->nullable()->default('medicineInventory');
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
        Schema::dropIfExists('oh_mi_pi_medicine_inventories');
    }
};
