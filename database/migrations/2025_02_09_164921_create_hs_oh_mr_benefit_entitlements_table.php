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
        Schema::create('hs_oh_mr_benefit_entitlements', function (Blueprint $table) {
            $table->id('entitlementId');
            $table->bigInteger('benefitRequestId')->nullable();
            $table->string('benefitType')->nullable();
            $table->integer('amountValue')->nullable();
            $table->integer('totalDaysPaid')->nullable();
            $table->integer('amount1stInstallment')->nullable();
            $table->string('dateOf1stInstallment')->nullable();
            $table->integer('amount2ndInstallment')->nullable();
            $table->string('dateOf2ndInstallment')->nullable();
            $table->string('ifBenefitReceived')->nullable();
            $table->string('beneficiaryName')->nullable();
            $table->string('beneficiaryAddress')->nullable();
            $table->integer('beneficiaryTotalAmount')->nullable();
            $table->string('beneficiaryDate')->nullable();
            $table->string('description')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hs_oh_mr_benefit_entitlements');
    }
};
