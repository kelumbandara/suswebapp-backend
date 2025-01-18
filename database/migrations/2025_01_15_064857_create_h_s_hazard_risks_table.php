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
        Schema::create('h_s_hazard_risks', function (Blueprint $table) {
            $table->id();
            $table->string('reference_id')->unique();
            $table->string('division');
            $table->string('locationOrDepartment');
            $table->string('subLocation')->nullable();
            $table->string('category');
            $table->string('subCategory')->nullable();
            $table->string('observationType')->nullable();
            $table->text('description');
            $table->enum('riskLevel', ['Low', 'Medium', 'High'])->default('Low');
            $table->enum('unsafeActOrCondition', ['Unsafe Act', 'Unsafe Condition'])->default('Unsafe Act');
            $table->enum('status', ['draft', 'approved', 'declined'])->default('draft');
            $table->string('createdByUser');
            $table->timestamp('createdDate')->useCurrent();
            $table->timestamp('dueDate')->nullable();
            $table->string('assignee')->nullable();
            $table->string('document')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('h_s_hazard_risks');
    }
};
