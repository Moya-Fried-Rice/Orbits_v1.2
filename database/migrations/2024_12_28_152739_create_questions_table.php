<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id('question_id'); // Auto-increment primary key
            $table->string('question_text'); // Text of the question
            $table->string('question_code')->unique(); // Unique code for the question
            $table->foreignId('criteria_id')->constrained('question_criteria', 'criteria_id')->onDelete('cascade'); // Foreign key to the question_criteria table
            $table->timestamps(); // created_at, updated_at
            $table->softDeletes(); // Soft delete column (deleted_at)
        });        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('questions');
    }
}
