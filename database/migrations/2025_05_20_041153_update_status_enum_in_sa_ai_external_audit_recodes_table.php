<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('sa_ai_external_audit_recodes', function (Blueprint $table) {
                DB::statement("ALTER TABLE sa_ai_external_audit_recodes MODIFY COLUMN status ENUM('pending', 'approved', 'rejected', 'published', 'shipped', 'draft', 'complete') DEFAULT 'draft'");

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sa_ai_external_audit_recodes', function (Blueprint $table) {
                DB::statement("ALTER TABLE sa_ai_external_audit_recodes MODIFY COLUMN status ENUM('pending', 'approved', 'rejected', 'published', 'shipped', 'draft') DEFAULT 'draft'");

        });
    }
};
