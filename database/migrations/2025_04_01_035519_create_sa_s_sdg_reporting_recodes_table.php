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
        Schema::create('sa_s_sdg_reporting_recodes', function (Blueprint $table) {
            $table->id();
            $table->string('referenceNumber')->nullable();
            $table->string('title')->nullable();
            $table->string('location')->nullable();
            $table->string('division')->nullable();
            $table->json('pillars')->nullable();
            $table->string('timeLines')->nullable();
            $table->enum('status',['pending', 'approved', 'rejected','published','shipped','draft'])->default('draft')->nullable();
            $table->json('materialityType')->nullable();
            $table->json('materialityIssue')->nullable();
            $table->string('sdg')->nullable();
            $table->json('additionalSdg')->nullable();
            $table->string('alignmentSdg')->nullable();
            $table->string('griStandards')->nullable();
            $table->string('organizer')->nullable();
            $table->string('volunteer')->nullable();
            $table->string('priority')->nullable();
            $table->string('contributing')->nullable();
            $table->json('documents')->nullable();
            $table->string('responsibleSection')->nullable()->default('SDGReportingRecodes');
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
        Schema::dropIfExists('sa_s_sdg_reporting_recodes');
    }
};
