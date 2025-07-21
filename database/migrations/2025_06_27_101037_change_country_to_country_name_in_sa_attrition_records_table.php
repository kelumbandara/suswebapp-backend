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
        Schema::table('sa_attrition_records', function (Blueprint $table) {
            $table->dropColumn('country');
            $table->json('countryName')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sa_attrition_records', function (Blueprint $table) {
            $table->dropColumn('countryName');
            $table->string('country')->nullable();
        });
    }
};
