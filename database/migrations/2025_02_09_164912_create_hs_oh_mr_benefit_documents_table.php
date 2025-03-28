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
        Schema::create('hs_oh_mr_benefit_documents', function (Blueprint $table) {
            $table->id('documentId');
            $table->bigInteger('benefitId')->nullable();
            $table->string('documentType')->nullable();
            $table->json('document')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hs_oh_mr_benefit_documents');
    }
};
