<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('hs_ai_accident_people', function (Blueprint $table) {
            $table->id('personId');
            $table->bigInteger('accidentId')->unsigned(); 
            $table->string('personType')->nullable();
            $table->string('employeeId')->nullable();
            $table->string('personName')->nullable();
            $table->enum('gender', ['male', 'female'])->default('male')->nullable();
            $table->integer('age')->nullable();
            $table->date('dateOfJoin')->nullable();
            $table->string('duration')->nullable();
            $table->enum('experience', ['skill', 'unskilled','semiskilled','draft'])->default('draft')->nullable();
            $table->string('designation')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hs_ai_accident_people');
    }
};
