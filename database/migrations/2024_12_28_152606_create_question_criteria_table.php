<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionCriteriaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('question_criteria', function (Blueprint $table) {
            $table->id('criteria_id'); // Auto-increment primary key
            $table->string('description'); // Description of the criteria
            $table->foreignId('survey_id')->constrained('surveys', 'survey_id')->onDelete('cascade'); // Foreign key to the surveys table
            $table->timestamps(); // created_at, updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('question_criteria');
    }
}

