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
        Schema::table('sa_cm_purchase_inventory_records', function (Blueprint $table) {
           $table->string('publishedBy')->nullable()->after('approvedBy');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sa_cm_purchase_inventory_records', function (Blueprint $table) {
             $table->dropColumn('publishedBy');
        });
    }
};
