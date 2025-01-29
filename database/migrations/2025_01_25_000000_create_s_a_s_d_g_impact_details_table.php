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
        Schema::create('s_a_s_d_g_impact_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('s_a_s_d_g_reporting_id');
            $table->string('impact_type');
            $table->string('unit');
            $table->decimal('value');
            $table->timestamps();

            $table->foreign('s_a_s_d_g_reporting_id')->references('id')->on('s_a_s_d_g_reportings')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('s_a_s_d_g_impact_details');
    }
};
