<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentsTable extends Migration
{
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('document_number');
            $table->integer('version_number');
            $table->enum('document_type', ['Certificate and Audit', 'General', 'Risk Assessment', 'Policy and Procedures', 'Legal and Statutory']);
            $table->string('title');
            $table->string('division');
            $table->string('issuing_authority');
            $table->string('document_owner')->nullable();
            $table->string('document_reviewer');
            $table->string('physical_location')->nullable();
            $table->string('remarks')->nullable();
            $table->date('issued_date');
            $table->boolean('is_no_expiry');
            $table->date('expiry_date')->nullable();
            $table->date('notify_date')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('documents');
    }
}
