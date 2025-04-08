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
        Schema::create('sa_ai_ia_question_recodes', function (Blueprint $table) {
            $table->id();
            $table->string('referenceNumber')->nullable();
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected', 'published', 'shipped', 'draft'])->default('draft')->nullable();
            $table->string('responsibleSection')->nullable()->default('QuestionRecodes');
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
        Schema::dropIfExists('sa_ai_ia_question_recodes');
    }
};
