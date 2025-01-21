<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('h_s_documents', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('documentNumber');
            $table->integer('versionNumber');
            $table->string('documentType');
            $table->string('title');
            $table->string('division');
            $table->string('issuingAuthority');
            $table->string('documentOwner')->nullable();
            $table->string('documentReviewer');
            $table->string('physicalLocation')->nullable();
            $table->text('remarks')->nullable();
            $table->string('document')->nullable();
            $table->date('issuedDate');
            $table->boolean('isNoExpiry');
            $table->date('expiryDate')->nullable();
            $table->date('notifyDate')->nullable();
            $table->enum('status', ['Active', 'Expired'])->default('Active');
            $table->date('createdDate')->nullable();
            $table->string('createdBy')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('h_s_documents');
    }
};
