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
        Schema::create('hs_hr_hazard_risks', function (Blueprint $table) {
            $table->id();
            $table->string('referenceNumber')->nullable();
            $table->string('categoryName')->nullable();
            $table->string('subCategory')->nullable();
            $table->string('observationType')->nullable();
            $table->string('divisionName')->nullable();
            $table->string('assigneeName')->nullable();
            $table->string('location')->nullable();
            $table->string('subLocation')->nullable();
            $table->string('description')->nullable();
            $table->string('fileUrl')->nullable();
            $table->dateTime('dueDate')->nullable();
            $table->string('condition')->nullable();
            $table->enum('riskLevel', ['Low', 'Medium', 'High'])->default('Low')->nullable();
            $table->enum('unsafeType', ['unsafeAct', 'UnsafeCondition', 'draft'])->default('draft')->nullable();
            $table->enum('status', ['Open', 'In Progress', 'draft'])->default('draft')->nullable();
            $table->dateTime('serverDateAndTime')->nullable();
            $table->string('assigneeLevel')->nullable();
            $table->string('responsibleSection')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hs_hr_hazard_risks');
    }
};
