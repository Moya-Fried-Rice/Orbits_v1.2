<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEvaluationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evaluations', function (Blueprint $table) {
            $table->id('evaluation_id'); // Auto-increment primary key
            $table->foreignId('course_section_id')->constrained('course_sections', 'course_section_id')->onDelete('cascade'); // Foreign key to the course_sections table
            $table->foreignId('survey_id')->constrained('surveys', 'survey_id')->onDelete('cascade'); // Foreign key to the surveys table
            $table->foreignId('period_id')->constrained('evaluation_periods', 'period_id')->onDelete('cascade'); // Foreign key to the evaluation_periods table
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
        Schema::dropIfExists('evaluations');
    }
}

