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
        Schema::create('sa_ai_internal_audit_factories', function (Blueprint $table) {
            $table->id();
            $table->string('factoryName');
            $table->string('factoryAddress');
            $table->string('factoryContactNumber');
            $table->string('factoryEmail');
            $table->string('designation');
            $table->string('FactoryContactPerson');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sa_ai_internal_audit_factories');
    }
};
