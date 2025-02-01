<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

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
            $table->string('description')->unique(); // Description of the criteria
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            $table->foreignId('survey_id')->constrained('surveys', 'survey_id')->onDelete('cascade'); // Foreign key to the departments table with cascade delete
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

