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
        Schema::create('hs_ai_accident_records', function (Blueprint $table) {
            $table->id();
            $table->string('referenceNumber')->nullable()->unique();
            $table->string('division')->nullable();
            $table->string('location')->nullable();
            $table->string('department')->nullable();
            $table->string('supervisor')->nullable();
            $table->string('imageUrl')->nullable();
            $table->string('category')->nullable();
            $table->string('subCategory')->nullable();
            $table->string('accidentType')->nullable();
            $table->string('primaryRegion')->nullable();
            $table->string('secondaryRegion')->nullable();
            $table->string('tertiaryRegion')->nullable();
            $table->string('cause')->nullable();
            $table->string('hospital')->nullable();
            $table->string('consultedDoctor')->nullable();
            $table->string('description')->nullable();
            $table->enum('status',['draft', 'open', 'closed'])->default('draft')->nullable();
            $table->string('workPerformance')->nullable();
            $table->string('accessToken')->nullable();
            $table->date('accidentDate')->nullable();
            $table->time('accidentTime')->nullable();
            $table->string('injuryType')->nullable();
            $table->string('severity')->nullable();
            $table->string('assignee')->nullable();
            $table->date('expectedDate')->nullable();
            $table->time('expectedTime')->nullable();
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('hs_ai_accident_records');
    }
};
