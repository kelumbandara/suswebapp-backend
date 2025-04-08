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
        Schema::create('sa_ai_ia_qr_group_recodes', function (Blueprint $table) {
            $table->id("queGroupId");
            $table->bigInteger('quectionRecoId')->nullable();
            $table->string('groupName')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sa_ai_ia_qr_group_recodes');
    }
};
