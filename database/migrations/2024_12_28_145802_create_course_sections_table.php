<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_sections', function (Blueprint $table) {
            $table->id('course_section_id'); // Auto-increment primary key
            $table->foreignId('course_id')->constrained('courses', 'course_id')->onDelete('cascade'); // Foreign key to the courses table
            $table->string('section'); // e.g., 'A', 'B', 'C'
            $table->foreignId('period_id')->constrained('evaluation_periods', 'period_id')->onDelete('cascade'); // Foreign key to the evaluation_periods table
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
        Schema::dropIfExists('course_sections');
    }
}
