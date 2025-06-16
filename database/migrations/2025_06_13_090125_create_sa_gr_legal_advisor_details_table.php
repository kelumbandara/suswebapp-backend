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
        Schema::create('sa_gr_legal_advisor_details', function (Blueprint $table) {
            $table->id('legalAdvisorId');
            $table->string('grievanceId')->nullable();
            $table->string('email')->nullable();
            $table->string('name')->nullable();
            $table->integer('phone')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sa_gr_legal_advisor_details');
    }
};
