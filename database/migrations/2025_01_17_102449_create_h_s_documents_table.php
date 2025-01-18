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
            $table->integer('document_number');
            $table->integer('version_number');
            $table->string('document_type');
            $table->string('title');
            $table->string('division');
            $table->string('issuing_authority');
            $table->string('document_owner')->nullable();
            $table->string('document_reviewer');
            $table->string('physical_location')->nullable();
            $table->text('remarks')->nullable();
            $table->string('document')->nullable();
            $table->date('issued_date');
            $table->boolean('is_no_expiry');
            $table->date('expiry_date')->nullable();
            $table->date('notify_date')->nullable();
            $table->enum('status', ['Active', 'Expired'])->default('Active');
            $table->date('created_date')->nullable();
            $table->string('created_by')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('h_s_documents');
    }
};
