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
        Schema::table('sa_grievance_records', function (Blueprint $table) {
            $table->string('solutionRemark')->nullable()->after('solutionProvided');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sa_grievance_records', function (Blueprint $table) {
            $table->dropColumn('solutionRemark');

        });
    }
};
