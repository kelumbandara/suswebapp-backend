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
        Schema::create('hazard_risks', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key
            $table->string('reference_id')->unique(); // New column for prefixed identifier
            $table->string('division');
            $table->string('locationOrDepartment');
            $table->string('subLocation')->nullable();
            $table->string('category');
            $table->string('subCategory')->nullable();
            $table->string('observationType')->nullable();
            $table->text('description');
            $table->enum('riskLevel', ['LOW', 'MEDIUM', 'HIGH'])->default('LOW');
            $table->enum('unsafeActOrCondition', ['UNSAFE_ACT', 'UNSAFE_CONDITION'])->default('UNSAFE_ACT');
            $table->enum('status', ['DRAFT', 'APPROVED', 'DECLINED'])->default('DRAFT');
            $table->string('createdByUser');
            $table->timestamp('createdDate')->useCurrent();
            $table->timestamp('dueDate')->nullable();
            $table->string('assignee')->nullable();
            $table->string('document')->nullable();
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('hazard_risks');
    }
};
