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
        Schema::create('benefit_requests', function (Blueprint $table) {
            $table->id()->unique();
            $table->string('employee_id')->nullable();
            $table->string('name');
            $table->integer('age')->nullable();
            $table->string('contact_number')->nullable();
            $table->string('designation');
            $table->string('department');
            $table->string('supervisor_manager')->nullable();
            $table->date('date_of_join');
            $table->decimal('average_wages', 10, 2)->nullable();
            $table->string('application_id')->unique();
            $table->date('application_date');
            $table->date('expected_delivery_date');
            $table->date('leave_start_date');
            $table->date('leave_end_date');
            $table->date('actual_delivery_date')->nullable();
            $table->string('leave_status');
            $table->json('benefits')->nullable();
            $table->date('notice_date_after_delivery');
            $table->date('rejoining_date');
            $table->json('support_provided')->nullable();
            $table->string('division');
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('benefit_requests');
    }
};
