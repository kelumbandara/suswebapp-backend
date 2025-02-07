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
        Schema::create('hs_document_recodes', function (Blueprint $table) {
            $table->id();
            $table->string('documentNumber')->nullable();
            $table->string('versionNumber')->nullable();
            $table->string('documentType')->nullable();
            $table->string('title')->nullable();
            $table->string('division')->nullable();
            $table->string('issuedAuthority')->nullable();
            $table->string('issuedDate')->nullable();
            $table->string('expiryDate')->nullable();
            $table->string('notifyDate')->nullable();
            $table->string('elapseDay')->nullable();
            $table->enum('status',['draft', 'open', 'closed'])->default('draft')->nullable();
            $table->string('documentOwner')->nullable();
            $table->string('documentReviewer')->nullable();
            $table->string('physicalLocation')->nullable();
            $table->string('remarks')->nullable();
            $table->string('document')->nullable();
            $table->boolean('noExpiry')->nullable();
            $table->string('responsibleSection')->nullable()->default('Documents');
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
        Schema::dropIfExists('hs_document_recodes');
    }
};
