<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateProgramCoursesTable extends Migration
{
    public function up()
    {
        Schema::create('program_courses', function (Blueprint $table) {
            $table->id('program_course_id');
            $table->foreignId('program_id')->constrained('programs', 'program_id')->onDelete('cascade'); // Foreign key to the programs table
            $table->foreignId('course_id')->constrained('courses', 'course_id')->onDelete('cascade'); // Foreign key to the courses table
            $table->integer('year_level');
            $table->integer('semester');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            $table->softDeletes(); // Soft delete column (deleted_at)
            $table->unique(['program_id', 'course_id'], 'unique_program_course');
        });        
    }

    public function down()
    {
        Schema::dropIfExists('program_courses'); // Drop the program_courses table if the migration is rolled back
    }
}
