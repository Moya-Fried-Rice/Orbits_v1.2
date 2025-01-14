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
        Schema::dropIfExists('question_criteria');
    }
}

