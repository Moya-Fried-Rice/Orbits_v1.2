<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

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
            $table->decimal('student_scoring', 5, 2)->default(0.00); // Percentage scoring for students (default to 0.00)
            $table->decimal('self_scoring', 5, 2)->default(0.00);    // Percentage scoring for self (default to 0.00)
            $table->decimal('peer_scoring', 5, 2)->default(0.00);    // Percentage scoring for peers (default to 0.00)
            $table->decimal('chair_scoring', 5, 2)->default(0.00);   // Percentage scoring for chair (default to 0.00)
            $table->boolean('disseminated')->default(false); // Whether the evaluation has been disseminated (default to false)
            $table->boolean('is_completed')->default(false);  // Whether the evaluation is completed (default to false)
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            $table->softDeletes(); // Add soft deletes (deleted_at column)
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
