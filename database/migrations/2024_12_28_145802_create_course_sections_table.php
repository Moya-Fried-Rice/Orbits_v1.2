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
            $table->foreignId('program_id')->constrained('programs', 'program_id')->onDelete('cascade'); // Foreign key to the programs table
            $table->foreignId('period_id')->default(1)->constrained('evaluation_periods', 'period_id')->onDelete('cascade'); // Foreign key to the evaluation_periods table with default value 1
            $table->foreignId('faculty_id')->nullable()->constrained('faculties', 'faculty_id')->onDelete('cascade'); // Foreign key to the faculties table
            $table->timestamps(); // created_at, updated_at
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
        Schema::dropIfExists('course_sections');
    }
}
