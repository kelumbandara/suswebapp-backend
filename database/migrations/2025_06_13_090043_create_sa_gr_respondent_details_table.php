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
        Schema::create('sa_gr_respondent_details', function (Blueprint $table) {
            $table->id('respondentId');
            $table->string('grievanceId')->nullable();
            $table->string('employeeId')->nullable();
            $table->string('name')->nullable();
            $table->string('designation')->nullable();
            $table->string('department')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sa_gr_respondent_details');
    }
};
