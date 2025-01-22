<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_courses', function (Blueprint $table) {
            $table->foreignId('student_id')->constrained('students', 'student_id')->onDelete('cascade'); // Foreign key to students table
            $table->foreignId('course_section_id')->constrained('course_sections', 'course_section_id')->onDelete('cascade'); // Foreign key to course_sections table
            $table->timestamps(); // created_at, updated_at
            $table->softDeletes(); // Soft delete column (deleted_at)
            $table->unique(['student_id', 'course_section_id'], 'student_course_unique'); // Composite unique constraint
        });        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_courses');
    }
}

