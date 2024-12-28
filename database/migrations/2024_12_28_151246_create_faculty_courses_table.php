<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacultyCoursesTable extends Migration
{
    public function up()
    {
        Schema::create('faculty_courses', function (Blueprint $table) {
            $table->foreignId('faculty_id')->constrained('faculties', 'faculty_id')->onDelete('cascade'); // Foreign key to the faculties table, deletes faculty_courses when faculty is deleted
            $table->foreignId('course_section_id')->constrained('course_sections', 'course_section_id')->onDelete('cascade'); // Foreign key to the course_sections table, deletes faculty_courses when course_section is deleted
            $table->timestamps(); // created_at, updated_at

            // Ensure a faculty can only be assigned once to a specific course section
            $table->unique(['faculty_id', 'course_section_id']); // Unique constraint on faculty_id and course_section_id combination
        });
    }

    public function down()
    {
        Schema::dropIfExists('faculty_courses'); // Drop the faculty_courses table if the migration is rolled back
    }
}
