<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEvaluationPeriodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evaluation_periods', function (Blueprint $table) {
            $table->id('period_id'); // Auto-increment primary key
            $table->string('semester'); // e.g., 'Fall', 'Spring'
            $table->string('academic_year'); // e.g., '2024-2025'
            $table->date('start_date');
            $table->date('end_date');
            $table->string('status'); // e.g., 'active', 'inactive'
            $table->decimal('student_scoring', 5, 2); // Percentage scoring for students
            $table->decimal('self_scoring', 5, 2);    // Percentage scoring for self
            $table->decimal('peer_scoring', 5, 2);    // Percentage scoring for peers
            $table->decimal('chair_scoring', 5, 2);   // Percentage scoring for chair
            $table->boolean('disseminated'); // Whether the evaluation has been disseminated
            $table->boolean('is_completed');  // Whether the evaluation is completed
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
        Schema::dropIfExists('evaluation_periods');
    }
}
