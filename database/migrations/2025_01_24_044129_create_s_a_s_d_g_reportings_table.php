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
        Schema::create('s_a_s_d_g_reportings', function (Blueprint $table) {
            $table->id();
            $table->string('ReferenceNumber')->unique();
            $table->string('title');
            $table->string('location');
            $table->string('division');
            $table->string('pillar');
            $table->string('timeLine')->nullable();
            $table->string('materialType');
            $table->string('materialIssue');
            $table->string('sdg');
            $table->string('additionalSDGs')->nullable();
            $table->string('griAndSubStandards')->nullable();
            $table->string('organiser');
            $table->unsignedInteger('volunteersParticipants');
            $table->string('priority')->nullable();
            $table->string('contributing')->nullable();
            $table->string('image_path')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('s_a_s_d_g_reportings');
    }


};
