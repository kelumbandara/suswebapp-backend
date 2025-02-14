<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->boolean('isCompanyEmployee')->default(false);
            $table->string('employeeNumber')->nullable()->unique();
            $table->string('mobile')->nullable()->unique();
            $table->rememberToken();
            $table->string('otp')->nullable();
            $table->timestamp('otp_expires_at')->nullable();
            $table->boolean('emailVerifiedAt')->default(false);
            $table->string('userType')->nullable()->default('1');
            $table->string('department')->nullable();
            $table->string('jobPosition')->nullable();
            $table->json('responsibleSection')->nullable();
            $table->integer('assigneeLevel')->default(1)->nullable();
            $table->string('profileImage')->nullable();
            $table->boolean('availability')->default(true);
            $table->json('assignedFactory')->nullable();
            $table->timestamps();
        });

        // Create the password_reset_tokens table
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email');
            $table->string('token');
            $table->timestamp('created_at')->nullable();
            $table->foreign('email')->references('email')->on('users')->onDelete('cascade');
            $table->primary('email');
        });

        // Create the sessions table
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index()->constrained('users')->onDelete('cascade');
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('com_users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
