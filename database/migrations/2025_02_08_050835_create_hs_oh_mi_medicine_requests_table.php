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
            $table->string('MedicineName')->nullable(); 
            $table->string('GenericName')->nullable();
            $table->string('division')->nullable();
            $table->string('Approver')->nullable();
            $table->string('ReferenceNumber')->nullable();
            $table->string('InventoryNumber')->nullable();
            $table->string('RequestedDate')->nullable();
            $table->enum('status',['draft', 'open', 'closed'])->default('draft')->nullable();
            $table->string('responsibleSection')->nullable()->default('Documents');
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
