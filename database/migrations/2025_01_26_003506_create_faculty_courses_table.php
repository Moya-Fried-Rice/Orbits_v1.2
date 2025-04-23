<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('faculty_courses', function (Blueprint $table) {
            $table->id('faculty_course_id');
            $table->foreignId('faculty_id')->constrained('faculties', 'faculty_id')->onDelete('cascade'); // Foreign key to students table
            $table->foreignId('course_section_id')->constrained('course_sections', 'course_section_id')->onDelete('cascade'); // Foreign key to course_sections table
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            $table->softDeletes(); // Soft delete column (deleted_at)
            $table->unique(['faculty_id', 'course_section_id'], 'faculty_course_unique'); // Composite unique constraint
            // Ensure a course_section_id can only have one faculty_id
            $table->unique('course_section_id', 'unique_course_section_faculty');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('faculty_courses');
    }
};
