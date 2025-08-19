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
        Schema::table('hs_hr_hazard_risks', function (Blueprint $table) {
            $table->string('control')->nullable()->after('responsibleSection');
            $table->decimal('cost', 12, 2)->nullable()->after('control');
            $table->text('actionTaken')->nullable()->after('cost');
            $table->text('remarks')->nullable()->after('actionTaken');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hs_hr_hazard_risks', function (Blueprint $table) {
            //
        });
    }
};
