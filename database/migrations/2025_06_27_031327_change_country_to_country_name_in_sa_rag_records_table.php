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
        Schema::table('sa_rag_records', function (Blueprint $table) {
            $table->dropColumn('country');
            $table->json('countryName')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sa_rag_records', function (Blueprint $table) {
            Schema::table('sa_rag_records', function (Blueprint $table) {
                $table->dropColumn('countryName');
                $table->string('country')->nullable();
            });
        });
    }
};
