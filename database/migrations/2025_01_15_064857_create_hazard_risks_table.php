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
            $table->id();
            $table->string('reference');
            $table->string('division'); // New field for Division
            $table->string('location'); // New field for Location/Department
            $table->string('sub_location')->nullable(); // New field for Sub Location
            $table->string('category');
            $table->string('sub_category')->nullable();
            $table->string('observation_type')->nullable();
            $table->text('description');
            $table->enum('risk_level', ['LOW', 'MEDIUM', 'HIGH'])->default('LOW');
            $table->enum('unsafe_act_or_condition', ['UNSAFE_ACT', 'UNSAFE_CONDITION'])->default('UNSAFE_ACT');
            $table->enum('status', ['DRAFT', 'APPROVED', 'DECLINED'])->default('DRAFT');
            $table->string('created_by_user');
            $table->timestamp('created_date')->useCurrent();
            $table->timestamp('due_date')->nullable(); // New field for Due Date
            $table->string('assignee')->nullable(); // New field for Assignee
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('hazard_risks');
    }
};
